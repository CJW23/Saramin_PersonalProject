@extends('layouts.admin')

@section('menu')
    <a href="{{Route("adminIndex")}}" class="list-group-item list-group-item-action">통계</a>
    <a href="{{Route("adminUser")}}" class="list-group-item list-group-item-action">유저 관리</a>
    <a href="{{Route("adminUrl")}}" class="list-group-item list-group-item-action" style="border-left: 2px solid red">URL
        관리</a>
    <a href="{{Route("adminBanUrl")}}" class="list-group-item list-group-item-action">차단 URL 관리</a>
@endsection
@section('script')
    <script src="{{ asset('js/adminUrlManage.js') }}"></script>
@endsection
@section('contents')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">단축 URL</th>
            <th scope="col">이메일</th>
            <th scope="col">원본 URL</th>
            <th scope="col">접근 횟수</th>
            <th scope="col">생성 날짜</th>
            <th scope="col">삭제</th>
        </tr>
        </thead>
        <tbody>
        @foreach($urls as $url)
            <tr class="user" id="{{$url->id}}">
                <th>{{$url->short_url}}</th>
                <td>{{$url->email}}</td>
                <td>{{$url->original_url}}</td>
                <td>{{$url->count}}</td>
                <td>{{$url->created_at}}</td>
                <td>
                    <button class="btn btn-outline-danger" onclick="requestAdminDeleteUrl(this)">삭제</button>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
    {{$urls->links()}}

@endsection
