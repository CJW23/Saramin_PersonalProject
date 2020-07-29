@extends('layouts.admin')

@section('menu')
    <a href="{{Route("adminIndex")}}" class="list-group-item list-group-item-action" style="border-left: 2px solid red">통계</a>
    <a href="{{Route("adminUser")}}" class="list-group-item list-group-item-action">유저 관리</a>
    <a href="{{Route("adminUrl")}}" class="list-group-item list-group-item-action">URL 관리</a>
    <a href="{{Route("adminBanUrl")}}" class="list-group-item list-group-item-action">차단 URL 관리</a>
@endsection

@section('script')
    <script src="{{ asset('js/adminChartConfig.js') }}"></script>
@endsection
@section('contents')
    <div id="day-url-data" data-field="{{$dayUrlCount}}"></div>
    <div id="day-user-data" data-field="{{$dayUserCount}}"></div>
    <div class="container">
        <div class="admin-content row align-items-center justify-content-center">
            <div class=" form-control shadow-sm col-4" style="font-size:20px; height: 100px">
                <div class="admin-total-text">
                    총 유저수<br>
                    {{$totalUser[0]->user_count}}
                </div>
            </div>
            <div class=" form-control shadow-sm col-4" style="font-size:20px; height: 100px">
                <div class="admin-total-text">
                    총 URL<br>
                    {{$totalUrl[0]->url_count}}
                </div>
            </div>
            <div class=" form-control shadow-sm col-4" style="font-size:20px; height: 100px">
                <div class="admin-total-text">
                    총 이용수<br>
                    {{$totalAccessUrl[0]->url_access_count}}
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="admin-chart col-6 shadow-sm">
                <div style="text-align: center; font-size: 15px">
                    7일간 URL 등록
                </div>
                <canvas id="day-url-count" height="200"></canvas>
            </div>
            <div class="admin-chart col-6 shadow-sm">
                <div style="text-align: center; font-size: 15px">
                    7일간 회원가입
                </div>
                <canvas id="day-user-count" height="200"></canvas>
            </div>
        </div>
        <script>makeChart();</script>
    </div>
@endsection
