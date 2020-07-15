@extends('layouts.app')

@section('content')
    <header class="header">
        <h2>Cities</h2>
    </header>
    <section class="section">
        <nav class="nav">

            @foreach($urlLists as $urlList)
                <a class="url-list" href="">
                    <div class="original-url-text">
                        {{$urlList->original_url}}
                    </div>
                    <div class="shortening-url-text">
                        {{$urlList->short_url}}
                    </div>
                </a>
            @endforeach
        </nav>

        <article class="article">
            <h1>London</h1>
            <p>London is the capital city of England. It is the most populous city in the United Kingdom, with a
                metropolitan area of over 13 million inhabitants.</p>
            <p>Standing on the River Thames, London has been a major settlement for two millennia, its history going
                back to its founding by the Romans, who named it Londinium.</p>
        </article>
    </section>
@endsection()
