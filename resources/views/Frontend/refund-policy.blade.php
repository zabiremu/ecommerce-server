@extends('Frontend.Layout.app')

@section('content')
<section class="breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}">Home</a>
        <i class="fas fa-chevron-right"></i>
        <span>{{ $page?->title ?? 'Refund Policy' }}</span>
    </div>
</section>

<section class="page-header">
    <div class="container">
        <h1>
            <i class="{{ $page?->icon ?? 'fas fa-undo-alt' }}"></i>
            {{ $page?->title ?? 'Refund & Return Policy' }}
        </h1>
        @if ($page?->subtitle)
            <p>{{ $page->subtitle }}</p>
        @endif
    </div>
</section>

<section class="policy-section">
    <div class="container">
        <div class="policy-card">
            @if ($page?->last_updated_label)
                <p class="policy-date">Last updated: {{ $page->last_updated_label }}</p>
            @endif

            @if ($page?->content)
                <div class="policy-content">
                    {!! $page->content !!}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
