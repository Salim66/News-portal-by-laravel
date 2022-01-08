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
