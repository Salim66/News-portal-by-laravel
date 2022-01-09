@php
    $language = App\Models\Language::where('status', true)->first();
    $tags = App\Models\Tag::where('status', true)->where('language_id', $language->id)->where('trash', false)->get();
@endphp
<section class="widget widget_tag_cloud">
    <h3 class="widget-title">Tags</h3>
    <div class="tagcloud">
        @foreach($tags as $tag)
        <a href="#">{{ $tag->name }}</a>
        @endforeach
    </div>
</section>