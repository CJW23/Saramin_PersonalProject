@extends('layouts.app')

@section('content')
    <header class="header">
        <canvas id="myChart" width="500" height="50"></canvas>
    </header>
    <input type="text" id="url-search" name="url-search"
           class="form-control col-2" style="float: left; margin-left:10px; margin-right: 10px">
    <button type="button" onclick="requestUrlSearch()" class="btn btn-primary">검색</button>
    <br><br>
    <section class="section">
        <nav class="nav">
            <button onclick="test({{$urlLists}})">awd</button>
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
                                {{$urlList->count}}<img src="{{url('/images/graph.png')}}" height="25" width="25" style="float:right; margin-left: 5px; mar">
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
    <script type="application/javascript">
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    borderWidth: 1
                }]
            },

        });
    </script>
@endsection()
