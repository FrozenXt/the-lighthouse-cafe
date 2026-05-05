<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Exception\ApiErrorException;

class StripeWebhookController extends Controller
{
    /**
     * Handle Stripe webhook events
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            // If webhook secret is not configured, skip signature verification
            if ($endpointSecret) {
                $event = Webhook::constructEvent(
                    $payload,
                    $sigHeader,
                    $endpointSecret
                );
            } else {
                // For development/testing without webhook secret
                $event = json_decode($payload, true);
                Log::warning('Stripe webhook processed without signature verification. Configure STRIPE_WEBHOOK_SECRET for production.');
            }

            // Handle the event
            switch ($event['type']) {
                case 'checkout.session.completed':
                    $this->handleCheckoutSessionCompleted($event['data']['object']);
                    break;

                case 'charge.succeeded':
                    $this->handleChargeSucceeded($event['data']['object']);
                    break;

                case 'charge.failed':
                    $this->handleChargeFailed($event['data']['object']);
                    break;

                case 'payment_intent.succeeded':
                    $this->handlePaymentIntentSucceeded($event['data']['object']);
                    break;

                case 'payment_intent.payment_failed':
                    $this->handlePaymentIntentFailed($event['data']['object']);
                    break;

                default:
                    Log::info('Unhandled webhook event type', ['type' => $event['type']]);
            }

            return response()->json(['success' => true], 200);
        } catch (\UnexpectedValueException $e) {
            Log::error('Stripe webhook signature verification failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Exception $e) {
            Log::error('Stripe webhook processing error', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    /**
     * Handle checkout session completion
     */
    private function handleCheckoutSessionCompleted($session)
    {
        try {
            $orderId = $session['metadata']['order_id'] ?? null;

            if (!$orderId) {
                Log::warning('Checkout session completed but no order_id in metadata', ['session_id' => $session['id']]);
                return;
            }

            $order = Order::find($orderId);

            if (!$order) {
                Log::warning('Order not found for checkout session', ['order_id' => $orderId, 'session_id' => $session['id']]);
                return;
            }

            // Update order status
            $order->update([
                'payment_status' => 'paid',
                'status' => 'confirmed',
                'confirmed_at' => now()
            ]);

            Log::info('Order payment confirmed via webhook', [
                'order_id' => $orderId,
                'session_id' => $session['id'],
                'payment_status' => 'paid'
            ]);
        } catch (\Exception $e) {
            Log::error('Error handling checkout.session.completed', [
                'error' => $e->getMessage(),
                'session_id' => $session['id'] ?? 'unknown'
            ]);
        }
    }

    /**
     * Handle successful charge
     */
    private function handleChargeSucceeded($charge)
    {
        try {
            $orderId = $charge['metadata']['order_id'] ?? null;

            if (!$orderId) {
                Log::info('Charge succeeded but no order_id in metadata', ['charge_id' => $charge['id']]);
                return;
            }

            $order = Order::find($orderId);

            if ($order && $order->payment_status !== 'paid') {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                    'confirmed_at' => now()
                ]);

                Log::info('Order payment confirmed via charge.succeeded', [
                    'order_id' => $orderId,
                    'charge_id' => $charge['id']
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error handling charge.succeeded', [
                'error' => $e->getMessage(),
                'charge_id' => $charge['id'] ?? 'unknown'
            ]);
        }
    }

    /**
     * Handle failed charge
     */
    private function handleChargeFailed($charge)
    {
        try {
            $orderId = $charge['metadata']['order_id'] ?? null;

            if (!$orderId) {
                Log::warning('Charge failed but no order_id in metadata', ['charge_id' => $charge['id']]);
                return;
            }

            $order = Order::find($orderId);

            if ($order) {
                $order->update([
                    'payment_status' => 'failed'
                ]);

                Log::warning('Order payment failed', [
                    'order_id' => $orderId,
                    'charge_id' => $charge['id'],
                    'failure_message' => $charge['failure_message'] ?? 'Unknown'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error handling charge.failed', [
                'error' => $e->getMessage(),
                'charge_id' => $charge['id'] ?? 'unknown'
            ]);
        }
    }

    /**
     * Handle successful payment intent
     */
    private function handlePaymentIntentSucceeded($paymentIntent)
    {
        try {
            $metadata = $paymentIntent['metadata'] ?? [];
            $orderId = $metadata['order_id'] ?? null;

            if (!$orderId) {
                Log::info('Payment intent succeeded but no order_id in metadata', ['payment_intent_id' => $paymentIntent['id']]);
                return;
            }

            $order = Order::find($orderId);

            if ($order && $order->payment_status !== 'paid') {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                    'confirmed_at' => now()
                ]);

                Log::info('Order payment confirmed via payment_intent.succeeded', [
                    'order_id' => $orderId,
                    'payment_intent_id' => $paymentIntent['id']
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error handling payment_intent.succeeded', [
                'error' => $e->getMessage(),
                'payment_intent_id' => $paymentIntent['id'] ?? 'unknown'
            ]);
        }
    }

    /**
     * Handle failed payment intent
     */
    private function handlePaymentIntentFailed($paymentIntent)
    {
        try {
            $metadata = $paymentIntent['metadata'] ?? [];
            $orderId = $metadata['order_id'] ?? null;

            if (!$orderId) {
                Log::warning('Payment intent failed but no order_id in metadata', ['payment_intent_id' => $paymentIntent['id']]);
                return;
            }

            $order = Order::find($orderId);

            if ($order) {
                $order->update([
                    'payment_status' => 'failed'
                ]);

                Log::warning('Order payment failed via payment_intent.payment_failed', [
                    'order_id' => $orderId,
                    'payment_intent_id' => $paymentIntent['id'],
                    'last_payment_error' => $paymentIntent['last_payment_error']['message'] ?? 'Unknown error'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error handling payment_intent.payment_failed', [
                'error' => $e->getMessage(),
                'payment_intent_id' => $paymentIntent['id'] ?? 'unknown'
            ]);
        }
    }
}
