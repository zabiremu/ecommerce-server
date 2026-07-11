@extends('Frontend.Layout.app')

@section('content')
    <main id="main-content" class="wd-content-layout content-layout-wrapper container" role="main">

        <div class="wd-content-area site-content">
            <article id="post-591" class="entry-content post-591 page type-page status-publish has-post-thumbnail hentry">

                @include('Frontend.partials.home.hero')
                @include('Frontend.partials.home.categories')
                @include('Frontend.partials.home.best-sellers')
                @include('Frontend.partials.home.reviews')
                @include('Frontend.partials.home.featured-products')
                @include('Frontend.partials.home.newsletter')
                @include('Frontend.partials.home.instagram-feed')

            </article>

        </div>

    </main>
@endsection
