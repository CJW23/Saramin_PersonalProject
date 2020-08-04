/**
 * 유저 URL 등록 요청
 * @param id
 */
function requestCreateUrl(id) {
    //유효하지 않은 URL 표현 없애기(있는 경우)
    $('#url_register_help').html("");
    let url = $('#guest-register').val();
    let nameUrl = $('#guest-name-register').val();

    //URL 입력이 없을때.
    if (url === "" || url === "http://" || url === "https://") {
        $('#url_register_help').html("URL을 입력하세요");
        return;
    }
    $('#register-spinner').show();

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        url: '/users/urls/create',
        dataType: 'json',
        data: {'url': url, 'userid': id, 'nameUrl': nameUrl},
        success: function (data) {
            createUrlResponse(data);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

/**
 * 유저 URL 삭제 요청
 */
function requestRemoveUrl() {
    if (confirm("정말 삭제하시겠습니까?") === false) {return;}
    let deleteList = [];
    $('input:checkbox[name=guest-check]:checked').each(function () {
        deleteList.push(this.id);           //체크된 URL들 배열에 넣음
    });
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'delete',
        url: '/users/urls/delete',
        dataType: 'json',
        data: {'urlIdList': deleteList},
        success: function (data) {
            removeUrlResponse(data);
        },
        error: function (data) {console.log(data);}
    });
}

/**
 * URL 상세 정보 요청
 * 각 유저의 URL 리스트를 클릭시 호출
 * @param urlId
 */
function requestUrlDetail(urlId) {
    let id = $(urlId).attr('id');
    $('#spinner'+id).show();
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'get',
        url: '/guest/detail/' + id,
        dataType: 'json',
        success: function (data) {
            $('#empty-select').hide();
            urlDetailResponse(
                data[0]['id'],
                data[0]['created_at'],
                data[0]['name_url'],
                data[0]['original_url'],
                data[0]['short_url'],
                data[0]['count']);
            $('#spinner'+id).hide();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

/**
 * 각 유저의 TOTAL URL 개수 요청
 * 데이터 삭제, 생성시 갱신
 */
function requestTotalData() {
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'get',
        url: '/users/data/total',
        dataType: 'json',
        success: function (data) {
            totalDataResponse(data[0]['total_num'], data[0]['total_sum']);
        },
        error: function (data) {
            console.log('에러 발생');
        }
    });
}

/**
 * 각  URL접근 데이터 요청
 * URL 리스트 클릭시 호출
 * @returns {*}
 */
function requestUrlAccessData() {
    let id = $('#urlId').attr('data-field');
    let result;
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'get',
        url: '/users/data/guest/' + id,
        dataType: 'json',
        async: false,
        success: function (data) {
            result = data;
        },
        error: function (data) {
            result = {'rst': 'false'};
        }
    });
    return result;
}

/**
 * 각 URL 이전 페이지 링크 데이터 요청
 * URL 리스트 클릭시 호출
 * @returns {*}
 */
function requestLinkAccessData() {
    let id = $('#urlId').attr('data-field');
    let result;
    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'get',
        url: '/users/data/link/' + id,
        dataType: 'json',
        async: false,
        success: function (data) {
            result = data;
        },
        error: function (data) {
            result = {'rst': 'false'};
        }
    });
    return result;
}

/**
 * DB의 시간 데이터를 날짜와 시간으로 분리
 * @param date
 * @returns {{ymd: string, time: string}}
 */
function convertDate(date) {
    let ymd = String(date).substring(0, 10);
    let time = String(date).substring(11, 19);
    return {'ymd': ymd, 'time': time};
}

/**
 * 각 URL 복사
 * copy버튼 누를시 호출
 */
function copyUrl() {
    $('#short-guest').select();
    document.execCommand('copy');
}

/**
 * 실시간 URL 리스트 검색
 */
function search() {
    $(document).ready(function () {
        $("#guest-search").keyup(function () {
            const k = $(this).val();
            $(".guest-list-group > .guest-list").hide();
            const temp = $(".guest-list-group > .guest-list > div > div:nth-child(1):contains('" + k + "')");
            $(temp).parent().parent().show();
        })
    })
}

/**
 * URL 리스트의 체크박스 선택시 화면 갱신(체크박스로 URL 선택한 수 갱신)
 */
function urlCheck() {
    let count = $('input:checkbox[name=guest-check]:checked').length;
    if (count > 0) {
        $('.guest-detail-view').hide();
        $('.guest-delete-view').show();
        let html = count + "개의 URL이 선택되었습니다<br><br>";
        $('#guest-count').html(html);
    } else {
        $('.guest-detail-view').show();
        $('.guest-delete-view').hide();
    }
}

/**
 * URL등록 Modal창 설정
 */
function initModalButton() {
    $('#url_register_help').html("");
    $('#guest-register').val("http://");
    $('#guest-name-register').val("");
}
