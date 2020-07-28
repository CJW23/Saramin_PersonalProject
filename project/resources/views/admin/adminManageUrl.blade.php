@extends('layouts.admin')

@section('menu')
    <a href="{{Route("adminIndex")}}" class="list-group-item list-group-item-action">통계</a>
    <a href="{{Route("adminManageUser")}}" class="list-group-item list-group-item-action">유저 관리</a>
    <a href="{{Route("adminManageUrl")}}" class="list-group-item list-group-item-action" style="border-left: 2px solid red">URL 관리</a>
@endsection

@section('contents')
    url 관리
@endsection
