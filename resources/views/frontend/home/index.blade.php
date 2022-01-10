@extends('frontend.master')


@section('main-content')
<section class="new-news-area">
    <div class="container">
       <div class="row">
          <div class="col-lg-3">

            @php
                $language = App\Models\Language::where('status', true)->first();
                $latest_news = App\Models\Post::where('language_id', $language->id)->where('post_thumbnail', false)->latest()->get();
                // dd($latest_news);
            @endphp

            @foreach($latest_news as $key => $news)
            @if($key < 2)
                @php
                    $featured_info = json_decode($news->featured);
                    // dd($featured_info);
                @endphp
                <div class="single-new-news">
                    <div class="new-news-image">
                        @if($news->post_type == 'Image')
                            <a href="{{ route('single.news', $news->slug) }}">
                                <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                            </a>
                        @endif
                        @if($news->post_type == 'Gallery')
                            <a href="{{ route('single.news', $news->slug) }}">
                                <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                            </a>
                        @endif
                        @if($news->post_type == 'Video')
                            <a href="{{ route('single.news', $news->slug) }}">
                                <iframe class="top-news__single" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                            </a>
                        @endif
                        @if($news->post_type == 'Audio')
                            <a href="{{ route('single.news', $news->slug) }}">
                                <iframe class="top-news__single" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                            </a>
                        @endif
                    <div class="new-news-content">

                        @foreach($news->categories as $category)
                        <span>{{ $category->name }}</span>
                        @endforeach

                        <h3>
                            <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                        </h3>
                        <p>{{ date('d F Y', strtotime($news->created_at)) }}</p>
                    </div>
                    </div>
                </div>
             @endif
            @endforeach

          </div>

          @php
                $language = App\Models\Language::where('status', true)->first();
                $thumbnail_post = App\Models\Post::where('language_id', $language->id)->where('post_thumbnail', true)->latest()->first();
                // dd($latest_news);
            @endphp
          <div class="col-lg-6">
             <div class="single-new-news-box">
                <div class="new-news-image">

                    @php
                        $featured_info = json_decode($thumbnail_post->featured);
                        // dd($featured_info);
                    @endphp

                        @if($thumbnail_post->post_type == 'Image')
                            <a href="{{ route('single.news', $thumbnail_post->slug) }}">
                                <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                            </a>
                        @endif
                        @if($thumbnail_post->post_type == 'Gallery')
                            <a href="{{ route('single.news', $thumbnail_post->slug) }}">
                                <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                            </a>
                        @endif
                        @if($thumbnail_post->post_type == 'Video')
                            <a href="{{ route('single.news', $thumbnail_post->slug) }}">
                                <iframe class="home-latest__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                            </a>
                        @endif
                        @if($thumbnail_post->post_type == 'Audio')
                            <a href="{{ route('single.news', $thumbnail_post->slug) }}">
                                <iframe class="home-latest__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                            </a>
                        @endif
                   <div class="new-news-content">
                       @foreach ($thumbnail_post->categories as $category)
                       <span>{{ $category->name }}</span>
                       @endforeach
                      <h3>
                         <a href="{{ route('single.news', $thumbnail_post->slug) }}">{{ $thumbnail_post->title }}</a>
                      </h3>
                      <p>{{ date('d F Y', strtotime($thumbnail_post->created_at)) }}</p>
                   </div>
                </div>
             </div>
          </div>

          <div class="col-lg-3">
             <div class="daily-briefing-item">
                <div class="title">
                   @if($language->id == 1)
                   <h3>Daily briefing</h3>
                   @elseif($language->id == 2)
                   <h3>দৈনন্দিন ব্রিফিং</h3>
                   @endif
                </div>
                @foreach($latest_news as $key => $news)
                    @if($key >= 2 && $key < 5)
                        @php
                            $featured_info = json_decode($news->featured);
                            // dd($featured_info);
                        @endphp

                        <div class="daily-briefing-content">
                        @foreach($news->categories as $category)
                        <span>{{ $category->name }}</span>,
                        @endforeach
                        <h4>
                            <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                        </h4>
                        <p>{{ date('d F Y', strtotime($news->created_at)) }}</p>
                        </div>

                    @endif
                @endforeach

             </div>
          </div>
       </div>
    </div>
</section>
<section class="default-news-area">
    <div class="container">
       <div class="row">
          <div class="col-lg-8">
             <div class="most-popular-news">
                <div class="section-title">
                   @if($language->id == 1)
                   <h2>Most popular</h2>
                   @elseif($language->id == 2)
                   <h2>সবচেয়ে জনপ্রিয়</h2>
                   @endif
                </div>
                <div class="row">
                    
                    @php
                        $most_popular = App\Models\Post::where('language_id', $language->id)->where('post_type', '!=', 'Video')->where('post_type', '!=', 'Audio')->orderBy('views', 'desc')->get();
                    @endphp

                    @foreach($most_popular as $key => $news)
                    @if($key < 2)
                     @php
                        $featured_info = json_decode($news->featured);
                        // dd($featured_info);
                     @endphp
                     
                     <div class="col-lg-6 col-md-6">
                        <div class="single-most-popular-news">
                           <div class="popular-news-image">
                            @if($news->post_type == 'Image')
                                <a href="{{ route('single.news', $news->slug) }}">
                                    <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                </a>
                            @endif
                            @if($news->post_type == 'Gallery')
                                <a href="{{ route('single.news', $news->slug) }}">
                                    <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                </a>
                            @endif
                            @if($news->post_type == 'Video')
                                <a href="{{ route('single.news', $news->slug) }}">
                                    <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                </a>
                            @endif
                            @if($news->post_type == 'Audio')
                                <a href="{{ route('single.news', $news->slug) }}">
                                    <iframe class="top-video__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                </a>
                            @endif
                           </div>
                           <div class="popular-news-content">
                            @foreach($news->categories as $category)
                                <span>{{ $category->name }}</span>
                            @endforeach
                              <h3>
                                 <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                              </h3>
                              <p>{{ date('d F Y', strtotime($news->created_at)) }}</p>
                           </div>
                        </div>
                     </div>
                   @endif
                   @endforeach
            

                   @foreach($most_popular as $key => $news)
                    @if($key >= 2 && $key <6 )
                     @php
                        $featured_info = json_decode($news->featured);
                        // dd($featured_info);
                     @endphp
                   
                     <div class="col-lg-6">
                        <div class="most-popular-post">
                            <div class="row align-items-center">
                                <div class="col-lg-4 col-sm-4">
                                <div class="post-image">
                                    @if($news->post_type == 'Image')
                                        <a href="{{ route('single.news', $news->slug) }}">
                                            <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                        </a>
                                    @endif
                                    @if($news->post_type == 'Gallery')
                                        <a href="{{ route('single.news', $news->slug) }}">
                                            <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                        </a>
                                    @endif
                                    @if($news->post_type == 'Video')
                                        <a href="{{ route('single.news', $news->slug) }}">
                                            <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                        </a>
                                    @endif
                                    @if($news->post_type == 'Audio')
                                        <a href="{{ route('single.news', $news->slug) }}">
                                            <iframe class="top-video__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                        </a>
                                    @endif
                                </div>
                                </div>
                                <div class="col-lg-8 col-sm-8">
                                <div class="post-content">
                                    @foreach($news->categories as $category)
                                        <span>{{ $category->name }}</span>
                                    @endforeach
                                    <h3>
                                        <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                                    </h3>
                                    <p>{{ date('d F Y', strtotime($news->created_at)) }}</p>
                                </div>
                                </div>
                            </div>
                        </div>
                     </div>
                    @endif
                   @endforeach
                   
                </div>
             </div>

             @php
                $top_video = App\Models\Post::where('language_id', $language->id)->where('post_type', 'Video')->orderBy('views', 'desc')->get();
                // dd($top_video);
             @endphp

             <div class="video-news">
                <div class="section-title">
                   @if($language->id == 1)
                   <h2>Top video</h2>
                   @elseif($language->id == 2)
                   <h2>শীর্ষ ভিডিও</h2>
                   @endif
                </div>
                <div class="video-slides owl-carousel owl-theme">
                    @foreach($top_video as $video)
                    @php
                        $featured_info = json_decode($video->featured);
                        // dd($featured_info);
                    @endphp
                   <div class="video-item">
                      <div class="video-news-image">
                        @if($video->post_type == 'Video')
                        <a href="{{ route('single.news', $news->slug) }}">
                            <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                        </a>
                        @endif
                         <a href="{{ $featured_info->post_video }}" class="popup-youtube">
                         <i class='bx bx-play-circle'></i>
                         </a>
                      </div>
                      <div class="video-news-content">
                         <h3>
                            <a href="{{ route('single.news', $video->slug) }}">{{ $video->title }}</a>
                         </h3>
                         <span>{{ date('d F Y', strtotime($video->created_at)) }}</span>
                      </div>
                   </div>
                   @endforeach
                </div>
             </div>
             <div class="politics-news">
                <div class="section-title">
                    @if($language->id == 1)
                    <h2>Politics</h2>
                    @elseif($language->id == 2)
                    <h2>রাজনীতি</h2>
                    @endif
                </div>
                @if($language->id == 1)

                    @php
                        $category = App\Models\Category::where('slug', 'Politics')->first();      
                    @endphp

                <div class="row">
                    <div class="col-lg-6">

                        @foreach($category->posts as $key => $news)
                            @if($key >= 1 && $key < 4)
                                @php
                                    $featured_info = json_decode($news->featured);
                                @endphp
                                <div class="politics-news-post">
                                    <div class="row align-items-center">
                                        <div class="col-lg-4 col-sm-4">
                                        <div class="politics-news-image">
                                            @if($news->post_type == 'Image')
                                                <a href="{{ route('single.news', $news->slug) }}">
                                                    <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                                </a>
                                            @endif
                                            @if($news->post_type == 'Gallery')
                                                <a href="{{ route('single.news', $news->slug) }}">
                                                    <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                                </a>
                                            @endif
                                            @if($news->post_type == 'Video')
                                                <a href="{{ route('single.news', $news->slug) }}">
                                                    <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                                </a>
                                            @endif
                                            @if($news->post_type == 'Audio')
                                                <a href="{{ route('single.news', $news->slug) }}">
                                                    <iframe class="top-video__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                                </a>
                                            @endif
                                        </div>
                                        </div>
                                        <div class="col-lg-8 col-sm-8">
                                        <div class="politics-news-content">
                                            <h3>
                                                <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a> 
                                            </h3>
                                            <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach


                    </div>
                    @foreach($category->posts as $key => $news)
                    @if($key < 1)
                    @php
                        $featured_info = json_decode($news->featured);
                    @endphp
                    <div class="col-lg-6">
                        <div class="single-politics-news">
                            <div class="politics-news-image">
                                @if($news->post_type == 'Image')
                                    <a href="{{ route('single.news', $news->slug) }}">
                                        <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                    </a>
                                @endif
                                @if($news->post_type == 'Gallery')
                                    <a href="{{ route('single.news', $news->slug) }}">
                                        <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                    </a>
                                @endif
                                @if($news->post_type == 'Video')
                                    <a href="{{ route('single.news', $news->slug) }}">
                                        <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                    </a>
                                @endif
                                @if($news->post_type == 'Audio')
                                    <a href="{{ route('single.news', $news->slug) }}">
                                        <iframe class="top-video__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                    </a>
                                @endif
                            </div>
                            <div class="politics-news-content">
                                <span>Politics</span>
                                <h3>
                                <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                                </h3>
                                <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>

                
                @elseif($language->id == 2)
                
                    @php
                        $category = App\Models\Category::where('slug', 'রাজনীতি')->first();
                        // dd($category->posts);      
                    @endphp

                    <div class="row">
                        <div class="col-lg-6">

                            @foreach($category->posts as $key => $news)
                                @if($key >= 1 && $key < 4)
                                    @php
                                        $featured_info = json_decode($news->featured);
                                    @endphp
                                    <div class="politics-news-post">
                                        <div class="row align-items-center">
                                            <div class="col-lg-4 col-sm-4">
                                            <div class="politics-news-image">
                                                @if($news->post_type == 'Image')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                                    </a>
                                                @endif
                                                @if($news->post_type == 'Gallery')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                                    </a>
                                                @endif
                                                @if($news->post_type == 'Video')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                                    </a>
                                                @endif
                                                @if($news->post_type == 'Audio')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <iframe class="top-video__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                                    </a>
                                                @endif
                                            </div>
                                            </div>
                                            <div class="col-lg-8 col-sm-8">
                                            <div class="politics-news-content">
                                                <h3>
                                                    <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a> 
                                                </h3>
                                                <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach


                        </div>
                        @foreach($category->posts as $key => $news)
                        @if($key < 1)
                        @php
                            $featured_info = json_decode($news->featured);
                        @endphp
                        <div class="col-lg-6">
                            <div class="single-politics-news">
                                <div class="politics-news-image">
                                    @if($news->post_type == 'Image')
                                        <a href="{{ route('single.news', $news->slug) }}">
                                            <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                        </a>
                                    @endif
                                    @if($news->post_type == 'Gallery')
                                        <a href="{{ route('single.news', $news->slug) }}">
                                            <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                        </a>
                                    @endif
                                    @if($news->post_type == 'Video')
                                        <a href="{{ route('single.news', $news->slug) }}">
                                            <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                        </a>
                                    @endif
                                    @if($news->post_type == 'Audio')
                                        <a href="{{ route('single.news', $news->slug) }}">
                                            <iframe class="top-video__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                        </a>
                                    @endif
                                </div>
                                <div class="politics-news-content">
                                    <span>রাজনীতি</span>
                                    <h3>
                                    <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                                    </h3>
                                    <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                @endif
             </div>

             <div class="business-news">
                <div class="section-title">
                    @if($language->id == 1)
                    <h2>Business</h2>
                    @elseif($language->id == 2)
                    <h2>ব্যবসা</h2>
                    @endif
                </div>
                <div class="business-news-slides owl-carousel owl-theme">
                  
                  @if($language->id == 1)

                    @php
                        $category = App\Models\Category::where('slug', 'Business')->first();
                    @endphp

                    @foreach($category->posts as $news)
                    @php
                        $featured_info = json_decode($news->featured);
                    @endphp
                    <div class="single-business-news">
                      <div class="business-news-image">
                        @if($news->post_type == 'Image')
                            <a href="{{ route('single.news', $news->slug) }}">
                                <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                            </a>
                        @endif
                        @if($news->post_type == 'Gallery')
                            <a href="{{ route('single.news', $news->slug) }}">
                                <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                            </a>
                        @endif
                        @if($news->post_type == 'Video')
                            <a href="{{ route('single.news', $news->slug) }}">
                                <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                            </a>
                        @endif
                        @if($news->post_type == 'Audio')
                            <a href="{{ route('single.news', $news->slug) }}">
                                <iframe class="top-video__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                            </a>
                        @endif
                      </div>
                      <div class="business-news-content">
                         <span>Business</span>
                         <h3>
                            <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                        </h3>
                        <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                      </div>
                   </div>
                   @endforeach

                   @elseif($language->id == 2)

                    @php
                        $category = App\Models\Category::where('slug', 'ব্যবসা')->first();
                    @endphp

                    @foreach($category->posts as $news)
                    @php
                        $featured_info = json_decode($news->featured);
                    @endphp
                    <div class="single-business-news">
                        <div class="business-news-image">
                        @if($news->post_type == 'Image')
                            <a href="{{ route('single.news', $news->slug) }}">
                                <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                            </a>
                        @endif
                        @if($news->post_type == 'Gallery')
                            <a href="{{ route('single.news', $news->slug) }}">
                                <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                            </a>
                        @endif
                        @if($news->post_type == 'Video')
                            <a href="{{ route('single.news', $news->slug) }}">
                                <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                            </a>
                        @endif
                        @if($news->post_type == 'Audio')
                            <a href="{{ route('single.news', $news->slug) }}">
                                <iframe class="top-video__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                            </a>
                        @endif
                        </div>
                        <div class="business-news-content">
                            <span>ব্যবসা</span>
                            <h3>
                            <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                        </h3>
                        <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                        </div>
                    </div>
                    @endforeach

                   @endif
                   

                </div>
             </div>
             <div class="culture-news">
                <div class="section-title">
                    @if($language->id == 1)
                    <h2>Culture</h2>
                    @elseif($language->id == 2)
                    <h2>সংস্কৃতি</h2>
                    @endif
                </div>
                @if($language->id == 1)

                    @php
                        $category = App\Models\Category::where('slug', 'Culture')->first();      
                    @endphp

                    <div class="row">
                        <div class="col-lg-6">
                            @foreach($category->posts as $key => $news)
                                @if($key >= 1 && $key < 4)
                                    @php
                                        $featured_info = json_decode($news->featured);
                                    @endphp
                                    <div class="culture-news-post">
                                        <div class="row align-items-center">
                                            <div class="col-lg-4 col-sm-4">
                                            <div class="culture-news-image">
                                                @if($news->post_type == 'Image')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                                    </a>
                                                @endif
                                                @if($news->post_type == 'Gallery')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                                    </a>
                                                @endif
                                                @if($news->post_type == 'Video')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <iframe class="" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                                    </a>
                                                @endif
                                                @if($news->post_type == 'Audio')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <iframe class="" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                                    </a>
                                                @endif
                                            </div>
                                            </div>
                                            <div class="col-lg-8 col-sm-8">
                                            <div class="culture-news-content">
                                                <h3>
                                                    <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                                                </h3>
                                                <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>

                        @foreach($category->posts as $key => $news)
                        @if($key < 1)
                        @php
                            $featured_info = json_decode($news->featured);
                        @endphp
                        <div class="col-lg-6">
                            <div class="single-culture-news">
                                <div class="culture-news-image">
                                    @if($news->post_type == 'Image')
                                        <a href="{{ route('single.news', $news->slug) }}">
                                            <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                        </a>
                                    @endif
                                    @if($news->post_type == 'Gallery')
                                        <a href="{{ route('single.news', $news->slug) }}">
                                            <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                        </a>
                                    @endif
                                    @if($news->post_type == 'Video')
                                        <a href="{{ route('single.news', $news->slug) }}">
                                            <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                        </a>
                                    @endif
                                    @if($news->post_type == 'Audio')
                                        <a href="{{ route('single.news', $news->slug) }}">
                                            <iframe class="top-video__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                        </a>
                                    @endif
                                </div>
                                <div class="culture-news-content">
                                    <span>Culture</span>
                                    <h3>
                                        <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                                    </h3>
                                    <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>

                @elseif($language->id == 2)

                    @php
                        $category = App\Models\Category::where('slug', 'সংস্কৃতি')->first();      
                    @endphp

                    <div class="row">
                        <div class="col-lg-6">
                            @foreach($category->posts as $key => $news)
                                @if($key >= 1 && $key < 4)
                                    @php
                                        $featured_info = json_decode($news->featured);
                                    @endphp
                                    <div class="culture-news-post">
                                        <div class="row align-items-center">
                                            <div class="col-lg-4 col-sm-4">
                                            <div class="culture-news-image">
                                                @if($news->post_type == 'Image')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                                    </a>
                                                @endif
                                                @if($news->post_type == 'Gallery')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                                    </a>
                                                @endif
                                                @if($news->post_type == 'Video')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <iframe class="" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                                    </a>
                                                @endif
                                                @if($news->post_type == 'Audio')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <iframe class="" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                                    </a>
                                                @endif
                                            </div>
                                            </div>
                                            <div class="col-lg-8 col-sm-8">
                                            <div class="culture-news-content">
                                                <h3>
                                                    <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                                                </h3>
                                                <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>

                        @foreach($category->posts as $key => $news)
                        @if($key < 1)
                        @php
                            $featured_info = json_decode($news->featured);
                        @endphp
                        <div class="col-lg-6">
                            <div class="single-culture-news">
                                <div class="culture-news-image">
                                    @if($news->post_type == 'Image')
                                        <a href="{{ route('single.news', $news->slug) }}">
                                            <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                        </a>
                                    @endif
                                    @if($news->post_type == 'Gallery')
                                        <a href="{{ route('single.news', $news->slug) }}">
                                            <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                        </a>
                                    @endif
                                    @if($news->post_type == 'Video')
                                        <a href="{{ route('single.news', $news->slug) }}">
                                            <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                        </a>
                                    @endif
                                    @if($news->post_type == 'Audio')
                                        <a href="{{ route('single.news', $news->slug) }}">
                                            <iframe class="top-video__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                        </a>
                                    @endif
                                </div>
                                <div class="culture-news-content">
                                    <span>সংস্কৃতি</span>
                                    <h3>
                                        <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                                    </h3>
                                    <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>

                @endif

             </div>
             <div class="row">
                <div class="col-lg-6">
                   <div class="section-title">
                        @if($language->id == 1)
                        <h2>Sports</h2>
                        @elseif($language->id == 2)
                        <h2>খেলাধুলা</h2>
                        @endif
                   </div>

                   @if($language->id == 1)

                   @php
                       $category = App\Models\Category::where('slug', 'Sports')->first();      
                   @endphp

                    <div class="sports-slider owl-carousel owl-theme">
                        <div class="sports-item">

                            @foreach($category->posts as $key => $news)
                            {{-- @dd($category->posts) --}}
                            @php
                                $featured_info = json_decode($news->featured);
                            @endphp
                            @if($key < 3)
                            <div class="single-sports-news">
                                <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="sports-news-image">
                                        @if($news->post_type == 'Image')
                                            <a href="{{ route('single.news', $news->slug) }}">
                                                <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                            </a>
                                        @endif
                                        @if($news->post_type == 'Gallery')
                                            <a href="{{ route('single.news', $news->slug) }}">
                                                <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                            </a>
                                        @endif
                                        @if($news->post_type == 'Video')
                                            <a href="{{ route('single.news', $news->slug) }}">
                                                <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                            </a>
                                        @endif
                                        @if($news->post_type == 'Audio')
                                            <a href="{{ route('single.news', $news->slug) }}">
                                                <iframe class="top-video__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="sports-news-content">
                                        <h3>
                                            <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                                        </h3>
                                        <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                                    </div>
                                </div>
                                </div>
                            </div>
                            @endif
                            @endforeach                           


                        </div>
                        <div class="sports-item">

                            @foreach($category->posts as $key => $news)
                            {{-- @dd($category->posts) --}}
                            @php
                                $featured_info = json_decode($news->featured);
                            @endphp
                            @if($key >= 3 && $key < 6)
                            <div class="single-sports-news">
                                <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="sports-news-image">
                                        @if($news->post_type == 'Image')
                                            <a href="{{ route('single.news', $news->slug) }}">
                                                <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                            </a>
                                        @endif
                                        @if($news->post_type == 'Gallery')
                                            <a href="{{ route('single.news', $news->slug) }}">
                                                <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                            </a>
                                        @endif
                                        @if($news->post_type == 'Video')
                                            <a href="{{ route('single.news', $news->slug) }}">
                                                <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                            </a>
                                        @endif
                                        @if($news->post_type == 'Audio')
                                            <a href="{{ route('single.news', $news->slug) }}">
                                                <iframe class="top-video__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="sports-news-content">
                                        <h3>
                                            <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                                        </h3>
                                        <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                                    </div>
                                </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            

                        </div>
                    </div>
                    
                    @elseif($language->id == 2)

                    @php
                        $category = App\Models\Category::where('slug', 'খেলাধুলা')->first();      
                    @endphp

                    <div class="sports-slider owl-carousel owl-theme">
                        <div class="sports-item">

                            @foreach($category->posts as $key => $news)
                            {{-- @dd($category->posts) --}}
                            @php
                                $featured_info = json_decode($news->featured);
                            @endphp
                            @if($key < 3)
                            <div class="single-sports-news">
                                <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="sports-news-image">
                                        @if($news->post_type == 'Image')
                                            <a href="{{ route('single.news', $news->slug) }}">
                                                <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                            </a>
                                        @endif
                                        @if($news->post_type == 'Gallery')
                                            <a href="{{ route('single.news', $news->slug) }}">
                                                <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                            </a>
                                        @endif
                                        @if($news->post_type == 'Video')
                                            <a href="{{ route('single.news', $news->slug) }}">
                                                <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                            </a>
                                        @endif
                                        @if($news->post_type == 'Audio')
                                            <a href="{{ route('single.news', $news->slug) }}">
                                                <iframe class="top-video__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="sports-news-content">
                                        <h3>
                                            <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                                        </h3>
                                        <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                                    </div>
                                </div>
                                </div>
                            </div>
                            @endif
                            @endforeach                           


                        </div>
                        <div class="sports-item">

                            @foreach($category->posts as $key => $news)
                            {{-- @dd($category->posts) --}}
                            @php
                                $featured_info = json_decode($news->featured);
                            @endphp
                            @if($key >= 3 && $key < 6)
                            <div class="single-sports-news">
                                <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="sports-news-image">
                                        @if($news->post_type == 'Image')
                                            <a href="{{ route('single.news', $news->slug) }}">
                                                <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                            </a>
                                        @endif
                                        @if($news->post_type == 'Gallery')
                                            <a href="{{ route('single.news', $news->slug) }}">
                                                <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                            </a>
                                        @endif
                                        @if($news->post_type == 'Video')
                                            <a href="{{ route('single.news', $news->slug) }}">
                                                <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                            </a>
                                        @endif
                                        @if($news->post_type == 'Audio')
                                            <a href="{{ route('single.news', $news->slug) }}">
                                                <iframe class="top-video__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="sports-news-content">
                                        <h3>
                                            <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                                        </h3>
                                        <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                                    </div>
                                </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            

                        </div>
                    </div>

                    @endif

                </div>


                <div class="col-lg-6">
                   <div class="section-title">
                        @if($language->id == 1)
                        <h2>Tech</h2>
                        @elseif($language->id == 2)
                        <h2>প্রযুক্তি</h2>
                        @endif
                   </div>

                   @if($language->id == 1)

                    @php
                        $category = App\Models\Category::where('slug', 'Tech')->first(); 
                        // dd($category);
                    @endphp
                   
                   <div class="tech-slider owl-carousel owl-theme">
                      <div class="tech-item">
                        @foreach($category->posts as $key => $news)
                        {{-- @dd($category->posts) --}}
                            @php
                                $featured_info = json_decode($news->featured);
                            @endphp
                            @if($key < 3)
                                <div class="single-tech-news">
                                    <div class="row align-items-center">
                                    <div class="col-lg-4">
                                        <div class="tech-news-image">
                                            @if($news->post_type == 'Image')
                                                <a href="{{ route('single.news', $news->slug) }}">
                                                    <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                                </a>
                                            @endif
                                            @if($news->post_type == 'Gallery')
                                                <a href="{{ route('single.news', $news->slug) }}">
                                                    <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                                </a>
                                            @endif
                                            @if($news->post_type == 'Video')
                                                <a href="{{ route('single.news', $news->slug) }}">
                                                    <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                                </a>
                                            @endif
                                            @if($news->post_type == 'Audio')
                                                <a href="{{ route('single.news', $news->slug) }}">
                                                    <iframe class="top-video__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="tech-news-content">
                                            <h3>
                                                <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                                            </h3>
                                            <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                         
                      </div>
                      <div class="tech-item">
                        @foreach($category->posts as $key => $news)
                        {{-- @dd($category->posts) --}}
                            @php
                                $featured_info = json_decode($news->featured);
                            @endphp
                            @if($key >= 3 && $key < 6)
                                <div class="single-tech-news">
                                    <div class="row align-items-center">
                                    <div class="col-lg-4">
                                        <div class="tech-news-image">
                                            @if($news->post_type == 'Image')
                                                <a href="{{ route('single.news', $news->slug) }}">
                                                    <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                                </a>
                                            @endif
                                            @if($news->post_type == 'Gallery')
                                                <a href="{{ route('single.news', $news->slug) }}">
                                                    <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                                </a>
                                            @endif
                                            @if($news->post_type == 'Video')
                                                <a href="{{ route('single.news', $news->slug) }}">
                                                    <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                                </a>
                                            @endif
                                            @if($news->post_type == 'Audio')
                                                <a href="{{ route('single.news', $news->slug) }}">
                                                    <iframe class="top-video__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="tech-news-content">
                                            <h3>
                                                <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                                            </h3>
                                            <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                      </div>
                   </div>

                   @elseif($language->id == 2)

                    @php
                        $category = App\Models\Category::where('slug', 'প্রযুক্তি')->first(); 
                        // dd($category);
                    @endphp
                    
                    <div class="tech-slider owl-carousel owl-theme">
                        <div class="tech-item">
                            @foreach($category->posts as $key => $news)
                            {{-- @dd($category->posts) --}}
                                @php
                                    $featured_info = json_decode($news->featured);
                                @endphp
                                @if($key < 3)
                                    <div class="single-tech-news">
                                        <div class="row align-items-center">
                                        <div class="col-lg-4">
                                            <div class="tech-news-image">
                                                @if($news->post_type == 'Image')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                                    </a>
                                                @endif
                                                @if($news->post_type == 'Gallery')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                                    </a>
                                                @endif
                                                @if($news->post_type == 'Video')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                                    </a>
                                                @endif
                                                @if($news->post_type == 'Audio')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <iframe class="top-video__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="tech-news-content">
                                                <h3>
                                                    <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                                                </h3>
                                                <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            
                        </div>
                        <div class="tech-item">
                            @foreach($category->posts as $key => $news)
                            {{-- @dd($category->posts) --}}
                                @php
                                    $featured_info = json_decode($news->featured);
                                @endphp
                                @if($key >= 3 && $key < 6)
                                    <div class="single-tech-news">
                                        <div class="row align-items-center">
                                        <div class="col-lg-4">
                                            <div class="tech-news-image">
                                                @if($news->post_type == 'Image')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                                    </a>
                                                @endif
                                                @if($news->post_type == 'Gallery')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                                    </a>
                                                @endif
                                                @if($news->post_type == 'Video')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <iframe class="top-video__news" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                                    </a>
                                                @endif
                                                @if($news->post_type == 'Audio')
                                                    <a href="{{ route('single.news', $news->slug) }}">
                                                        <iframe class="top-video__news" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="tech-news-content">
                                                <h3>
                                                    <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                                                </h3>
                                                <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                   @endif

                </div>
             </div>
             <div class="health-news">
                <div class="section-title">
                    @if($language->id == 1)
                    <h2>Health</h2>
                    @elseif($language->id == 2)
                    <h2>স্বাস্থ্য</h2>
                    @endif
                </div>

                <div class="health-news-slides owl-carousel owl-theme">
                   @if($language->id == 1)

                    @php
                        $category = App\Models\Category::where('slug', 'Health')->first(); 
                        // dd($category);
                    @endphp

                    @foreach($category->posts as $key => $news)
                        {{-- @dd($category->posts) --}}
                            @php
                                $featured_info = json_decode($news->featured);
                            @endphp
                        <div class="single-health-news">
                            <div class="health-news-image">
                                @if($news->post_type == 'Image')
                                    <a href="{{ route('single.news', $news->slug) }}">
                                        <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                    </a>
                                @endif
                                @if($news->post_type == 'Gallery')
                                    <a href="{{ route('single.news', $news->slug) }}">
                                        <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                    </a>
                                @endif
                                @if($news->post_type == 'Video')
                                    <a href="{{ route('single.news', $news->slug) }}">
                                        <iframe src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                    </a>
                                @endif
                                @if($news->post_type == 'Audio')
                                    <a href="{{ route('single.news', $news->slug) }}">
                                        <iframe src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                    </a>
                                @endif
                            </div>
                            <div class="health-news-content">
                                <span>Health</span>
                                <h3>
                                    <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                                </h3>
                                <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                            </div>
                        </div>
                    @endforeach

                   @elseif($language->id == 2)

                    @php
                        $category = App\Models\Category::where('slug', 'স্বাস্থ্য')->first(); 
                        // dd($category);
                    @endphp

                    @foreach($category->posts as $key => $news)
                        {{-- @dd($category->posts) --}}
                            @php
                                $featured_info = json_decode($news->featured);
                            @endphp
                        <div class="single-health-news">
                            <div class="health-news-image">
                                @if($news->post_type == 'Image')
                                    <a href="{{ route('single.news', $news->slug) }}">
                                        <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_image }}" alt="image">
                                    </a>
                                @endif
                                @if($news->post_type == 'Gallery')
                                    <a href="{{ route('single.news', $news->slug) }}">
                                        <img src="{{ URL::to('/') }}/media/posts/{{ $featured_info->post_gallery[0] }}" alt="image">
                                    </a>
                                @endif
                                @if($news->post_type == 'Video')
                                    <a href="{{ route('single.news', $news->slug) }}">
                                        <iframe src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                                    </a>
                                @endif
                                @if($news->post_type == 'Audio')
                                    <a href="{{ route('single.news', $news->slug) }}">
                                        <iframe src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                                    </a>
                                @endif
                            </div>
                            <div class="health-news-content">
                                <span>স্বাস্থ্য</span>
                                <h3>
                                    <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                                </h3>
                                <p>{{ date('d F Y', strtotime($video->created_at)) }}</p>
                            </div>
                        </div>
                    @endforeach

                   @endif
                   
                </div>
             </div>
          </div>
          <div class="col-lg-4">
             <aside class="widget-area">

                @include('frontend.layouts.latest-news-thumb')

                <section class="widget widget_newsletter">
                   <div class="newsletter-content">
                      <h3>Subscribe to our newsletter</h3>
                      <p>Subscribe to our newsletter to get the new updates!</p>
                   </div>
                   <form class="newsletter-form" data-toggle="validator">
                      <input type="email" class="input-newsletter" placeholder="Enter your email" name="EMAIL" required autocomplete="off">
                      <button type="submit">Subscribe</button>
                      <div id="validator-newsletter" class="form-result"></div>
                   </form>
                </section>
                <section class="widget widget_most_shared">
                   <h3 class="widget-title">Most shared</h3>
                   <div class="single-most-shared">
                      <div class="most-shared-image">
                         <a href="#">
                         <img src="{{ asset('/frontend/') }}/assets/img/most-shared/most-shared-2.jpg" alt="image">
                         </a>
                         <div class="most-shared-content">
                            <h3>
                               <a href="#">All the highlights from western fashion week summer 2021</a>
                            </h3>
                            <p><a href="#">Patricia</a> / 28 September, 2021</p>
                         </div>
                      </div>
                   </div>
                </section>
                
                @include('frontend.layouts.popular-post')

                @include('frontend.layouts.tag-list')

                <section class="widget widget_instagram">
                   <h3 class="widget-title">Instagram</h3>
                   <ul>
                      <li>
                         <div class="box">
                            <img src="{{ asset('/frontend/') }}/assets/img/latest-news/latest-news-1.jpg" alt="image">
                            <i class="bx bxl-instagram"></i>
                            <a href="#" target="_blank" class="link-btn"></a>
                         </div>
                      </li>
                      <li>
                         <div class="box">
                            <img src="{{ asset('/frontend/') }}/assets/img/latest-news/latest-news-2.jpg" alt="image">
                            <i class="bx bxl-instagram"></i>
                            <a href="#" target="_blank" class="link-btn"></a>
                         </div>
                      </li>
                      <li>
                         <div class="box">
                            <img src="{{ asset('/frontend/') }}/assets/img/latest-news/latest-news-3.jpg" alt="image">
                            <i class="bx bxl-instagram"></i>
                            <a href="#" target="_blank" class="link-btn"></a>
                         </div>
                      </li>
                      <li>
                         <div class="box">
                            <img src="{{ asset('/frontend/') }}/assets/img/latest-news/latest-news-4.jpg" alt="image">
                            <i class="bx bxl-instagram"></i>
                            <a href="#" target="_blank" class="link-btn"></a>
                         </div>
                      </li>
                      <li>
                         <div class="box">
                            <img src="{{ asset('/frontend/') }}/assets/img/latest-news/latest-news-5.jpg" alt="image">
                            <i class="bx bxl-instagram"></i>
                            <a href="#" target="_blank" class="link-btn"></a>
                         </div>
                      </li>
                      <li>
                         <div class="box">
                            <img src="{{ asset('/frontend/') }}/assets/img/latest-news/latest-news-6.jpg" alt="image">
                            <i class="bx bxl-instagram"></i>
                            <a href="#" target="_blank" class="link-btn"></a>
                         </div>
                      </li>
                   </ul>
                </section>
             </aside>
          </div>
       </div>
    </div>
</section>
@endsection
