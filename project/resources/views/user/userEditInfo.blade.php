@extends('layouts.userSetting')

@section('menu')

    <a href="{{ route('info') }}" class="list-group-item list-group-item-action">개인 정보</a>
    <a href="{{ route('editInfo') }}" class="list-group-item list-group-item-action" style="border-left: 2px solid red">개인 정보 수정</a>
    <a href="{{ route('password') }}" class="list-group-item list-group-item-action">비밀번호 변경</a>
    <a href="{{ route('delete') }}" class="list-group-item list-group-item-action">회원탈퇴</a>

@endsection

@section('contents')
    <p>개인 정보 변경</p>
    <a href="#" class="list-group-item list-group-item-action">{{Auth::user()->nickname}}</a>
    <a href="#" class="list-group-item list-group-item-action">{{Auth::user()->nickname}}</a>
    <a href="#" class="list-group-item list-group-item-action">{{Auth::user()->nickname}}</a>

@endsection
