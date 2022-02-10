<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Code Challenge</title>
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: sans-serif;
            height: 100vh;
            margin: 50px;
        }

        a {
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }

        .full-height {
            height: 100vh;
        }

        .search_terms {
            box-shadow: 0px 10px 5px 0px rgba(0,0,0,0.75);
            -webkit-box-shadow: 0px 10px 5px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 10px 5px 0px rgba(0,0,0,0.75);
            display: flex;
            justify-content: space-between; 
            padding: 0.5em 1em;
        }
        .result {
            display: flex;
        }

        ul {
            padding: 0px;
        }
        li {
            font-size: 0.8em;
            list-style-type: none;
            margin-bottom: .5em;
        }
        li:hover {
            background-color: silver;
        }

        li img {
            height: 64px;
            margin-right: 1em;
            vertical-align: text-top;
            width: 64px;
        }

        li .imgbox {
            border: 1px solid black;
            display: inline-block;
            height: 64px;
            margin: 0px 1em 0px 0px;
            vertical-align: text-top;
            width: 64px;
        }
    </style>
</head>
<body>
<div class="full-height">
    <div class="search_terms">
        <span>Your Search Term Was: <b>{{$searchTerm}}</b></span>
        <a href="{{ route('search.index') }}">Back to Search</a>
    </div>
    <div class="result">
        @foreach (['albums', 'artists', 'tracks'] as $search_topic)
            <div class="resultbox">
                <h1>{{ $search_topic }}</h1>
                @if(count($results->{$search_topic}->items))
                    @include("results.$search_topic", [$search_topic => $results->{$search_topic}->items])
                @else
                    No {{ $search_topic }} found
                @endif
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
