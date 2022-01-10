@php
    $language = App\Models\Language::where('status', true)->first();
@endphp
<section class="footer-area pt-100 pb-70">
    <div class="container">
       <div class="row">
        @php
            $langauge = App\Models\Language::where('status', true)->first();
            $logo = App\Models\Logo::where('language_id', $langauge->id)->where('status', true)->first();
            $footer = App\Models\Footer::where('language_id', $language->id)->where('status', true)->first();
            // dd($categor);
        @endphp
          <div class="col-lg-3 col-md-6">
             <div class="single-footer-widget">
                <a href="#">
                <img src="{{ URL::to('/') }}/media/logos/{{ $logo->logo }}" alt="image">
                </a>
                <p>{{ $footer->footer_text }}</p>
                <ul class="social">
                @php
                    $language = App\Models\Language::where('status', true)->first();
                    $socials = App\Models\SocialLink::where('language_id', $language->id)->where('status', true)->get();
                    
                @endphp

                @foreach($socials as $social)
                   <li>
                      <a title="{{ $social->name }}" href="{{ $social->link }}" class="facebook" target="_blank">
                      <i class='{{ $social->icon }}'></i>
                      </a>
                   </li>
                @endforeach
           
                </ul>
             </div>
          </div>
          <div class="col-lg-3 col-md-6">
             <div class="single-footer-widget">
                 @if($language->id == 1)
                 <h2>Recent post</h2>
                 @elseif($language->id == 2)
                 <h2>সাম্প্রতিক পোস্ট</h2>
                 @endif

                 @php
                    $posts = App\Models\Post::where('language_id', $language->id)->where('status', true)->where('trash', false)->latest()->get();
                 @endphp
                 @foreach($posts as $key => $news)
                 @php
                    $featured_info = json_decode($news->featured);
                 @endphp
                 @if($key < 3)
                <div class="post-content">
                   <div class="row align-items-center">
                      <div class="col-md-4">
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
                      <div class="col-md-8">
                        <h4>
                            <a href="{{ route('single.news', $news->slug) }}">{{ $news->title }}</a>
                        </h4>
                        <span>{{ date('d M Y', strtotime($news->created_at)) }}</span>
                      </div>
                   </div>
                </div>
                @endif
                @endforeach
               
             </div>
          </div>
          <div class="col-lg-3 col-md-6">
             <div class="single-footer-widget">
                <h2>Useful links</h2>
                <ul class="useful-links-list">
                   <li>
                      <a href="#">Contact us</a>
                   </li>
                   <li>
                      <a href="#">News</a>
                   </li>
                   <li>
                      <a href="#">Privacy & policy</a>
                   </li>
                   <li>
                      <a href="#">Terms & conditions</a>
                   </li>
                   <li>
                      <a href="#">Affilate ads</a>
                   </li>
                   <li>
                      <a href="#">Business</a>
                   </li>
                   <li>
                      <a href="#">Technology</a>
                   </li>
                   <li>
                      <a href="#">Entertainment</a>
                   </li>
                   <li>
                      <a href="#">Politics</a>
                   </li>
                </ul>
             </div>
          </div>
          <div class="col-lg-3 col-md-6">
             <div class="single-footer-widget">
                <h2>Subscribe</h2>
                <div class="widget-subscribe-content">
                   <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                   <form class="newsletter-form">
                      <input type="email" class="input-newsletter" placeholder="Enter your email" name="EMAIL" required>
                      <button type="submit">Subscribe</button>
                   </form>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>
 @php
    $footer = App\Models\Footer::where('language_id', $language->id)->first();
@endphp
 <div class="copyright-area">
    <div class="container">
       <div class="copyright-area-content">
           @if($language->id == 1)
          <p>
             {{ $footer->copyright_text }}
             <a href="https://www.techdynobd.com/" target="_blank">Techdyno BD <span>&hearts;</span></a>
          </p>
           @elseif($language->id == 2)
          <p>
            {{ $footer->copyright_text }}
             <a href="https://www.techdynobd.com/" target="_blank">টেকডাইনো বিডি <span>&hearts;</span></a>
          </p>
          @endif
       </div>
    </div>
 </div>
 <div class="go-top">
    <i class='bx bx-up-arrow-alt'></i>
 </div>
