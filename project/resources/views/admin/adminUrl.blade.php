@extends('layouts.admin')

@section('menu')
    <a href="{{Route("adminIndex")}}" class="list-group-item list-group-item-action">통계</a>
    <a href="{{Route("adminUser")}}" class="list-group-item list-group-item-action">유저 관리</a>
    <a href="{{Route("adminUrl")}}" class="list-group-item list-group-item-action" style="border-left: 2px solid red">URL
        관리</a>
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

    <div>
        <button class="btn btn-outline-primary" data-toggle="modal" data-target="#register-ban-url-modal">등록</button>
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
        </table>
    </div>

    <div class="modal fade" id="register-ban-url-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">금지 URL 등록</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">URL</label>
                        <!-- URL 입력-->
                        <input type="text" class="form-control" id="register-ban-url" name="register-ban-url" value="http://"
                               placeholder="Enter URL">
                        <small id="register-ban-url-help" class="row justify-content-center" style="color: red;"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="requestAdminCreateBanUrl()">등록</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                </div>
            </div>
        </div>
    </div>
@endsection
