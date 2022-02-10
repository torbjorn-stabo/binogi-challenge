<ul>
    @foreach ($tracks as $track)
        <li>
            <a href="{{ $track->external_urls->spotify }}">
                @include('results.track', ['track' => $track])
            </a>
        </li>
    @endforeach
</ul>
