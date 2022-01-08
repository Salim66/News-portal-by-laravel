<!doctype html>
<html lang="zxx">
    @include('frontend.layouts.head')
   <body>
      {{-- @include('frontend.layouts.loader') --}}
      @include('frontend.layouts.top-header')
      @include('frontend.layouts.navbar')

      @section('main-content')
      @show

      @include('frontend.layouts.footer')

      @include('frontend.layouts.partials.scripts')
   </body>
</html>

