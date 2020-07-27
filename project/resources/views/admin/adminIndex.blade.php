@extends('layouts.admin')

@section('menu')
    <a href="#" class="list-group-item list-group-item-action">개인 정보</a>
    <a href="#" class="list-group-item list-group-item-action">개인 정보</a>
    <a href="#" class="list-group-item list-group-item-action">개인 정보</a>
    <a href="#" class="list-group-item list-group-item-action">개인 정보</a>
@endsection

@section('script')
    <script src="{{ asset('js/adminChartConfig.js') }}"></script>
@endsection
@section('contents')

    <div class="admin-content row align-items-center justify-content-center">
        <div class="admin-content form-control shadow-sm col-3" style="font-size:20px; height: 100px">
            <div class="admin-total-text">
                총 유저수<br>
                {{$totalUser[0]->user_count}}
            </div>
        </div>
        <div class="admin-content form-control shadow-sm col-3" style="font-size:20px; height: 100px">
            <div class="admin-total-text">
                총 URL<br>
                {{$totalUrl[0]->url_count}}
            </div>
        </div>
        <div class="admin-content form-control shadow-sm col-3" style="font-size:20px; height: 100px">
            <div class="admin-total-text">
                총 이용수<br>
                {{$totalAccessUrl[0]->url_access_count}}
            </div>
        </div>
    </div>
    <div>
        <canvas id="day-url-count" height="100">

        </canvas>
        <script>makeUserCountChart();</script>
    </div>

@endsection
