@extends('layouts.userSetting')

@section('menu')

    <a href="{{ route('info') }}" class="list-group-item list-group-item-action">개인 정보</a>
    <a href="{{ route('editInfo') }}" class="list-group-item list-group-item-action">개인 정보 수정</a>
    <a href="{{ route('nickname') }}" class="list-group-item list-group-item-action">닉네임 수정</a>
    <a href="{{ route('password') }}" class="list-group-item list-group-item-action" style="border-left: 2px solid red">비밀번호 변경</a>
    <a href="{{ route('delete') }}" class="list-group-item list-group-item-action">회원탈퇴</a>

@endsection

@section('contents')
    <p style="border-bottom: 1px solid #f7c6c5">패스워드 변경</p>
    <a href="#" class="list-group-item list-group-item-action">{{Auth::user()->nickname}}</a>
    <a href="#" class="list-group-item list-group-item-action">{{Auth::user()->nickname}}</a>
    <a href="#" class="list-group-item list-group-item-action">{{Auth::user()->nickname}}</a>

@endsection
