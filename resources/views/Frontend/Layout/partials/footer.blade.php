@php
    $ss = $siteSettings ?? [];
    $socialLinks = [
        'facebook'  => ['icon' => 'fab fa-facebook-f', 'url' => $ss['social_facebook']  ?? ''],
        'youtube'   => ['icon' => 'fab fa-youtube',    'url' => $ss['social_youtube']   ?? ''],
        'whatsapp'  => ['icon' => 'fab fa-whatsapp',   'url' => $ss['social_whatsapp']  ?? ''],
        'instagram' => ['icon' => 'fab fa-instagram',  'url' => $ss['social_instagram'] ?? ''],
    ];
    $companyName    = $ss['company_name']    ?? 'NF Shop 24';
    $companyTagline = $ss['company_tagline'] ?? 'NF Shop 24 — Largest E-commerce platform in Bangladesh. Quality products at the best prices with reliable delivery across the country.';
    $contactAddress = $ss['contact_address'] ?? 'Chittagong, Bangladesh';
    $contactEmail   = $ss['contact_email']   ?? '';
    $contactPhone   = $ss['contact_phone']   ?? '';
    $contactHours   = $ss['contact_hours']   ?? '';
    $developerName  = $ss['developer_name']  ?? '';
    $developerUrl   = $ss['developer_url']   ?: '#';
@endphp

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div>
            <img src="{{ asset('backend/assets/images/b590a397-1dfa-4237-8d00-6c2712a2b6c8-removebg-preview.png') }}" alt="{{ $companyName }}" style="height:72px;margin-bottom:14px;">
            <p>{{ $companyTagline }}</p>
            <div class="social">
                @foreach ($socialLinks as $link)
                    @if (!empty($link['url']))
                        <a href="{{ $link['url'] }}" target="_blank" rel="noopener"><i class="{{ $link['icon'] }}"></i></a>
                    @endif
                @endforeach
            </div>
        </div>
        <div>
            <h3>Quick Links</h3>
            <ul>
                <li><a href="{{ route('home') }}"><i class="fas fa-chevron-right"></i> Home</a></li>
                <li><a href="{{ route('all-products') }}"><i class="fas fa-chevron-right"></i> All Products</a></li>
                <li><a href="{{ route('about') }}"><i class="fas fa-chevron-right"></i> About Us</a></li>
                <li><a href="{{ route('contact') }}"><i class="fas fa-chevron-right"></i> Contact</a></li>
                <li><a href="{{ route('track-order') }}"><i class="fas fa-chevron-right"></i> Track Order</a></li>
            </ul>
        </div>
        <div>
            <h3>Categories</h3>
            <ul>
                @forelse (($footerCategories ?? collect()) as $cat)
                    <li><a href="{{ route('category-products') }}?cat={{ $cat->slug }}"><i class="fas fa-chevron-right"></i> {{ $cat->name }}</a></li>
                @empty
                    <li><a href="{{ route('all-products') }}"><i class="fas fa-chevron-right"></i> Browse All</a></li>
                @endforelse
            </ul>
        </div>
        <div>
            <h3>Policies</h3>
            <ul>
                <li><a href="{{ route('privacy-policy') }}"><i class="fas fa-chevron-right"></i> Privacy Policy</a></li>
                <li><a href="{{ route('terms-conditions') }}"><i class="fas fa-chevron-right"></i> Terms & Conditions</a></li>
                <li><a href="{{ route('refund-policy') }}"><i class="fas fa-chevron-right"></i> Refund Policy</a></li>
            </ul>
        </div>
        <div>
            <h3>Contact Info</h3>
            <ul>
                @if ($contactAddress)
                    <li><a href="#"><i class="fas fa-map-marker-alt"></i> {{ $contactAddress }}</a></li>
                @endif
                @if ($contactEmail)
                    <li><a href="mailto:{{ $contactEmail }}"><i class="fas fa-envelope"></i> {{ $contactEmail }}</a></li>
                @endif
                @if ($contactPhone)
                    <li><a href="tel:{{ preg_replace('/\s+/', '', $contactPhone) }}"><i class="fas fa-phone-alt"></i> {{ $contactPhone }}</a></li>
                @endif
                @if ($contactHours)
                    <li><a href="#"><i class="fas fa-clock"></i> {{ $contactHours }}</a></li>
                @endif
            </ul>
        </div>
        <div class="bottom">
            <span>Copyright &copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.</span>
            @if ($developerName)
                <span>Developed by <a href="{{ $developerUrl }}" @if ($developerUrl !== '#') target="_blank" rel="noopener" @endif>{{ $developerName }}</a></span>
            @endif
        </div>
    </div>
</footer>
