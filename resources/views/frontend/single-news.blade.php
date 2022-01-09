<!doctype html>
<html lang="zxx">

    @include('frontend.layouts.head')

   <body>

        {{-- @include('frontend.layouts.loader') --}}



      <div class="top-header-area bg-ffffff">
         <div class="container">
            <div class="row align-items-center">
               @include('frontend.layouts.top-breaking-news')
               @include('frontend.layouts.login-language')
            </div>
         </div>
      </div>

      @include('frontend.layouts.navbar')

      <div class="page-title-area">
         <div class="container">
            <div class="page-title-content">
               <h2>News details</h2>
               <ul>
                  <li><a href="index.html">Home</a></li>
                  <li>News details</li>
               </ul>
            </div>
         </div>
      </div>

      @php
        $featured_info = json_decode($news->featured);
        // dd($featured_info);
      @endphp

      <section class="news-details-area ptb-50">
         <div class="container">
            <div class="row">
               <div class="col-lg-8 col-md-12">
                  <div class="blog-details-desc">
                     <div class="article-image">
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
                                <iframe class="single-video" src="{{ $featured_info->post_video }}" frameborder="0"></iframe>
                            </a>
                        @endif
                        @if($news->post_type == 'Audio')
                            <a href="{{ route('single.news', $news->slug) }}">
                                <iframe class="single-audio" src="{{ $featured_info->post_audio }}" frameborder="0"></iframe>
                            </a>
                        @endif
                     </div>
                     <div class="article-content">
                        <span>{{ date('d F Y', strtotime($news->created_at)) }} / <a href="#">0 Comment</a></span>
                        <h3>{{ $news->title }}</h3>
                        <p>{!! htmlspecialchars_decode($news->description) !!}</p>

                     </div>
                     <div class="article-footer">
                        <div class="article-share">
                           <ul class="social">
                              <li><span>Share:</span></li>
                              <li>
                                 <a href="#" target="_blank">
                                 <i class='bx bxl-facebook'></i>
                                 </a>
                              </li>
                              <li>
                                 <a href="#" target="_blank">
                                 <i class='bx bxl-twitter'></i>
                                 </a>
                              </li>
                              <li>
                                 <a href="#" target="_blank">
                                 <i class='bx bxl-instagram'></i>
                                 </a>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <div class="post-navigation">
                        <div class="navigation-links">
                           <div class="nav-previous">
                              <a href="#">
                              <i class='bx bx-chevron-left'></i>
                              Prev Post
                              </a>
                           </div>
                           <div class="nav-next">
                              <a href="#">
                              Next Post
                              <i class='bx bx-chevron-right'></i>
                              </a>
                           </div>
                        </div>
                     </div>
                     <div class="comments-area">
                        <h3 class="comments-title">3 Comments:</h3>
                        <ol class="comment-list">
                           <li class="comment">
                              <div class="comment-body">
                                 <footer class="comment-meta">
                                    <div class="comment-author vcard">
                                       <img src="assets/img/client/client-1.jpg" class="avatar" alt="image">
                                       <b class="fn">John Jones</b>
                                    </div>
                                    <div class="comment-metadata">
                                       <a href="index.html">
                                       <span>April 24, 2021 at 10:59 am</span>
                                       </a>
                                    </div>
                                 </footer>
                                 <div class="comment-content">
                                    <p>Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen.</p>
                                 </div>
                                 <div class="reply">
                                    <a href="#" class="comment-reply-link">Reply</a>
                                 </div>
                              </div>
                              <ol class="children">
                                 <li class="comment">
                                    <div class="comment-body">
                                       <footer class="comment-meta">
                                          <div class="comment-author vcard">
                                             <img src="assets/img/client/client-2.jpg" class="avatar" alt="image">
                                             <b class="fn">Steven Smith</b>
                                          </div>
                                          <div class="comment-metadata">
                                             <a href="index.html">
                                             <span>April 24, 2021 at 10:59 am</span>
                                             </a>
                                          </div>
                                       </footer>
                                       <div class="comment-content">
                                          <p>Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen.</p>
                                       </div>
                                       <div class="reply">
                                          <a href="#" class="comment-reply-link">Reply</a>
                                       </div>
                                    </div>
                                 </li>
                              </ol>
                              <div class="comment-body">
                                 <footer class="comment-meta">
                                    <div class="comment-author vcard">
                                       <img src="assets/img/client/client-3.jpg" class="avatar" alt="image">
                                       <b class="fn">Sarah Taylor</b>
                                    </div>
                                    <div class="comment-metadata">
                                       <a href="index.html">
                                       <span>April 24, 2021 at 10:59 am</span>
                                       </a>
                                    </div>
                                 </footer>
                                 <div class="comment-content">
                                    <p>Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen.</p>
                                 </div>
                                 <div class="reply">
                                    <a href="#" class="comment-reply-link">Reply</a>
                                 </div>
                              </div>
                           </li>
                        </ol>
                        <div class="comment-respond">
                           <h3 class="comment-reply-title">Leave a Reply</h3>
                           <form class="comment-form">
                              <p class="comment-notes">
                                 <span id="email-notes">Your email address will not be published.</span>
                                 Required fields are marked
                              </p>
                              <p class="comment-form-author">
                                 <label>Name</label>
                                 <input type="text" id="author" placeholder="Your Name*" name="author" required="required">
                              </p>
                              <p class="comment-form-email">
                                 <label>Email</label>
                                 <input type="email" id="email" placeholder="Your Email*" name="email" required="required">
                              </p>
                              <p class="comment-form-url">
                                 <label>Website</label>
                                 <input type="url" id="url" placeholder="Website" name="url">
                              </p>
                              <p class="comment-form-comment">
                                 <label>Comment</label>
                                 <textarea name="comment" id="comment" cols="45" placeholder="Your Comment..." rows="5" maxlength="65525" required="required"></textarea>
                              </p>
                              <p class="comment-form-cookies-consent">
                                 <input type="checkbox" value="yes" name="wp-comment-cookies-consent" id="wp-comment-cookies-consent">
                                 <label for="wp-comment-cookies-consent">Save my name, email, and website in this browser for the next time I comment.</label>
                              </p>
                              <p class="form-submit">
                                 <input type="submit" name="submit" id="submit" class="submit" value="Post a comment">
                              </p>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4">
                  <aside class="widget-area">
                     <div class="widget widget_search">
                        <form class="search-form">
                           <label>
                           <span class="screen-reader-text">Search for:</span>
                           <input type="search" class="search-field" placeholder="Search...">
                           </label>
                           <button type="submit">
                           <i class='bx bx-search'></i>
                           </button>
                        </form>
                     </div>
                     
                     @include('frontend.layouts.latest-news-thumb')

                     @include('frontend.layouts.popular-post')
                     
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
                              <img src="assets/img/most-shared/most-shared-2.jpg" alt="image">
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
                     
                     @include('frontend.layouts.tag-list')

                     <section class="widget widget_instagram">
                        <h3 class="widget-title">Instagram</h3>
                        <ul>
                           <li>
                              <div class="box">
                                 <img src="assets/img/latest-news/latest-news-1.jpg" alt="image">
                                 <i class="bx bxl-instagram"></i>
                                 <a href="#" target="_blank" class="link-btn"></a>
                              </div>
                           </li>
                           <li>
                              <div class="box">
                                 <img src="assets/img/latest-news/latest-news-2.jpg" alt="image">
                                 <i class="bx bxl-instagram"></i>
                                 <a href="#" target="_blank" class="link-btn"></a>
                              </div>
                           </li>
                           <li>
                              <div class="box">
                                 <img src="assets/img/latest-news/latest-news-3.jpg" alt="image">
                                 <i class="bx bxl-instagram"></i>
                                 <a href="#" target="_blank" class="link-btn"></a>
                              </div>
                           </li>
                           <li>
                              <div class="box">
                                 <img src="assets/img/latest-news/latest-news-4.jpg" alt="image">
                                 <i class="bx bxl-instagram"></i>
                                 <a href="#" target="_blank" class="link-btn"></a>
                              </div>
                           </li>
                           <li>
                              <div class="box">
                                 <img src="assets/img/latest-news/latest-news-5.jpg" alt="image">
                                 <i class="bx bxl-instagram"></i>
                                 <a href="#" target="_blank" class="link-btn"></a>
                              </div>
                           </li>
                           <li>
                              <div class="box">
                                 <img src="assets/img/latest-news/latest-news-6.jpg" alt="image">
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

      @include('frontend.layouts.footer')

      @include('frontend.layouts.partials.scripts')
   </body>
</html>
