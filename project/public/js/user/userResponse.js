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

function totalDataResponse(totalNum) {
    $('#total-num').html(totalNum);
    $('#total-sum').html(totalNum);
}

function editInfoResponse(rst) {
    if(rst === TRUE) {
        alert('수정 완료');
        window.location.href = '/users/setting/edit-info';
    } else {
        alert("오류 발생");
    }
}

function checkNicknameResponse(rst) {
    if (rst === TRUE) {
        $('#nickname-check').data('check', '1');
        $('#nickname-check-help').html("사용가능한 닉네임입니다");
    } else {
        $('#nickname-check').data('check', '0');
        $('#nickname-check-help').html("이미 사용중인 닉네입니다");
    }
}

function editNicknameResponse(rst) {
    if (rst === TRUE) {
        alert('수정 완료');
        window.location.href = '/users/setting/nickname';
    } else {
        alert("오류 발생");
    }
}

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

function dropUserResponse(rst) {
    if (rst === TRUE) {
        alert("탈퇴 완료");
        window.location.href = '/';
    } else if (data['rst'] === WRONG) {
        $('#drop_text_help').html("");
        $('#password_help').html("비밀번호를 확인해주세요");
    } else {
        alert("오류 발생");
    }
}
