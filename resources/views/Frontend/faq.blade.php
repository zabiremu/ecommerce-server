@extends('Frontend.Layout.app')

@section('content')
<section class="breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}">Home</a>
        <i class="fas fa-chevron-right"></i>
        <span>{{ $page?->title ?? 'FAQ' }}</span>
    </div>
</section>

<section class="page-header">
    <div class="container">
        <h1>
            <i class="{{ $page?->icon ?? 'fas fa-circle-question' }}"></i>
            {{ $page?->title ?? 'Frequently Asked Questions' }}
        </h1>
        @if ($page?->subtitle)
            <p>{{ $page->subtitle }}</p>
        @endif
    </div>
</section>

<section class="policy-section">
    <div class="container">
        <div class="policy-card">
            @if ($page?->content)
                <div class="policy-content">
                    {!! $page->content !!}
                </div>
            @else
                <p>Our FAQ content is being updated. Please check back soon, or <a href="{{ route('contact') }}">contact us</a> with any questions.</p>
            @endif
        </div>
    </div>
</section>
@endsection
