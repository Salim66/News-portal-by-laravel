<div class="top-header-area bg-color">
    <div class="container">
       <div class="row align-items-center">
          <div class="col-lg-6">
             <ul class="top-header-social">

               @php
                   $socials = App\Models\SocialLink::with('languages')->get();
                   // echo $socials;
               @endphp

               @foreach($socials as $social)
                   @if($social->languages->status == true)
                       <li>
                           <a title="{{ $social->name }}" href="{{ $social->link }}" class="facebook" target="_blank">
                           <i class='{{ $social->icon }}'></i>
                           </a>
                       </li>
                   @endif
               @endforeach

             </ul>
          </div>
          <div class="col-lg-6">
              @php
                  $languages = App\Models\Language::all();
              @endphp
             <ul class="top-header-others">
               @foreach($languages as $language)
                <li>
                   <a href="{{ route('change.language', $language->id) }}">{{ $language->name }}</a>
                </li>
               @endforeach
                <li>
                   <i class='bx bx-user'></i>
                   <a href="login.html">Login</a>
                </li>
             </ul>
          </div>
       </div>
    </div>
 </div>
