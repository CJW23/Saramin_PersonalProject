@extends('layouts.app')

@section('content')
    <div id="accessData" data-field="{{$urlAccessData}}"></div>
    <div class="row justify-content-center url-register-group" style="margin-left: 0; margin-right: 0">

    </div>
    <header class="header" style="background-color: white">
        <div class="row">
            <div class="col-1 total-data">
                <div style="font-size: 25px" id="total-num">{{$totalData[0]->total_num}}</div>
                <div style="font-size: 12px; margin-bottom: 25px">TOTAL URL</div>

                <div style="font-size: 25px" id="total-sum">{{$totalData[0]->total_sum}}</div>
                <div style="font-size: 12px">TOTAL CLICK</div>
            </div>
            <div class="col-11">
                <canvas id="myChart" height="37"></canvas>
            </div>
        </div>
    </header>

    <div style="background-color: white">
        <button type="button" class="btn btn-primary col-2" onclick="initModalButton()" data-toggle="modal"
                data-target="#url-register-modal"
                data-whatever="@mdo" style="margin-left: 15px; margin-bottom: 10px">URL 등록
        </button>
        <br>
    </div>
    <div style="background-color: white; padding-bottom: 5px">
        <input style="margin-left:15px; display: block;" type="text" onclick="search()" id="url-search" name="url-search" placeholder="Search"
               class="form-control col-2" style="float: left; margin-left:15px; margin-right: 10px;">

    </div>

    <section class="section">
        <nav class="nav url-list-group">
            @foreach($urlLists as $urlList)
                <div class="url-list">
                    <input type="checkbox" id="{{$urlList->id}}" name="url-check" onclick="urlCheck()"
                           style="float: right">
                    <div id="{{$urlList->id}}" onclick="requestUrlDetail(this)">
                        <div class="original-url-text">
                            {{$urlList->name}}
                        </div>
                        <div class="container">
                            <div class="shortening-url-text row justify-content-between ">
                                <div>
                                    {{$urlList->short_url}}
                                </div>
                                <div class="url-count">
                                    {{$urlList->count}}<img src="{{url('/images/graph.png')}}" height="25" width="25"
                                                            style="float:right; margin-left: 5px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </nav>

        <article class="url-delete-view" style="display: none">
            <div id="url-count"></div>
            <button onclick="requestUserRemoveUrl()" type="button" class="btn btn-outline-danger col-1">삭제</button>
        </article>

        <article class="article url-detail-view">
            <div id="empty-select" style="color: #4dc0b5; text-align: center; margin-top:100px; font-size: 40px;">
                Click URL
            </div>
            <div id="exist-select" style="display: none">
                <div class="detail-created-date">
                </div>
                <div class="detail-created-time">
                </div>
                <div class="detail-name-url">
                </div>
                <div class="detail-original-url">
                </div>
                <div class="detail-short-url">
                </div>
                <div class="detail-count">
                </div>
            </div>
        </article>
    </section>
    <script>
        makeAccessTimeData();
    </script>

    <!-- url 등록 modal -->
    <div class="modal fade" id="url-register-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">URL 등록</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">URL</label>
                        <!-- URL 입력-->
                        <input type="text" class="form-control" id="url-register" name="url-register" value="http://"
                               placeholder="Enter URL">
                        <small id="url_register_help" class="row justify-content-center" style="color: red;"></small>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Name (Option)</label>
                        <!-- URL 이름 설정 -->
                        <input type="text" class="form-control" id="url-name-register" name="url-name-register"
                               placeholder="Enter URL Name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="requestUserCreateUrl({{Auth::user()->id}})" class="btn btn-primary">
                        등록
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                </div>
            </div>
        </div>
    </div>
@endsection()
