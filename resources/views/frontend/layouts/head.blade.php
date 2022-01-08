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

      @php
          $language = App\Models\Language::where('status', true)->first();
          $favicon = App\Models\Favicon::where('language_id', $language->id)->where('status', true)->first();
        //   dd($favicon);
      @endphp
    <link rel="icon" type="image/png" href="{{ URL::to('/') }}/media/favicons/{{ $favicon->favicon }}">
 </head>
