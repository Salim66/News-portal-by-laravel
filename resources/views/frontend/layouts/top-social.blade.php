<div class="col-lg-6">
    <ul class="top-header-social">

      @php
          $socials = App\Models\SocialLink::with('languages')->get();
          // echo $socials;
      @endphp

      @foreach($socials as $social)
          @if($social->languages->status == true)
              <li>
                  <a title="{{ $social->name }}" href="{{ $social->link }}" class="facebook social-top" target="_blank">
                  <i class='{{ $social->icon }}'></i>
                  </a>
              </li>
          @endif
      @endforeach

    </ul>
</div>
