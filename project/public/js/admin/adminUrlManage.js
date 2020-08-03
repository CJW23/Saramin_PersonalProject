/**
 * 관리자가 URL 삭제 요청
 * @param tagData
 */
function requestAdminDeleteUrl(tagData) {
    if (confirm("정말 삭제하시겠습니까?") === false) {
        return;
    }
    let id = $(tagData).parent().parent().attr('id');
    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'delete',
        url: '/admin/urls/' + id,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            adminReloadResponse(data['result']);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

/**
 * 관리자가 금지 URL 생성
 * 금지 URL이 이미 존재하거나, 유효하지 않은 URL일경우 화면에 표시
 */
function requestAdminCreateBanUrl() {
    let url = $('#register-ban-url').val();
    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        url: '/admin/ban',
        dataType: 'json',
        data: {
            "url": url
        },
        success: function (data) {
            adminCreateBanUrlResponse(data['result'], data['msg']);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

/**
 * 관리자가 금지 URL 삭제 요청
 * @param tagData
 */
function requestAdminDeleteBanUrl(tagData) {
    if (confirm("정말 삭제하시겠습니까?") === false) {
        return;
    }

    let id = $(tagData).parent().parent().attr('id');
    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'delete',
        url: '/admin/ban/' + id,
        dataType: 'json',
        success: function (data) {
            adminReloadResponse(data['result']);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

/**
 * URL 검색시 빈칸 검증
 * @returns {boolean}
 */
function checkUrlSelector() {
    if($('#url-search').val() === ""){
        $('#url-search-help').show();
        $('#url-search-help').html("검색어를 입력하세요");
        $("#url-search").addClass("is-invalid");
        return false;
    }
}

/**
 * 금지 URL 검색시 빈칸 검증
 * @returns {boolean}
 */
function checkBanUrlSelector() {
    if($('#url-ban-search').val() === ""){
        $('#url-ban-search-help').show();
        $('#url-ban-search-help').html("검색어를 입력하세요");
        $("#url-ban-search").addClass("is-invalid");
        return false;
    }
}
