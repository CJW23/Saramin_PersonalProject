/**
 * URL 상세 정보 요청
 * 각 유저의 URL 리스트를 클릭시 호출
 * @param urlId
 */
function requestUrlDetail(urlId) {
    let id = $(urlId).attr('id');
    $('#spinner'+id).show();
    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'get',
        url: '/url/detail/' + id,
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
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'get',
        url: '/users/data/total',
        dataType: 'json',
        success: function (data) {
            totalDataResponse(data[0]['total_num']);
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
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'get',
        url: '/users/data/url/' + id,
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
    return {
        'ymd': ymd,
        'time': time
    };
}

/**
 * 각 URL 복사
 * copy버튼 누를시 호출
 */
function copyUrl() {
    $('#short-url').select();
    document.execCommand('copy');
}

/**
 * 실시간 URL 리스트 검색
 */
function search() {
    $(document).ready(function () {
        $("#url-search").keyup(function () {
            const k = $(this).val();
            $(".url-list-group > .url-list").hide();
            const temp = $(".url-list-group > .url-list > div > div:nth-child(1):contains('" + k + "')");
            $(temp).parent().parent().show();
        })
    })
}

/**
 * URL 리스트의 체크박스 선택시 화면 갱신(체크박스로 URL 선택한 수 갱신)
 */
function urlCheck() {
    let count = $('input:checkbox[name=url-check]:checked').length;
    if (count > 0) {
        $('.url-detail-view').hide();
        $('.url-delete-view').show();
        let html = count + "개의 URL이 선택되었습니다<br><br>";
        $('#url-count').html(html);
    } else {
        $('.url-detail-view').show();
        $('.url-delete-view').hide();
    }
}

