@extends('layouts.userSetting')

@section('menu')

    <a href="{{ route('info') }}" class="list-group-item list-group-item-action">개인 정보</a>
    <a href="{{ route('editInfo') }}" class="list-group-item list-group-item-action">개인 정보 수정</a>
    <a href="{{ route('nickname') }}" class="list-group-item list-group-item-action">닉네임 수정</a>
    <a href="{{ route('password') }}" class="list-group-item list-group-item-action">비밀번호 변경</a>
    <a href="{{ route('delete') }}" class="list-group-item list-group-item-action" style="border-left: 2px solid red">회원탈퇴</a>

@endsection

@section('contents')
    <div class="form-group content-name">회원 탈퇴</div>
    <div class="form-group">
        <label for="current_password">패스워드</label><br>
        <input type="password" id="current_password" name="current_password"
               class="form-control">
        <small id="password_help" class="form-text text-muted"></small>
    </div>
    <div class="form-group">
        <label for="current_password">"탈퇴 요청"을 입력해주세요</label><br>
        <input type="text" id="drop-text" name="drop-text"
               class="form-control">
        <small id="drop_text_help" class="form-text text-muted"></small>
    </div>
    <button type="button" onclick="requestDropUser()" class="btn btn-danger col-2">회원 탈퇴</button>
@endsection
