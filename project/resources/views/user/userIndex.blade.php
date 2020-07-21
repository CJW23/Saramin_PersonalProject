@extends('layouts.app')

@section('content')
    <!-- URL 리스트 데이터 저장-->
    <div id="data" data-field="{{$urlLists}}}"></div>

    <div class="row justify-content-center url-register-group" style="margin-left: 0; margin-right: 0">
        <input type="text" id="url-register" name="url-search"
               class="form-control col-4" style=" margin-left:10px; margin-right: 10px">
        <button type="button" onclick="test()" class="btn btn-primary">검색</button>
    </div>

    <header class="header">
        <canvas id="myChart" width="500" height="50"></canvas>
    </header>

    <div>
        <input type="text" onclick="search()" id="url-search" name="url-search" placeholder="Search"
               class="form-control col-2" style="float: left; margin-left:15px; margin-right: 10px;">

    </div>
    <br><br>

    <section class="section">
        <nav class="nav url-list-group">
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
                                {{$urlList->count}}<img src="{{url('/images/graph.png')}}" height="25" width="25"
                                                        style="float:right; margin-left: 5px;">
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
