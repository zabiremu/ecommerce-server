@php
    $uspItems = [
        [
            'title'    => \App\Models\SiteSetting::get('usp_1_title', 'Secure Shopping'),
            'subtitle' => \App\Models\SiteSetting::get('usp_1_subtitle', 'Pay when you receive'),
            'icon'     => '<path d="M12 3l7 3v5c0 4.5-3 8.2-7 9.5-4-1.3-7-5-7-9.5V6l7-3Z" /><path d="M9 12l2 2 4-4" />',
        ],
        [
            'title'    => \App\Models\SiteSetting::get('usp_2_title', 'Fast Delivery'),
            'subtitle' => \App\Models\SiteSetting::get('usp_2_subtitle', 'Nationwide shipping'),
            'icon'     => '<rect x="1" y="7" width="14" height="10" rx="1.5" /><path d="M15 10h4l3 3v4h-7v-7Z" /><circle cx="6" cy="19" r="1.6" /><circle cx="17.5" cy="19" r="1.6" />',
        ],
        [
            'title'    => \App\Models\SiteSetting::get('usp_3_title', 'Easy Returns'),
            'subtitle' => \App\Models\SiteSetting::get('usp_3_subtitle', 'Hassle-free exchange'),
            'icon'     => '<path d="M20 11a8 8 0 1 0-2.7 6" /><path d="M20 5v6h-6" />',
        ],
        [
            'title'    => \App\Models\SiteSetting::get('usp_4_title', '24/7 Support'),
            'subtitle' => \App\Models\SiteSetting::get('usp_4_subtitle', 'Always here to help'),
            'icon'     => '<path d="M4 13a8 8 0 0 1 16 0" /><path d="M4 13v4a2 2 0 0 0 2 2h1v-6H5a1 1 0 0 0-1 1Z" /><path d="M20 13v4a2 2 0 0 1-2 2h-1v-6h1a1 1 0 0 1 2 1Z" />',
        ],
    ];
@endphp
<div class="gms-usp-strip">
    @foreach ($uspItems as $item)
        <div class="gms-usp-item">
            <span class="gms-usp-icon" aria-hidden="true">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    {!! $item['icon'] !!}
                </svg>
            </span>
            <span class="gms-usp-text">
                <strong>{{ $item['title'] }}</strong>
                <span>{{ $item['subtitle'] }}</span>
            </span>
        </div>
    @endforeach
</div>
