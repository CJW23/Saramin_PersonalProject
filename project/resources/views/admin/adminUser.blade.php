@extends('layouts.admin')

@section('menu')
    <a href="{{Route("adminIndex")}}" class="list-group-item list-group-item-action">통계</a>
    <a href="{{Route("adminUser")}}" class="list-group-item list-group-item-action"
       style="border-left: 2px solid red">유저 관리</a>
    <a href="{{Route("adminUrl")}}" class="list-group-item list-group-item-action">URL 관리</a>
    <a href="{{Route("adminBanUrl")}}" class="list-group-item list-group-item-action">차단 URL 관리</a>
@endsection
@section('script')
    <script src="{{ asset('js/adminUserManage.js') }}"></script>
@endsection
@section('contents')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">이름</th>
            <th scope="col">이메일</th>
            <th scope="col">닉네임</th>
            <th scope="col">회원가입 날짜</th>
            <th scope="col">관리자 권한</th>
            <th scope="col">삭제</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr class="user" id="{{$user->id}}">
                <th>{{$user->name}}</th>
                <td>{{$user->email}}</td>
                <td>{{$user->nickname}}</td>
                <td>{{$user->created_at}}</td>
                @if($user->admin == 0)
                    <td>
                        <button class="btn btn-outline-primary" onclick="requestAdminGiveAuth(this)">관리자 권한 부여</button>
                    </td>
                @else
                    <td>
                        <button class="btn btn-outline-success" onclick="requestAdminWithdrawAuth(this)">관리자 권한 회수</button>
                    </td>
                @endif
                <td>
                    <button class="btn btn-outline-danger" onclick="requestAdminDeleteUser(this)">삭제</button>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
    {{$users->links()}}

@endsection
