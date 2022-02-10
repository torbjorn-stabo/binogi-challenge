@if (count($artist->images))
    <img src="{{ optional(array_pop($artist->images))->url }}" alt="">
@else
    <p class="imgbox"></p>
@endif
Name: <b>{{ $artist->name }}</b>
