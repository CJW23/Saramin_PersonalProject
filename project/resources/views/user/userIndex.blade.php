@extends('layouts.app')

@section('script')
    <script src="{{ asset('js/chartConfig.js') }}"></script>
@endsection
@section('content')
    <div id="access-data" data-field="{{$urlAccessData}}"></div>
    <div class="row justify-content-center url-register-group" style="margin-left: 0; margin-right: 0">
        <input type="text" id="short-url" value="awd" style="color:white;height: 0.1px;width: 0.1px; opacity: 0">
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
                <canvas id="totalAccessChart" height="37"></canvas>
            </div>
        </div>
    </header>
    <script>
        makeTotalAccessChart();
    </script>

    <div>
        <button type="button" class="btn btn-outline-primary col-2" onclick="initModalButton()" data-toggle="modal"
                data-target="#url-register-modal"
                data-whatever="@mdo" style="margin-left: 15px; margin-bottom: 10px">URL 등록
        </button>
        <br>
    </div>
    <div style="margin-bottom: 10px">
        <input style="margin-left:15px; display: block;" type="text" onclick="search()" id="url-search"
               name="url-search" placeholder="Search"
               class="form-control col-2">

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

        <article class="url-delete-view article" style="display: none">
            <div>
                <div id="url-count"></div>
                <button onclick="requestUserRemoveUrl()" type="button" class="btn btn-outline-danger col-1">삭제</button>
            </div>
        </article>

        <article class="article url-detail-view">
            <div id="empty-select" style="color: #4dc0b5; text-align: center; margin-top:100px; font-size: 40px;">
                Click URL
            </div>
            <div id="exist-select" style="display: none">
                <div id="urlId" data-field=""></div>
                <div style="border-bottom: 1px solid #2c7a7b; padding-bottom: 30px">
                    <div class="detail-created-date">
                    </div>
                    <div class="detail-name-url">
                    </div>
                    <a href="" class="detail-original-url">
                    </a>
                    <br>
                    <div class="detail-count">
                    </div>
                    <br><br>
                    <a href="" class="detail-short-url">
                    </a>
                    <button onclick="copyUrl()" type="button" class="btn-sm btn-outline-danger"
                            style="border: 1px solid red">copy
                    </button>

                </div>
                <div style="border-bottom: 1px solid #2c7a7b; padding-top: 30px; padding-bottom: 30px">
                    <canvas id="urlAccessChart" height="50">

                    </canvas>
                </div>
                <div style="border-bottom: 1px solid #2c7a7b; padding-top: 30px; padding-bottom: 30px">
                    <canvas id="linkAccessChart" height="50">

                    </canvas>
                </div>
            </div>
        </article>
    </section>

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
