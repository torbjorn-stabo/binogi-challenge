@if (count($album->images))
    <img src="{{ array_pop($album->images)->url }}" alt="">
@endif
Name: <b>{{ $album->name }}</b>
