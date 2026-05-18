@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
.checkout-page { font-family: 'DM Sans', sans-serif; }
.checkout-page h1 { font-family: 'Playfair Display', serif; }

.step-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.06);
    border: 1px solid #f1f5f9;
    padding: 1.75rem;
    transition: box-shadow .2s;
}
.step-card:focus-within { box-shadow: 0 4px 24px rgba(245,158,11,.12); }

.field-input {
    width: 100%;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    color: #1e293b;
    font-size: .925rem;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
    background: #fafafa;
}
.field-input:focus {
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245,158,11,.15);
    background: #fff;
}

.pay-card {
    border: 2px solid #e2e8f0;
    border-radius: 14px;
    padding: 1.25rem;
    cursor: pointer;
    transition: all .2s;
    background: #fff;
    text-align: center;
}
.pay-card:hover { border-color: #94a3b8; background: #f8fafc; }
.pay-card.selected { border-color: #f59e0b; background: #fffbeb; }

.item-img {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    object-fit: cover;
    border: 1px solid #f1f5f9;
    flex-shrink: 0;
}
.item-placeholder {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1.2rem;
}

.summary-panel {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,.1);
    position: sticky;
    top: 1.5rem;
}

.submit-btn {
    width: 100%;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #1a1a1a;
    font-weight: 700;
    font-size: 1rem;
    padding: 1rem;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    transition: all .2s;
    box-shadow: 0 4px 14px rgba(245,158,11,.4);
}
.submit-btn:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(245,158,11,.5);
}
.submit-btn:disabled { opacity: .55; cursor: not-allowed; transform: none; }

.step-num {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff;
    width: 28px; height: 28px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: .8rem;
    font-weight: 700;
    flex-shrink: 0;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}
.fu1 { animation: fadeUp .4s ease .05s both; }
.fu2 { animation: fadeUp .4s ease .12s both; }
.fu3 { animation: fadeUp .4s ease .18s both; }

/* ── Map picker styles ── */
#delivery-map {
    width: 100%;
    height: 160px;
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    z-index: 1;
    transition: border-color .2s;
}
#delivery-map:hover { border-color: #cbd5e1; }

.map-hint {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: .72rem;
    color: #b0bec5;
    margin-top: 4px;
    line-height: 1.3;
}
.map-hint svg { flex-shrink: 0; width: 11px; height: 11px; }

.locate-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 0.32rem 0.7rem;
    border: 1.5px solid #e2e8f0;
    border-radius: 7px;
    background: #fff;
    font-size: .75rem;
    font-weight: 600;
    color: #64748b;
    cursor: pointer;
    transition: all .15s;
    white-space: nowrap;
}
.locate-btn svg { width: 11px; height: 11px; }
.locate-btn:hover { border-color: #f59e0b; color: #d97706; background: #fffbeb; }
</style>

<!-- Hero -->
<div class="relative h-52 bg-cover bg-center"
    style="background-image: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=1920&h=400&fit=crop');">
    <div class="absolute inset-0" style="background:linear-gradient(120deg,rgba(15,23,42,.92) 40%,rgba(30,41,59,.6));"></div>
    <div class="relative h-full flex items-end pb-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <p class="text-amber-400 text-xs font-semibold uppercase tracking-widest mb-1">Almost there</p>
            <h1 class="text-4xl md:text-5xl font-bold text-white">Checkout</h1>
        </div>
    </div>
</div>

<section class="py-12 checkout-page" style="background:#f8fafc; min-height:100vh;">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8" x-data="checkoutForm()">

        <!-- Empty cart state -->
        <div x-show="cartEmpty" class="text-center py-20">
            <p class="text-slate-400 text-lg">Your cart is empty. Redirecting...</p>
        </div>

        <div x-show="!cartEmpty">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                <!-- LEFT: Steps -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Step 1: Details -->
                    <div class="step-card fu1">
                        <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-3" style="font-family:'Playfair Display',serif;">
                            <span class="step-num">1</span> Your Details
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-600 mb-1.5">Full Name <span class="text-red-400">*</span></label>
                                <input type="text" x-model="customerName" placeholder="John Appleseed" class="field-input">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-600 mb-1.5">Email Address <span class="text-red-400">*</span></label>
                                <input type="email" x-model="customerEmail" placeholder="you@example.com" class="field-input">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-600 mb-1.5">Phone Number <span class="text-red-400">*</span></label>
                                <input type="tel" x-model="customerPhone" placeholder="+1 (555) 000-0000" class="field-input">
                            </div>

                            {{-- ── Delivery location picker ── --}}
                            <div class="md:col-span-2"
                                 x-data="checkoutLocation()"
                                 x-init="init()">

                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="block text-sm font-semibold text-slate-600">
                                        Delivery Location <span class="text-red-400">*</span>
                                    </label>
                                    <button type="button" class="locate-btn" @click="detectLocation()">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/>
                                        </svg>
                                        Use my location
                                    </button>
                                </div>

                                <!-- Map -->
                                <div id="delivery-map"></div>

                                <div class="map-hint">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z"/>
                                    </svg>
                                    Drag the pin or click anywhere to set your delivery spot.
                                </div>

                                <!-- Address textarea (auto-filled, editable) -->
                                <div class="mt-3">
                                    <textarea
                                        x-model="address"
                                        @input="geocodeAddress()"
                                        rows="2"
                                        placeholder="Address will appear here after you place the pin…"
                                        class="field-input resize-none">
                                    </textarea>
                                </div>

                                <!-- Hidden coordinate fields -->
                                <input type="hidden" name="latitude"  x-model="latitude"  x-ref="lat">
                                <input type="hidden" name="longitude" x-model="longitude" x-ref="lng">
                            </div>
                            {{-- ── end delivery picker ── --}}

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-600 mb-1.5">
                                    Special Instructions
                                    <span class="text-slate-400 font-normal ml-1">(optional)</span>
                                </label>
                                <textarea x-model="specialInstructions" rows="2" placeholder="Allergies, preferences, gate code..." class="field-input resize-none"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Payment -->
                    <div class="step-card fu2">
                        <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-3" style="font-family:'Playfair Display',serif;">
                            <span class="step-num">2</span> Payment Method
                        </h2>
                        <div class="grid grid-cols-2 gap-4">
                            <button type="button" @click="paymentMethod = 'cash'"
                                :class="paymentMethod === 'cash' ? 'selected' : ''"
                                class="pay-card">
                                <div class="text-3xl mb-2">🏠</div>
                                <div class="font-semibold text-slate-800 text-sm">Cash on Delivery</div>
                                <div class="text-xs text-slate-400 mt-1">Pay when you receive</div>
                            </button>
                            <button type="button" @click="paymentMethod = 'card'"
                                :class="paymentMethod === 'card' ? 'selected' : ''"
                                class="pay-card">
                                <div class="text-3xl mb-2">💳</div>
                                <div class="font-semibold text-slate-800 text-sm">Card / Online</div>
                                <div class="text-xs text-slate-400 mt-1">Secure via Stripe</div>
                            </button>
                        </div>
                        <div x-show="paymentMethod === 'card'" x-transition
                            class="mt-4 rounded-xl p-4 flex items-start gap-3"
                            style="background:#eff6ff; border:1px solid #bfdbfe;">
                            <svg class="w-5 h-5 mt-0.5 shrink-0" style="color:#3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z"/>
                            </svg>
                            <p class="text-sm" style="color:#1d4ed8;">You'll be securely redirected to Stripe to complete your payment. Your card details are never stored on our servers.</p>
                        </div>
                    </div>

                    <!-- Step 3: mobile order review -->
                    <div class="step-card fu3 lg:hidden">
                        <h2 class="text-xl font-bold text-slate-800 mb-5 flex items-center gap-3" style="font-family:'Playfair Display',serif;">
                            <span class="step-num">3</span> Your Order
                        </h2>
                        <div class="space-y-3">
                            <template x-for="item in cart" :key="item.id">
                                <div class="flex items-center gap-3">
                                    <img x-show="item.image" :src="item.image" :alt="item.name" class="item-img">
                                    <div class="item-placeholder" x-show="!item.image">🍽️</div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-slate-800 text-sm truncate" x-text="item.name"></p>
                                        <p class="text-xs text-slate-400">x<span x-text="item.quantity"></span></p>
                                    </div>
                                    <span class="text-sm font-bold text-amber-600">
                                        $<span x-text="(item.price * item.quantity).toFixed(2)"></span>
                                    </span>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>

                <!-- RIGHT: Summary sidebar (desktop) -->
                <div class="lg:col-span-1 hidden lg:block">
                    <div class="summary-panel">

                        <!-- Dark header -->
                        <div style="background:linear-gradient(135deg,#1e293b,#0f172a); padding:1.5rem 1.75rem;">
                            <p class="text-amber-400 text-xs font-semibold uppercase tracking-widest mb-1">Review</p>
                            <h2 class="text-xl font-bold text-white" style="font-family:'Playfair Display',serif;">Your Order</h2>
                        </div>

                        <!-- Items + totals -->
                        <div style="background:#fff; padding:1.5rem 1.75rem;">

                            <!-- Cart items with images -->
                            <div class="space-y-3 mb-5" style="max-height:280px; overflow-y:auto;">
                                <template x-for="item in cart" :key="item.id">
                                    <div class="flex items-center gap-3">
                                        <img x-show="item.image" :src="item.image" :alt="item.name" class="item-img">
                                        <div class="item-placeholder" x-show="!item.image">🍽️</div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-slate-800 text-sm leading-tight" x-text="item.name"></p>
                                            <p class="text-xs text-slate-400 mt-0.5">
                                                <span x-text="item.quantity"></span> &times;
                                                $<span x-text="parseFloat(item.price).toFixed(2)"></span>
                                            </p>
                                        </div>
                                        <span class="text-sm font-bold text-amber-600 shrink-0">
                                            $<span x-text="(item.price * item.quantity).toFixed(2)"></span>
                                        </span>
                                    </div>
                                </template>
                            </div>

                            <!-- Dashed divider -->
                            <div style="border-top:1.5px dashed #e2e8f0; margin-bottom:1rem;"></div>

                            <!-- Totals -->
                            <div class="space-y-2 text-sm mb-5">
                                <div class="flex justify-between text-slate-500">
                                    <span>Subtotal</span>
                                    <span>$<span x-text="subtotal.toFixed(2)"></span></span>
                                </div>
                              <div class="flex justify-between text-slate-500">
    <span>Tax (<span x-text="taxRate"></span>%)</span>
    <span>$<span x-text="tax.toFixed(2)"></span></span>
</div>

<div class="flex justify-between text-slate-500">
    <span>Delivery Fee</span>
    <span>$<span x-text="deliveryFee.toFixed(2)"></span></span>
</div>
                                <div class="flex justify-between font-bold text-base pt-3" style="border-top:2px solid #f1f5f9;">
                                    <span class="text-slate-800">Total</span>
                                    <span style="color:#d97706; font-size:1.15rem;">$<span x-text="total.toFixed(2)"></span></span>
                                </div>
                            </div>

                            <!-- Error -->
                            <div x-show="errorMessage" x-transition
                                class="mb-4 rounded-lg p-3 text-sm"
                                style="background:#fef2f2; border:1px solid #fecaca; color:#dc2626;">
                                <p x-text="errorMessage"></p>
                            </div>

                            <!-- Submit -->
                            <button type="button" @click="submitPayment()" :disabled="loading" class="submit-btn">
                                <span x-show="!loading" class="flex items-center justify-center gap-2">
                                    <span x-show="paymentMethod === 'cash'">🏠 Place Order</span>
                                    <span x-show="paymentMethod === 'card'">💳 Pay via Stripe</span>
                                    <span>— $<span x-text="total.toFixed(2)"></span></span>
                                </span>
                                <span x-show="loading" class="flex items-center justify-center gap-2">
                                    <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                    </svg>
                                    Processing...
                                </span>
                            </button>

                            <p class="text-center text-xs mt-3" style="color:#94a3b8;">
                                🔒 Your information is safe and encrypted
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Mobile fixed bottom bar -->
                <div class="lg:hidden fixed bottom-0 left-0 right-0 z-50 p-4"
                    style="background:rgba(255,255,255,.96); backdrop-filter:blur(8px); border-top:1px solid #e2e8f0; box-shadow:0 -4px 24px rgba(0,0,0,.08);">
                    <div x-show="errorMessage" class="mb-2 text-xs text-red-600 text-center" x-text="errorMessage"></div>
                    <div class="flex items-center justify-between mb-2 text-sm">
                        <span class="text-slate-500">Total</span>
                        <span class="font-bold text-amber-600 text-lg">$<span x-text="total.toFixed(2)"></span></span>
                    </div>
                    <button type="button" @click="submitPayment()" :disabled="loading" class="submit-btn">
                        <span x-show="!loading" class="flex items-center justify-center gap-2">
                            <span x-show="paymentMethod === 'cash'">🏠 Place Order</span>
                            <span x-show="paymentMethod === 'card'">💳 Pay via Stripe</span>
                        </span>
                        <span x-show="loading" class="flex items-center justify-center gap-2">
                            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>

                <!-- Spacer for mobile bar -->
                <div class="lg:hidden h-28"></div>

            </div>
        </div>
    </div>
</section>

<script>
window.taxRate = {{ site_setting('tax_rate', 8) }};
    window.deliveryFeeValue = {{ site_setting('delivery_fee', 5) }};
// ─────────────────────────────────────────────
// 🗺  RESTAURANT LOCATION — change these two values to your restaurant's coordinates
// ─────────────────────────────────────────────
const RESTAURANT_LAT = 27.7172;   // e.g. Kathmandu lat
const RESTAURANT_LNG = 85.3240;   // e.g. Kathmandu lng
const RESTAURANT_NAME = 'Our Restaurant'; // shown on the fixed restaurant marker
// ─────────────────────────────────────────────

function checkoutLocation() {
    return {
        address: '',
        latitude: null,
        longitude: null,

        _map: null,
        _marker: null,
        _geocodeTimer: null,

        init() {
            // Wait one tick so Alpine has rendered the DOM
            this.$nextTick(() => this._initMap());
        },

        _initMap() {
            const map = L.map('delivery-map', {
                center: [RESTAURANT_LAT, RESTAURANT_LNG],
                zoom: 15,
                zoomControl: true,
            });
            this._map = map;

            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> © <a href="https://carto.com/">CARTO</a>',
                subdomains: 'abcd',
                maxZoom: 19,
            }).addTo(map);

            // Fixed restaurant marker (red)
            const restaurantIcon = L.divIcon({
                html: `<div style="
                    background:#ef4444; color:#fff;
                    border-radius:50% 50% 50% 0;
                    width:26px; height:26px;
                    display:flex; align-items:center; justify-content:center;
                    font-size:13px;
                    transform:rotate(-45deg);
                    box-shadow:0 2px 6px rgba(0,0,0,.25);
                    border:2px solid #fff;">
                    <span style="transform:rotate(45deg)">🍽️</span>
                </div>`,
                iconSize: [26, 26],
                iconAnchor: [13, 26],
                className: '',
            });
            L.marker([RESTAURANT_LAT, RESTAURANT_LNG], { icon: restaurantIcon })
                .addTo(map)
                .bindPopup(`<strong style="font-size:.8rem">${RESTAURANT_NAME}</strong><br><span style="font-size:.72rem;color:#64748b">Your order starts here</span>`, { offset: [0, -22] })
                .openPopup();

            // Draggable delivery marker (amber)
            const deliveryIcon = L.divIcon({
                html: `<div style="
                    background:linear-gradient(135deg,#f59e0b,#d97706);
                    border-radius:50% 50% 50% 0;
                    width:30px; height:30px;
                    display:flex; align-items:center; justify-content:center;
                    font-size:15px;
                    transform:rotate(-45deg);
                    box-shadow:0 2px 8px rgba(245,158,11,.45);
                    border:2px solid #fff;">
                    <span style="transform:rotate(45deg)">📍</span>
                </div>`,
                iconSize: [30, 30],
                iconAnchor: [15, 30],
                className: '',
            });

            // Place delivery marker at restaurant position initially
            const marker = L.marker([RESTAURANT_LAT, RESTAURANT_LNG], {
                icon: deliveryIcon,
                draggable: true,
            }).addTo(map).bindPopup('<span style="font-size:.75rem">Drag me to your delivery address</span>', { offset: [0, -26] });
            this._marker = marker;

            // Update on drag end
            marker.on('dragend', (e) => {
                const { lat, lng } = e.target.getLatLng();
                this.latitude  = lat;
                this.longitude = lng;
                this._reverseGeocode(lat, lng);
            });

            // Click anywhere on map to move marker
            map.on('click', (e) => {
                const { lat, lng } = e.latlng;
                marker.setLatLng([lat, lng]);
                this.latitude  = lat;
                this.longitude = lng;
                this._reverseGeocode(lat, lng);
            });
        },

        // Reverse geocode lat/lng → address string
        async _reverseGeocode(lat, lng) {
            try {
                const res = await fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`,
                    { headers: { 'Accept-Language': 'en' } }
                );
                const data = await res.json();
                if (data && data.display_name) {
                    this.address = data.display_name;
                    // Sync to parent checkoutForm via custom event
                    window.dispatchEvent(new CustomEvent('delivery-address-updated', {
                        detail: { address: data.display_name, lat, lng }
                    }));
                }
            } catch (e) {
                console.warn('Reverse geocode failed:', e);
            }
        },

        // Forward geocode typed address → move marker
        geocodeAddress() {
            clearTimeout(this._geocodeTimer);
            if (!this.address.trim() || this.address.length < 5) return;
            this._geocodeTimer = setTimeout(async () => {
                try {
                    const res = await fetch(
                        `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.address)}&limit=1`,
                        { headers: { 'Accept-Language': 'en' } }
                    );
                    const results = await res.json();
                    if (results.length) {
                        const { lat, lon } = results[0];
                        const latlng = [parseFloat(lat), parseFloat(lon)];
                        this._map.setView(latlng, 16);
                        this._marker.setLatLng(latlng);
                        this.latitude  = latlng[0];
                        this.longitude = latlng[1];
                        window.dispatchEvent(new CustomEvent('delivery-address-updated', {
                            detail: { address: this.address, lat: latlng[0], lng: latlng[1] }
                        }));
                    }
                } catch (e) {
                    console.warn('Forward geocode failed:', e);
                }
            }, 800);
        },

        // "Use my location" button
        detectLocation() {
            if (!navigator.geolocation) {
                alert('Geolocation is not supported by your browser.');
                return;
            }
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    const latlng = [lat, lng];
                    this._map.setView(latlng, 17);
                    this._marker.setLatLng(latlng);
                    this.latitude  = lat;
                    this.longitude = lng;
                    this._reverseGeocode(lat, lng);
                },
                (err) => {
                    console.error(err);
                    alert('Could not retrieve your location. Please allow location access or pin your address manually.');
                }
            );
        },
    };
}

// ─────────────────────────────────────────────

function checkoutForm() {
    return {
        paymentMethod: 'cash',
        loading: false,
        errorMessage: '',
        customerName: '',
        customerEmail: '',
        customerPhone: '',
        deliveryAddress: '',   // populated via map picker event
        deliveryLat: null,
        deliveryLng: null,
        specialInstructions: '',
  taxRate: window.taxRate ?? 8,
        baseDeliveryFee: window.deliveryFeeValue ?? 5,
        init() {
            // Listen for address updates from the map picker child component
            window.addEventListener('delivery-address-updated', (e) => {
                this.deliveryAddress = e.detail.address;
                this.deliveryLat     = e.detail.lat;
                this.deliveryLng     = e.detail.lng;
            });

            if (this.cartEmpty) {
                setTimeout(() => {
                    window.location.href = '{{ route("orders.index") }}';
                }, 1500);
            }
        },

        get cart() {
            return JSON.parse(localStorage.getItem('cart') || '[]');
        },
        get subtotal() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        },
      get tax() {
    return this.subtotal * (this.taxRate / 100);
},

get deliveryFee() {
    return this.baseDeliveryFee;
},

get total() {
    return this.subtotal + this.tax + this.deliveryFee;
},
        get cartEmpty() {
            return this.cart.length === 0;
        },

        async submitPayment() {
            this.errorMessage = '';

            if (!this.customerName.trim())    { this.errorMessage = 'Please enter your full name.';        return; }
            if (!this.customerEmail.trim())   { this.errorMessage = 'Please enter your email address.';   return; }
            if (!this.customerPhone.trim())   { this.errorMessage = 'Please enter your phone number.';    return; }
            if (!this.deliveryAddress.trim()) { this.errorMessage = 'Please pin your delivery location on the map.'; return; }
            if (this.cartEmpty)               { this.errorMessage = 'Your cart is empty.';                 return; }

            this.loading = true;

            try {
                const response = await fetch('{{ route("orders.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        customer_name:        this.customerName.trim(),
                        customer_email:       this.customerEmail.trim(),
                        customer_phone:       this.customerPhone.trim(),
                        delivery_address:     this.deliveryAddress.trim(),
                        latitude:             this.deliveryLat,
                        longitude:            this.deliveryLng,
                        payment_method:       this.paymentMethod,
                        special_instructions: this.specialInstructions.trim(),
                        cart:                 JSON.stringify(this.cart),
                    }),
                });

                const data = await response.json();

                if (!data.success) {
                    this.errorMessage = data.message || 'Something went wrong. Please try again.';
                    this.loading = false;
                    return;
                }

                localStorage.removeItem('cart');
                window.dispatchEvent(new CustomEvent('cart-updated'));

                if (this.paymentMethod === 'cash') {
                    window.location.href = data.redirect;
                } else {
                    window.location.href = data.checkout_url;
                }

            } catch (error) {
                console.error('Checkout error:', error);
                this.errorMessage = 'A network error occurred. Please check your connection and try again.';
                this.loading = false;
            }
        }
    }
}
</script>

@endsection
