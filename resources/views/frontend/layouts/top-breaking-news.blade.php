@php
    $language = App\Models\Language::where('status', true)->first();
    $latest_news = App\Models\Post::where('language_id', $language->id)->where('post_thumbnail', false)->latest()->get();
    // dd($latest_news);
@endphp
<div class="col-lg-6">
    <div class="breaking-news-content">
        @if($language->id == 1)
        <h6 class="breaking-title">
           Breaking News:
        </h6>
        @elseif($language->id == 2)
        <h6 class="breaking-title">
          সদ্যপ্রাপ্ত সংবাদ:
        </h6>
       @endif
       <div class="breaking-news-slides owl-carousel owl-theme">
        @foreach($latest_news as $key => $news)
        @if($key < 2)
          <div class="single-breaking-news">
             <p>
                <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
             </p>
          </div>
        @endif
        @endforeach

       </div>
    </div>
 </div>
