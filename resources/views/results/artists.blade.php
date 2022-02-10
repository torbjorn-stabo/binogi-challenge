<ul>
    @foreach ($artists as $artist)
        <li>
            <a href="{{ $artist->external_urls->spotify }}">
                @include('results.artist', ['artist' => $artist])
            </a>
        </li>
    @endforeach
</ul>
