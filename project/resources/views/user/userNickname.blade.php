@extends('layouts.userSetting')

@section('menu')

    <a href="{{ route('info') }}" class="list-group-item list-group-item-action">개인 정보</a>
    <a href="{{ route('editInfo') }}" class="list-group-item list-group-item-action">개인 정보 수정</a>
    <a href="{{ route('nickname') }}" class="list-group-item list-group-item-action" style="border-left: 2px solid red">닉네임
        수정</a>
    <a href="{{ route('password') }}" class="list-group-item list-group-item-action">비밀번호 변경</a>
    <a href="{{ route('delete') }}" class="list-group-item list-group-item-action">회원탈퇴</a>

@endsection

@section('contents')
    <div class="form-group content-name">
        개인 정보 수정
    </div>

    <div id="nickname-check" data-check="0"></div>
    <div class="form-group">
        <label for="nickname">닉네임</label><br>
        <input class="form-control" value="{{old('name') ? old('name'):Auth::user()->nickname}}" oninput="requestCheckNickname()" id="nickname" name={{Auth::user()->nickname}}>
        <small id="nickname-check-help" style="color: green;"></small>
    </div>
    <button type="button" onclick="requestEditNickname()" class="btn btn-success col-2">수정</button>
@endsection
