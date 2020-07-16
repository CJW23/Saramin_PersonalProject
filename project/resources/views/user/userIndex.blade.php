@extends('layouts.app')

@section('content')
    <header class="header">
        <h2>Cities</h2>
    </header>
    <section class="section">
        <nav class="nav">

            @foreach($urlLists as $urlList)
                <a id="{{$urlList->id}}" onclick="requestUrlDetail(this)" class="url-list">

                    <div class="original-url-text">
                        {{$urlList->original_url}}
                    </div>
                    <div class="container">
                        <div class="shortening-url-text row justify-content-between ">
                            <div>
                                {{$urlList->short_url}}
                            </div>
                            <div class="url-count">
                                {{$urlList->count}}<img src="{{url('/images/graph.png')}}" height="25" width="25" style="float:right; margin-left: 5px;">
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </nav>

        <article class="article">
            <div class="detail-created-date">
            </div>
            <div class="detail-created-time">
            </div>
            <div class="detail-original-url">
            </div>
            <div class="detail-short-url">
            </div>
            <div class="detail-count">
            </div>
        </article>
    </section>
@endsection()
