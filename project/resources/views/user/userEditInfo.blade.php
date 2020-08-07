@extends('layouts.userSetting')

@section('menu')

    <a href="{{ route('info') }}" class="list-group-item list-group-item-action">개인 정보</a>
    <a href="{{ route('editInfo') }}" class="list-group-item list-group-item-action" style="border-left: 2px solid red">개인
        정보 수정</a>
    <a href="{{ route('nickname') }}" class="list-group-item list-group-item-action">닉네임 수정</a>
    <a href="{{ route('password') }}" class="list-group-item list-group-item-action">비밀번호 변경</a>
    <a href="{{ route('delete') }}" class="list-group-item list-group-item-action">회원탈퇴</a>

@endsection

@section('contents')
    <div class="form-group content-name">
        개인 정보 수정
    </div>
    <div class="form-group content-div">
        <label for="name">이름</label>
        <input value="{{old('name') ? old('name'):Auth::user()->name}}" id="name" name="name" class="form-control">
    </div>
    <div class="form-group content-div">
        <label for="nickname">닉네임</label><br>
        <input value="{{old('name') ? old('name'):Auth::user()->nickname}}" id="nickname" name="nickname"
               class="form-control" readonly style="background-color: #81e6d9;">

    </div>
    <div class="form-group content-div">
        <label for="email">이메일</label>
        <input value="{{App\Logic\EncryptionModule::decrypt(Auth::user()->email)}}" id="email" class="form-control" readonly
               style="background-color: #81e6d9;">
    </div>
    <div class="form-group content-div">
        <label for="phone">핸드폰</label>
        <input value="{{decrypt(Auth::user()->phone)}}" id="email" class="form-control" readonly
               style="background-color: #81e6d9;">
    </div>
    <div class="form-group content-div">
        <label for="created-at">만든 날짜</label>
        <input value="{{Auth::user()->created_at}}" id="created-at" class="form-control" readonly
               style="background-color: #81e6d9;">
    </div>
    <button type="button" onclick="requestEditInfo()" class="btn btn-success col-2">수정</button>
@endsection
