@extends('layouts.userSetting')

@section('menu')

    <a href="{{ route('info') }}" class="list-group-item list-group-item-action" style="border-left: 2px solid red">개인 정보</a>
    <a href="{{ route('editInfo') }}" class="list-group-item list-group-item-action">개인 정보 수정</a>
    <a href="{{ route('password') }}" class="list-group-item list-group-item-action">비밀번호 변경</a>
    <a href="{{ route('delete') }}" class="list-group-item list-group-item-action">회원탈퇴</a>

@endsection

@section('contents')
    <p style="border-bottom: 1px solid #81e6d9; padding-bottom: 15px;">개인 정보</p>
    <div class="form-group">
        <label for="name">이름</label>
        <input value="{{Auth::user()->name}}" id="name" class="form-control" readonly>
    </div>
    <div class="form-group">
        <label for="nickname">닉네임</label>
        <input value="{{Auth::user()->nickname}}" id="nickname" class="form-control" readonly>
    </div>
    <div class="form-group">
        <label for="email">이메일</label>
        <input value="{{Auth::user()->email}}" id="email" class="form-control" readonly>
    </div>
    <div class="form-group">
        <label for="created-at">만든 날짜</label>
        <input value="{{Auth::user()->created_at}}" id="created-at" class="form-control" readonly>
    </div>
@endsection
