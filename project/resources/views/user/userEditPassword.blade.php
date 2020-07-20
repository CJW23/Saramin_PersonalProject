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

    <div class="form-group">
        <label for="current_password">기존 패스워드</label><br>
        <input type="password" id="current_password" name="current_password"
            class="form-control">
        <small id="password_help" class="form-text text-muted"></small>
    </div>
    <div class="form-group">
        <label for="nickname">변경할 패스워드</label><br>
        <input type="password" id="new_password" name="new_password"
            class="form-control">
        <small id="change_password_help" class="form-text text-muted"></small>
    </div>
    <div class="form-group">
        <label for="nickname">재확인</label><br>
        <input type="password" id="new_confirm_password" name="new_confirm_password"
            class="form-control">
        <small id="confirm_password_help" class="form-text text-muted">
        </small>
    </div>
    <button type="button" onclick="requestPassword()" class="btn btn-success col-2">수정</button>
@endsection
