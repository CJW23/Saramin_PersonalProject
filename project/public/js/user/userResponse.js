/**
 * 유저 URL 생성 응답
 * 금지 URL, 이미 등록 URL, 존재하지 않는 URL일시 화면에 메시지 출력
 * 등록 성공시 Modal창 닫고, URL 리스트 갱신
 * @param data
 */
function createUrlResponse(data) {
    //예외 처리->(금지 URL, 이미 등록 URL, 존재하지 않는 URL)
    if (data['rst'] === "false") {
        $('#url_register_help').html(data['msg']);
        $('#register-spinner').hide();
        return;
    }
    makeUserUrlTemplate(data);                      //뷰 갱신
    requestTotalData();
    $('#register-spinner').hide();
    $('#url-register-modal').modal("hide");         //modal 창 닫기
}

/**
 * 유저 URL 삭제 응답
 * 삭제시 URL 리스트, Total Data 갱신
 * @param data
 */
function removeUrlResponse(data) {
    $('#exist-select').hide();
    $('#empty-select').show();
    makeUserUrlTemplate(data);
    requestTotalData();     //total데이터 갱신
    $('.url-detail-view').show();
    $('.url-delete-view').hide();
}

/**
 * 상세 URL 정보 웹화면 갱신
 * @param id
 * @param createdAt
 * @param nameUrl
 * @param originalUrl
 * @param shortUrl
 * @param count
 */
function urlDetailResponse(id, createdAt, nameUrl, originalUrl, shortUrl, count) {
    let dateTime = convertDate(createdAt);
    $('#urlId').attr('data-field', id);
    $('.detail-created-date').html("CREATED " + dateTime['ymd'] + " " + dateTime['time']);
    $('.detail-name-url').html(nameUrl);
    $('.detail-original-url').attr('href', originalUrl).html(originalUrl);
    $('.detail-short-url').attr('href', "http://" + shortUrl).html(shortUrl);
    $('.detail-count').html("TOTAL : " + count);
    $('#short-url').val(shortUrl);
    $('#exist-select').show();
    makeUrlAccessChart();
}

/**
 * URL 갱신(제거, 추가)시 Total 데이터 갱신
 * @param totalNum
 * @param totalSum
 */
function totalDataResponse(totalNum, totalSum) {
    $('#total-num').html(totalNum);
    $('#total-sum').html(totalSum);
}

/**
 * 이름 변경 응답
 * 성공시 새로고침
 * @param rst
 */
function editInfoResponse(rst) {
    if(rst === TRUE) {
        alert('수정 완료');
        window.location.href = '/users/setting/edit-info';
    } else {
        alert("오류 발생");
    }
}

/**
 * 닉네임 실시간 중복 검사
 * 데이터 필드의 값을 변경
 * @param rst
 */
function checkNicknameResponse(rst) {
    if (rst === TRUE) {
        $('#nickname-check').data('check', '1');
        $('#nickname-check-help').html("사용가능한 닉네임입니다");
    } else {
        $('#nickname-check').data('check', '0');
        $('#nickname-check-help').html("이미 사용중인 닉네입니다");
    }
}

/**
 * 닉네임 수정 응답
 * 완료시 새로고침
 * @param rst
 */
function editNicknameResponse(rst) {
    if (rst === TRUE) {
        alert('수정 완료');
        window.location.href = '/users/setting/nickname';
    } else {
        alert("오류 발생");
    }
}

/**
 * 패스워드 변경 요청 응답
 * 기존 비밀번호와 같을 때 예외
 * 기존 비밀번호 틀릴 때 예외
 * 변경 완료시 새로고침
 * @param type
 * @param rst
 */
function editPasswordResponse(type, rst) {
    //기존 비밀번호와 변경할 비밀번호 같음
    if (type === SAME_PASSWORD) {
        $('#change_password_help').html(rst);
    }
    //기존 비밀번호 틀림
    else if (type === WRONG_PASSWORD) {
        $('#password_help').html(rst);
    }
    //변경 완료
    else  if(type === CORRECT_PASSWORD){
        alert(rst);
        window.location.href = '/users/setting/info';
    }
}

/**
 * 회원 탈퇴 응답
 * 완료시 Logout 후 Index 페이지로 이동
 * @param rst
 */
function dropUserResponse(rst) {
    if (rst === TRUE) {
        alert("탈퇴 완료");
        window.location.href = '/';
    } else if (rst === WRONG) {
        $('#drop_text_help').html("");
        $('#password_help').html("비밀번호를 확인해주세요");
    } else {
        alert("오류 발생");
    }
}

/**
 *
 * @param datas
 */
function makeUserUrlTemplate(datas) {
    let html = "";
    datas.forEach(data => {
        html +=
            "<div class='url-list'>" +
            "<input type='checkbox' id='" + data['id'] + "' name='url-check' onclick='urlCheck()' style='float: right'>" +
            "<div id='" + data['id'] + "' onclick='requestUrlDetail(this)'>" +
            "<div class='original-url-text'>" +
            data['name'] +
            "</div>" +
            "<div class='container'>" +
            "<div class='shortening-url-text row justify-content-between'>" +
            "<div>" +
            data['short_url'] +
            "</div>" +
            "<div class='spinner-border' id='spinner" + data['id'] + "' role='status' style='display: none'></div> " +
            "<div class='url-count'>" +
            data['count'] + "<img src='/images/graph.png' height='25' width='25' style='float:right; margin-left: 5px;'>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>"
    });
    $(".url-list-group").html(html);
}
