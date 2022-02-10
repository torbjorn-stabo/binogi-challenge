@if (isset($track->album->images))
    <img src="{{ array_pop($track->album->images)->url }}" alt="">
@endif
Name: <b>{{ $track->name }}</b>
