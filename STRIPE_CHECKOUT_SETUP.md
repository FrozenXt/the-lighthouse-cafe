# Stripe Checkout Setup - Lighthouse Cafe

## Overview
Your Stripe payment gateway is now configured to redirect users to Stripe's hosted checkout page for secure payment processing.

## How It Works

### Flow:
1. **User fills checkout form** → Selects "Card" or "Online" payment method
2. **Click "Place Order"** → Order is created in database with "pending" status
3. **Stripe Session Created** → Backend creates a Stripe Checkout Session with all order details
4. **Redirect to Stripe** → User is redirected to Stripe's secure payment page
5. **User pays** → Enters card details on Stripe (PCI compliant)
6. **Payment confirmed** → Redirected back to your success page
7. **Order marked as paid** → Order status updated to "confirmed" and "paid"

## Configuration Required

### .env File (Already Set)

```

### Test Card
- **Number**: `4242 4242 4242 4242`
- **Expiry**: Any future date (e.g., `12/26`)
- **CVC**: Any 3 digits (e.g., `123`)
- **Result**: Payment succeeds

## Files Modified

### 1. `/app/Http/Controllers/OrderController.php`
- Updated `store()` method to create Stripe Checkout Sessions
- Added `checkoutSuccess()` handler
- Added `checkoutCancel()` handler
- Better error logging and validation

**Key Changes:**
- Creates order first with "pending" status
- For card/online payment: Creates Stripe Session with line items
- Returns JSON with `checkout_url` for JavaScript redirect
- On success: Order marked as "confirmed" and "paid"
- On cancel: User redirected back to checkout page

### 2. `/routes/web.php`
- Added `orders.checkout.success` route
- Added `orders.checkout.cancel` route

### 3. `/resources/views/orders/checkout.blade.php`
- Checkout form with payment method selection
- JavaScript that sends order data to backend
- Handles redirect to Stripe checkout URL
- Supports both Stripe payments and Cash payments

## Testing Checklist

- [ ] Clear browser cache
- [ ] Clear Laravel config: `php artisan config:clear`
- [ ] Go to checkout page
- [ ] Add items to cart
- [ ] Fill in all form fields
- [ ] Select "Card" or "Online" payment
- [ ] Click "Place Order"
- [ ] Should redirect to Stripe checkout page
- [ ] Use test card: `4242 4242 4242 4242`
- [ ] Complete payment
- [ ] Should redirect to success page
- [ ] Order status should be "confirmed" with "paid" payment status

## Troubleshooting

### Issue: Not redirecting to Stripe
**Solution:**
1. Check browser console (F12) for error messages
2. Check Laravel logs: `tail -f storage/logs/laravel.log`
3. Verify Stripe keys in `.env` file
4. Run `php artisan config:clear`

### Issue: Stripe session creation fails
**Possible causes:**
- Invalid Stripe keys
- Network connectivity issue
- Stripe API error (check logs)

**Solution:**
1. Check `.env` file for correct keys
2. Verify keys are from test environment (start with `pk_test_` and `sk_test_`)
3. Check Laravel logs for Stripe error message

### Issue: Success page not showing
**Solution:**
1. Check if order was created in database
2. Verify success URL route is correctly configured
3. Check Laravel logs for "Order payment confirmed" entry

## Payment Processing

### Order Statuses:
- **pending** → Order created, payment pending
- **confirmed** → Payment received, order confirmed
- **preparing** → Kitchen is preparing
- **ready** → Ready for pickup/delivery
- **delivered** → Delivered to customer

### Payment Statuses:
- **pending** → Waiting for payment (cash orders)
- **unpaid** → Stripe order created, awaiting payment
- **paid** → Payment completed

## Security Notes

- Payment information is collected directly by Stripe (PCI DSS Compliant)
- Your server never handles card data
- All communication with Stripe is encrypted
- Metadata is securely stored with each session

## Support

For issues with:
- **Stripe**: Visit https://dashboard.stripe.com
- **Laravel**: Check storage/logs/laravel.log
- **General**: Contact support

---
Last Updated: February 17, 2026
