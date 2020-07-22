@extends('layouts.app')

@section('content')
    <!-- URL 리스트 데이터 저장-->
    <div id="data" data-field="{{$urlLists}}}"></div>

    <div class="row justify-content-center url-register-group" style="margin-left: 0; margin-right: 0">
        <input type="text" id="url-register" name="url-search"
               class="form-control col-4" style=" margin-left:10px; margin-right: 10px">
        <button type="button" onclick="requestUserCreateUrl({{Auth::user()->id}})" class="btn btn-primary">등록</button>
    </div>
    <small id="url_register_help" class="row justify-content-center" style="color: red;"></small>
    <header class="header">
        <canvas id="myChart" width="500" height="60"></canvas>
    </header>

    <div>
        <input type="text" onclick="search()" id="url-search" name="url-search" placeholder="Search"
               class="form-control col-2" style="float: left; margin-left:15px; margin-right: 10px;">
    </div>
    <br><br>

    <section class="section">
        <nav class="nav url-list-group">
            @foreach($urlLists as $urlList)
                <div class="url-list">
                    <input type="checkbox" id="{{$urlList->id}}" name="url-check" onclick="urlCheck()"
                           style="float: right">
                    <div id="{{$urlList->id}}" onclick="requestUrlDetail(this)">
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
                    </div>
                </div>
            @endforeach
        </nav>

        <article class="url-delete-view" style="display: none">
            <div id="url-count"></div>
            <button onclick="requestUserRemoveUrl()" type="button" class="btn btn-outline-danger col-1">삭제</button>
        </article>

        <article class="article url-detail-view">
            <div class="detail-created-date">awd
            </div>
            <div class="detail-created-time">awd
            </div>
            <div class="detail-original-url">awd
            </div>
            <div class="detail-short-url">wad
            </div>
            <div class="detail-count">awd
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
