<ul>
    @foreach ($albums as $album)
        <li>
            <a href="{{ $album->external_urls->spotify }}">
                @include('results.album', ['album' => $album])
            </a>
        </li>
    @endforeach
</ul>