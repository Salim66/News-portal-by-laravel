@php
    $language = App\Models\Language::where('status', true)->first();
    $latest_news = App\Models\Post::where('language_id', $language->id)->where('post_thumbnail', false)->latest()->get();
    // dd($latest_news);
@endphp

<section class="widget widget_latest_news_thumb">
    @if($language->id == 1)
    <h3 class="widget-title">Latest news</h3>
    @elseif($language->id == 2)
   <h3 class="widget-title">সর্বশেষ সংবাদ</h3>
   @endif

   @foreach($latest_news as $key => $news)
    @if($key < 10)
    @php
        $featured_info = json_decode($news->featured);
        // dd($featured_info);
    @endphp
    <article class="item">
        @if($news->post_type == 'Image')
        <a href="{{ route('single.news', $news->slug) }}" class="thumb">
        <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">   
        </a>
        @endif
        @if($news->post_type == 'Gallery')
        <a href="{{ route('single.news', $news->slug) }}" class="thumb">
        <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
        </a>
        @endif
        @if($news->post_type == 'Video')
        <a href="{{ route('single.news', $news->slug) }}" class="thumb">
        <iframe class="home-latest__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
        </a>
        @endif
        @if($news->post_type == 'Audio')
        <a href="{{ route('single.news', $news->slug) }}" class="thumb">
        <iframe class="home-latest__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
        </a>
        @endif
        </a>
        <div class="info">
            <h4 class="title usmall"><a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a></h4>
            <span>{{ date('d F Y', strtotime($news->created_at)) }}</span>
        </div>
    </article>
    @endif
   @endforeach
</section>