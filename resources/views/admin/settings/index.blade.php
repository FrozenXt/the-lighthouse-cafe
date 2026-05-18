@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')

<style>
/* ── Layout ── */
.settings-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
}
@media (min-width: 1024px) {
    .settings-grid { grid-template-columns: 260px 1fr; gap: 1.5rem; }
}

/* ── Sidebar nav ── */
.settings-nav {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
    overflow: hidden;
    position: sticky;
    top: 1.25rem;
    align-self: start;
}
.nav-head {
    padding: 1rem 1.25rem .75rem;
    border-bottom: 1px solid #f1f5f9;
}
.nav-link {
    display: flex;
    align-items: center;
    gap: .65rem;
    padding: .65rem 1.25rem;
    font-size: .82rem;
    font-weight: 600;
    color: #64748b;
    text-decoration: none;
    transition: all .12s;
    border-left: 3px solid transparent;
}
.nav-link:hover { color: #1e293b; background: #f8fafc; }
.nav-link.active { color: #d97706; background: #fffbeb; border-left-color: #f59e0b; }
.nav-link svg { flex-shrink: 0; width: 15px; height: 15px; }

/* ── Panel ── */
.panel {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 1px 4px rgba(0,0,0,.05), 0 4px 14px rgba(0,0,0,.03);
    overflow: hidden;
    scroll-margin-top: 1.5rem;
}
.panel-head {
    padding: 1rem 1.4rem;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: .65rem;
}
.panel-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.panel-body { padding: 1.25rem 1.4rem; }
.panel-title { font-size: .95rem; font-weight: 800; color: #1e293b; font-family: serif; }
.panel-sub   { font-size: .72rem; color: #94a3b8; margin-top: .1rem; }

/* ── Form fields ── */
.field-group {
    display: grid;
    grid-template-columns: 1fr;
    gap: .9rem;
}
@media (min-width: 640px) { .field-group.cols-2 { grid-template-columns: 1fr 1fr; } }
@media (min-width: 640px) { .field-group.cols-3 { grid-template-columns: 1fr 1fr 1fr; } }

.field-label {
    display: block;
    font-size: .75rem;
    font-weight: 700;
    color: #475569;
    margin-bottom: .4rem;
    letter-spacing: .01em;
}
.field-hint { font-size: .7rem; color: #94a3b8; margin-top: .3rem; }
.field-input {
    width: 100%;
    border: 1.5px solid #e2e8f0;
    border-radius: 9px;
    padding: .6rem .85rem;
    font-size: .875rem;
    color: #1e293b;
    background: #fafafa;
    outline: none;
    transition: border-color .15s, box-shadow .15s;
}
.field-input:focus {
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245,158,11,.12);
    background: #fff;
}
.field-input::placeholder { color: #cbd5e1; }

select.field-input { cursor: pointer; }
textarea.field-input { resize: vertical; min-height: 80px; }

/* ── File upload ── */
.file-zone {
    border: 2px dashed #e2e8f0;
    border-radius: 10px;
    padding: 1.1rem;
    text-align: center;
    cursor: pointer;
    transition: border-color .15s, background .15s;
    position: relative;
}
.file-zone:hover { border-color: #f59e0b; background: #fffbeb; }
.file-zone input[type="file"] {
    position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%;
}
.file-zone-icon { font-size: 1.5rem; margin-bottom: .35rem; }
.file-zone-label { font-size: .78rem; font-weight: 600; color: #64748b; }
.file-zone-sub   { font-size: .7rem; color: #94a3b8; margin-top: .2rem; }

.preview-img {
    margin-top: .75rem;
    border-radius: 8px;
    border: 1.5px solid #f1f5f9;
    background: #f8fafc;
    padding: .4rem;
    object-fit: contain;
}

/* ── Toggle switch ── */
.toggle-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: .7rem 0;
    border-bottom: 1px solid #f8fafc;
}
.toggle-row:last-child { border-bottom: none; }
.toggle-info { flex: 1; min-width: 0; padding-right: 1rem; }
.toggle-title { font-size: .85rem; font-weight: 700; color: #334155; }
.toggle-desc  { font-size: .72rem; color: #94a3b8; margin-top: .15rem; }

.toggle {
    position: relative;
    flex-shrink: 0;
    width: 40px; height: 22px;
}
.toggle input { opacity: 0; width: 0; height: 0; position: absolute; }
.toggle-track {
    position: absolute; inset: 0;
    background: #e2e8f0;
    border-radius: 999px;
    cursor: pointer;
    transition: background .2s;
}
.toggle input:checked + .toggle-track { background: #f59e0b; }
.toggle-track::before {
    content: '';
    position: absolute;
    left: 3px; top: 3px;
    width: 16px; height: 16px;
    border-radius: 50%;
    background: #fff;
    transition: transform .2s;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.toggle input:checked + .toggle-track::before { transform: translateX(18px); }

/* ── Color swatch input ── */
.color-field {
    display: flex;
    align-items: center;
    gap: .6rem;
    border: 1.5px solid #e2e8f0;
    border-radius: 9px;
    padding: .45rem .7rem;
    background: #fafafa;
    transition: border-color .15s;
}
.color-field:focus-within { border-color: #f59e0b; }
.color-field input[type="color"] {
    width: 28px; height: 28px;
    border: none; padding: 0; background: none;
    cursor: pointer; border-radius: 6px; overflow: hidden;
}
.color-field input[type="text"] {
    flex: 1; border: none; background: none;
    font-size: .875rem; color: #1e293b;
    outline: none; font-family: monospace;
}

/* ── Save bar ── */
.save-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 1rem 1.4rem;
    background: #f8fafc;
    border-top: 1px solid #f1f5f9;
    flex-wrap: wrap;
}
.btn-save {
    display: inline-flex; align-items: center; gap: .4rem;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #1a1a1a; font-weight: 800; font-size: .875rem;
    padding: .6rem 1.4rem; border-radius: 10px;
    border: none; cursor: pointer; transition: all .15s;
    box-shadow: 0 3px 10px rgba(245,158,11,.35);
}
.btn-save:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(245,158,11,.45); }

.btn-reset {
    display: inline-flex; align-items: center; gap: .4rem;
    background: #fff; color: #64748b; font-weight: 600; font-size: .82rem;
    padding: .6rem 1rem; border-radius: 10px;
    border: 1.5px solid #e2e8f0; cursor: pointer; transition: all .15s;
}
.btn-reset:hover { border-color: #94a3b8; color: #334155; }

/* ── Section divider ── */
.section-divider {
    display: flex; align-items: center; gap: .5rem;
    font-size: .7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .06em; color: #94a3b8; margin: .5rem 0;
}
.section-divider::before,
.section-divider::after {
    content: ''; flex: 1; height: 1px; background: #f1f5f9;
}
</style>

{{-- ── Page Header ── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <div>
        <h1 class="text-xl sm:text-2xl font-serif font-bold text-slate-800">Site Settings</h1>
        <p class="text-xs text-slate-400 mt-0.5">Manage branding, location, delivery & more</p>
    </div>
    @if(session('success'))
        <div class="flex items-center gap-2 text-sm font-semibold text-green-700 bg-green-50 border border-green-200 px-4 py-2 rounded-xl">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            Settings saved successfully
        </div>
    @endif
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="settings-grid">

    {{-- ── Sidebar nav (desktop sticky, hidden on mobile) ── --}}
    <aside class="settings-nav hidden lg:block">
        <div class="nav-head">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Sections</p>
        </div>
        <nav class="py-1.5">
            <a href="#general"   class="nav-link active">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
                General
            </a>
            <a href="#location"  class="nav-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Location
            </a>
            <a href="#branding"  class="nav-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                Branding
            </a>
            <a href="#delivery"  class="nav-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z"/></svg>
                Delivery
            </a>
            <a href="#contact"   class="nav-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Contact
            </a>
            <a href="#hours"     class="nav-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Hours
            </a>
            <a href="#features"  class="nav-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Features
            </a>
        </nav>
    </aside>

    {{-- ── Right: all panels ── --}}
    <div class="space-y-5">

        {{-- 1. GENERAL ── --}}
        <div class="panel" id="general">
            <div class="panel-head">
                <div class="panel-icon" style="background:#eff6ff;">
                    <svg class="w-4 h-4" style="color:#3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
                </div>
                <div>
                    <p class="panel-title">General</p>
                    <p class="panel-sub">Basic site identity and metadata</p>
                </div>
            </div>
            <div class="panel-body">
                <div class="field-group cols-2">
                    <div>
                        <label class="field-label">Site Name <span class="text-red-400">*</span></label>
                        <input type="text" name="site_name" value="{{ $settings['site_name']->value ?? '' }}"
                               placeholder="My Restaurant" class="field-input">
                    </div>
                    <div>
                        <label class="field-label">Tagline</label>
                        <input type="text" name="site_tagline" value="{{ $settings['site_tagline']->value ?? '' }}"
                               placeholder="Fresh. Fast. Delicious." class="field-input">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="field-label">Site Description <span class="text-slate-300 font-normal">(meta)</span></label>
                        <textarea name="site_description" placeholder="A short description shown in search results…" class="field-input">{{ $settings['site_description']->value ?? '' }}</textarea>
                        <p class="field-hint">Shown in Google search previews. Keep under 160 characters.</p>
                    </div>
                    <div>
                        <label class="field-label">Footer Text</label>
                        <input type="text" name="footer_text" value="{{ $settings['footer_text']->value ?? '' }}"
                               placeholder="© 2025 My Restaurant" class="field-input">
                    </div>
                    <div>
                        <label class="field-label">Currency Symbol</label>
                        <input type="text" name="currency_symbol" value="{{ $settings['currency_symbol']->value ?? '$' }}"
                               placeholder="$" class="field-input">
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. RESTAURANT LOCATION ── --}}
        <div class="panel" id="location">
            <div class="panel-head">
                <div class="panel-icon" style="background:#fef3c7;">
                    <svg class="w-4 h-4" style="color:#d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <p class="panel-title">Restaurant Location</p>
                    <p class="panel-sub">Used for map display and delivery distance</p>
                </div>
            </div>
            <div class="panel-body">
                <div class="field-group cols-2">
                    <div>
                        <label class="field-label">Latitude</label>
                        <input type="text" name="restaurant_lat" value="{{ $settings['restaurant_lat']->value ?? '' }}"
                               placeholder="e.g. 42.4220" class="field-input">
                        <p class="field-hint">Decimal degrees — positive = North</p>
                    </div>
                    <div>
                        <label class="field-label">Longitude</label>
                        <input type="text" name="restaurant_lng" value="{{ $settings['restaurant_lng']->value ?? '' }}"
                               placeholder="e.g. -71.1062" class="field-input">
                        <p class="field-hint">Decimal degrees — negative = West</p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="field-label">Full Address</label>
                        <input type="text" name="restaurant_address" value="{{ $settings['restaurant_address']->value ?? '' }}"
                               placeholder="123 Main St, Medford, MA 02155" class="field-input">
                    </div>
                    <div>
                        <label class="field-label">Google Maps Embed URL <span class="text-slate-300 font-normal">(optional)</span></label>
                        <input type="url" name="google_maps_url" value="{{ $settings['google_maps_url']->value ?? '' }}"
                               placeholder="https://maps.google.com/embed?..." class="field-input">
                    </div>
                    <div>
                        <label class="field-label">Max Delivery Radius (km)</label>
                        <input type="number" name="delivery_radius_km" value="{{ $settings['delivery_radius_km']->value ?? '10' }}"
                               min="1" max="100" class="field-input">
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. BRANDING ── --}}
        <div class="panel" id="branding">
            <div class="panel-head">
                <div class="panel-icon" style="background:#f0fdf4;">
                    <svg class="w-4 h-4" style="color:#22c55e;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                </div>
                <div>
                    <p class="panel-title">Branding</p>
                    <p class="panel-sub">Logo, favicon, and color scheme</p>
                </div>
            </div>
            <div class="panel-body">

                <div class="field-group cols-2 mb-5">
                    {{-- Logo --}}
                    <div>
                        <label class="field-label">Logo</label>
                        <div class="file-zone">
                            <input type="file" name="site_logo" accept="image/*">
                            <div class="file-zone-icon">🖼️</div>
                            <p class="file-zone-label">Click to upload logo</p>
                            <p class="file-zone-sub">PNG, SVG, WebP · max 2 MB</p>
                        </div>
                        @if(!empty($settings['site_logo']->value))
                            <img src="{{ Storage::url($settings['site_logo']->value) }}"
                                 class="preview-img h-14 mt-3" alt="Logo preview">
                        @endif
                    </div>

                    {{-- Favicon --}}
                    <div>
                        <label class="field-label">Favicon</label>
                        <div class="file-zone">
                            <input type="file" name="site_favicon" accept="image/*">
                            <div class="file-zone-icon">⭐</div>
                            <p class="file-zone-label">Click to upload favicon</p>
                            <p class="file-zone-sub">ICO, PNG · 32×32 px recommended</p>
                        </div>
                        @if(!empty($settings['site_favicon']->value))
                            <img src="{{ Storage::url($settings['site_favicon']->value) }}"
                                 class="preview-img w-10 h-10 mt-3" alt="Favicon preview">
                        @endif
                    </div>
                </div>

                <div class="section-divider">Colors</div>

                <div class="field-group cols-3 mt-4">
                    <div>
                        <label class="field-label">Primary Color</label>
                        <div class="color-field">
                            <input type="color" name="color_primary_picker"
                                   value="{{ $settings['color_primary']->value ?? '#f59e0b' }}"
                                   oninput="document.getElementById('color_primary_text').value=this.value">
                            <input type="text" id="color_primary_text" name="color_primary"
                                   value="{{ $settings['color_primary']->value ?? '#f59e0b' }}"
                                   maxlength="7" placeholder="#f59e0b">
                        </div>
                    </div>
                    <div>
                        <label class="field-label">Secondary Color</label>
                        <div class="color-field">
                            <input type="color" name="color_secondary_picker"
                                   value="{{ $settings['color_secondary']->value ?? '#1e293b' }}"
                                   oninput="document.getElementById('color_secondary_text').value=this.value">
                            <input type="text" id="color_secondary_text" name="color_secondary"
                                   value="{{ $settings['color_secondary']->value ?? '#1e293b' }}"
                                   maxlength="7" placeholder="#1e293b">
                        </div>
                    </div>
                    <div>
                        <label class="field-label">Accent Color</label>
                        <div class="color-field">
                            <input type="color" name="color_accent_picker"
                                   value="{{ $settings['color_accent']->value ?? '#d97706' }}"
                                   oninput="document.getElementById('color_accent_text').value=this.value">
                            <input type="text" id="color_accent_text" name="color_accent"
                                   value="{{ $settings['color_accent']->value ?? '#d97706' }}"
                                   maxlength="7" placeholder="#d97706">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. DELIVERY ── --}}
        <div class="panel" id="delivery">
            <div class="panel-head">
                <div class="panel-icon" style="background:#faf5ff;">
                    <svg class="w-4 h-4" style="color:#a855f7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                </div>
                <div>
                    <p class="panel-title">Delivery Settings</p>
                    <p class="panel-sub">Fees, minimum order, and timing</p>
                </div>
            </div>
            <div class="panel-body">
                <div class="field-group cols-2">
                    <div>
                        <label class="field-label">Delivery Fee ($)</label>
                        <input type="number" name="delivery_fee" step="0.01" min="0"
                               value="{{ $settings['delivery_fee']->value ?? '5.00' }}" class="field-input">
                    </div>
                    <div>
                        <label class="field-label">Free Delivery Above ($)</label>
                        <input type="number" name="free_delivery_above" step="0.01" min="0"
                               value="{{ $settings['free_delivery_above']->value ?? '' }}"
                               placeholder="e.g. 50.00 (leave blank to disable)" class="field-input">
                    </div>
                    <div>
                        <label class="field-label">Minimum Order Amount ($)</label>
                        <input type="number" name="min_order_amount" step="0.01" min="0"
                               value="{{ $settings['min_order_amount']->value ?? '0' }}" class="field-input">
                    </div>
                    <div>
                        <label class="field-label">Estimated Delivery Time</label>
                        <input type="text" name="delivery_time_estimate"
                               value="{{ $settings['delivery_time_estimate']->value ?? '30–45 min' }}"
                               placeholder="30–45 min" class="field-input">
                    </div>
                    <div>
                        <label class="field-label">Tax Rate (%)</label>
                        <input type="number" name="tax_rate" step="0.1" min="0" max="100"
                               value="{{ $settings['tax_rate']->value ?? '8' }}" class="field-input">
                    </div>
                    <div>
                        <label class="field-label">Order Number Prefix</label>
                        <input type="text" name="order_prefix"
                               value="{{ $settings['order_prefix']->value ?? 'ORD' }}"
                               placeholder="ORD" class="field-input">
                        <p class="field-hint">e.g. ORD-2025-001</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- 5. CONTACT ── --}}
        <div class="panel" id="contact">
            <div class="panel-head">
                <div class="panel-icon" style="background:#fff1f2;">
                    <svg class="w-4 h-4" style="color:#f43f5e;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <p class="panel-title">Contact & Social</p>
                    <p class="panel-sub">Email, phone, and social media links</p>
                </div>
            </div>
            <div class="panel-body">
                <div class="field-group cols-2">
                    <div>
                        <label class="field-label">Contact Email</label>
                        <input type="email" name="contact_email"
                               value="{{ $settings['contact_email']->value ?? '' }}"
                               placeholder="hello@myrestaurant.com" class="field-input">
                    </div>
                    <div>
                        <label class="field-label">Contact Phone</label>
                        <input type="tel" name="contact_phone"
                               value="{{ $settings['contact_phone']->value ?? '' }}"
                               placeholder="+1 (617) 555-0000" class="field-input">
                    </div>
                    <div>
                        <label class="field-label">Instagram URL</label>
                        <input type="url" name="social_instagram"
                               value="{{ $settings['social_instagram']->value ?? '' }}"
                               placeholder="https://instagram.com/..." class="field-input">
                    </div>
                    <div>
                        <label class="field-label">Facebook URL</label>
                        <input type="url" name="social_facebook"
                               value="{{ $settings['social_facebook']->value ?? '' }}"
                               placeholder="https://facebook.com/..." class="field-input">
                    </div>
                    <div>
                        <label class="field-label">Twitter / X URL</label>
                        <input type="url" name="social_twitter"
                               value="{{ $settings['social_twitter']->value ?? '' }}"
                               placeholder="https://x.com/..." class="field-input">
                    </div>
                    <div>
                        <label class="field-label">TikTok URL</label>
                        <input type="url" name="social_tiktok"
                               value="{{ $settings['social_tiktok']->value ?? '' }}"
                               placeholder="https://tiktok.com/@..." class="field-input">
                    </div>
                </div>
            </div>
        </div>

        {{-- 6. HOURS ── --}}
        <div class="panel" id="hours">
            <div class="panel-head">
                <div class="panel-icon" style="background:#ecfdf5;">
                    <svg class="w-4 h-4" style="color:#10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="panel-title">Opening Hours</p>
                    <p class="panel-sub">Set your weekly schedule</p>
                </div>
            </div>
            <div class="panel-body">
                @foreach ([
                    'monday'    => 'Monday',
                    'tuesday'   => 'Tuesday',
                    'wednesday' => 'Wednesday',
                    'thursday'  => 'Thursday',
                    'friday'    => 'Friday',
                    'saturday'  => 'Saturday',
                    'sunday'    => 'Sunday',
                ] as $key => $label)
                <div class="toggle-row" style="gap:.75rem; align-items:center;">
                    <div class="toggle-info" style="min-width:90px;">
                        <p class="toggle-title" style="font-size:.8rem;">{{ $label }}</p>
                    </div>
                    <label class="toggle" title="Open/Closed">
                        <input type="checkbox" name="hours_{{ $key }}_open" value="1"
                               {{ !empty($settings["hours_{$key}_open"]->value) ? 'checked' : '' }}>
                        <div class="toggle-track"></div>
                    </label>
                    <input type="time" name="hours_{{ $key }}_from"
                           value="{{ $settings["hours_{$key}_from"]->value ?? '09:00' }}"
                           class="field-input" style="max-width:110px; padding:.45rem .65rem; font-size:.8rem;">
                    <span class="text-slate-300 text-sm flex-shrink-0">→</span>
                    <input type="time" name="hours_{{ $key }}_to"
                           value="{{ $settings["hours_{$key}_to"]->value ?? '22:00' }}"
                           class="field-input" style="max-width:110px; padding:.45rem .65rem; font-size:.8rem;">
                </div>
                @endforeach
            </div>
        </div>

        {{-- 7. FEATURES ── --}}
        <div class="panel" id="features">
            <div class="panel-head">
                <div class="panel-icon" style="background:#f0f9ff;">
                    <svg class="w-4 h-4" style="color:#0ea5e9;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="panel-title">Features & Toggles</p>
                    <p class="panel-sub">Enable or disable site functionality</p>
                </div>
            </div>
            <div class="panel-body">
                @foreach ([
                    ['key' => 'feature_online_ordering',  'title' => 'Online Ordering',     'desc' => 'Allow customers to place orders through the website'],
                    ['key' => 'feature_stripe_payments',  'title' => 'Stripe / Card Payments','desc'=> 'Enable credit/debit card checkout via Stripe'],
                    ['key' => 'feature_cash_on_delivery',  'title' => 'Cash on Delivery',    'desc' => 'Allow customers to pay cash when order arrives'],
                    ['key' => 'feature_reservations',     'title' => 'Table Reservations',   'desc' => 'Show reservation form to customers'],
                    ['key' => 'feature_reviews',          'title' => 'Customer Reviews',     'desc' => 'Display and collect dish reviews'],
                    ['key' => 'feature_maintenance_mode', 'title' => 'Maintenance Mode',     'desc' => 'Show a maintenance page to all visitors'],
                ] as $f)
                <div class="toggle-row">
                    <div class="toggle-info">
                        <p class="toggle-title">{{ $f['title'] }}</p>
                        <p class="toggle-desc">{{ $f['desc'] }}</p>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" name="{{ $f['key'] }}" value="1"
                               {{ !empty($settings[$f['key']]->value) ? 'checked' : '' }}>
                        <div class="toggle-track"></div>
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Save Bar ── --}}
        <div class="panel">
            <div class="save-bar">
                <p class="text-xs text-slate-400">All changes are applied immediately after saving.</p>
                <div class="flex gap-2 flex-wrap">
                    <button type="reset" class="btn-reset">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reset
                    </button>
                    <button type="submit" class="btn-save">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Settings
                    </button>
                </div>
            </div>
        </div>

    </div>{{-- end right panels --}}
</div>{{-- end settings-grid --}}
</form>

<script>
// Highlight active nav link on scroll
const sections = document.querySelectorAll('.panel[id]');
const navLinks  = document.querySelectorAll('.nav-link');
const observer  = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            navLinks.forEach(l => l.classList.remove('active'));
            const active = document.querySelector(`.nav-link[href="#${e.target.id}"]`);
            if (active) active.classList.add('active');
        }
    });
}, { rootMargin: '-30% 0px -60% 0px' });
sections.forEach(s => observer.observe(s));

// Smooth scroll for nav links
navLinks.forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        document.querySelector(link.getAttribute('href'))?.scrollIntoView({ behavior: 'smooth' });
    });
});
</script>

@endsection
