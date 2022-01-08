<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    @include('frontend.layouts.partials.styles')

    @php
        $titles = App\Models\WebsiteContent::with('languages')->get();
          // dd($title->website_title);
    @endphp
    <title>
        @foreach($titles as $title)
          @if($title->languages->status == true)@yield('title', "$title->website_title")@endif
        @endforeach
      </title>
    <link rel="icon" type="image/png" href="{{ asset('/frontend/') }}/assets/img/favicon.png">
 </head>
