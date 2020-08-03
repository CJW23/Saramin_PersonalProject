/**
 * 유저 이름 변경 요청
 */
function requestEditInfo() {
    const name = $('#name').val();
    if (name.length > MAX_NAME_LENGTH || name.length < MIN_NAME_LENGTH) {
        alert('1자 이상 10자 이내로 입력하세요');
        return;
    }
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'put',
        url: '/users/setting/info',
        dataType: 'json',
        data: {'name': name},
        success: function (data) {
            editInfoResponse(data['rst']);
        },
        error: function (data) {
            alert('통신 오류 발생');
        }
    });

}

/**
 * 닉네임 변경 실시간 중복 체크
 */
function requestCheckNickname() {
    const originalNickname = $('#nickname').attr('name');
    const nickname = $('#nickname').val();

    if (originalNickname === nickname) {
        $('#nickname-check').data('check', FAIL);
        $('#nickname-check-help').html("기존 닉네임과 동일합니다.");
        return;
    } else if (nickname.length > MAX_NICKNAME_LENGTH || nickname.length < MIN_NICKNAME_LENGTH) {
        $('#nickname-check').data('check', FAIL);
        $('#nickname-check-help').html("3자 이상 10자이내로 입력해주세요");
        return;
    }

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        url: '/users/setting/checknickname',
        data: {'nickname': nickname},
        success: function (data) {
            checkNicknameResponse(data['rst']);
        },
        error: function (data) {
            alert('통신 오류 발생');
        }
    });
}

/**
 * 닉네임 수정 요청
 */
function requestEditNickname() {
    if ($('#nickname-check').data('check') == FAIL) {
        alert("닉네임을 확인해주세요");
        return;
    }
    const inputNickname = $('#nickname').val();

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'put',
        url: '/users/setting/nickname',
        data: {'nickname': inputNickname},
        success: function (data) {
            editNicknameResponse(data['rst']);
        },
        error: function (data) {
            alert('통신 오류 발생');
        }
    });

}

/**
 * 비밀번호 수정 요청
 */
function requestEditPassword() {
    if (!validationPassword()) {
        return;
    }
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'put',
        url: '/users/setting/password',
        data: {
            'current_password': $('#current_password').val(),
            'new_password': $('#new_password').val(),
            'new_confirm_password': $('#new_confirm_password').val()
        },
        success: function (data) {
            editPasswordResponse(data['type'], data['rst']);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

/**
 * 회원 탈퇴 요청
 */
function requestDropUser() {
    if (!dropUserTextCheck()) {
        $('#password_help').html('');
        $('#drop_text_help').html("문구를 입력해주세요");
        return;
    }
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'delete',
        url: '/users/setting/delete',
        data: {
            'current_password': $('#current_password').val()
        },
        dataType: 'json',
        success: function (data) {
            dropUserResponse(data['rst']);
        },
        error: function (data) {
            console.log(data);
            alert("통신 오류 발생");
        }
    });
}

/**
 * 탈퇴요청 텍스트 입력 검증
 * @returns {boolean}
 */
function dropUserTextCheck() {
    return $('#drop-text').val() === "탈퇴 요청";
}

/**
 * 비밀번호 정규식 검증
 * @returns {boolean}
 */
function validationPassword() {
    $('#edit-password').attr('disabled', true);
    const firstPwd = $('#new_password').val();
    const secondPwd = $('#new_confirm_password').val();
    const regex = /(?=.*\d{1,50})(?=.*[~`!@#$%\^&*()-+=]{1,50})(?=.*[a-zA-Z]{2,50}).{8,50}$/;
    $('#password_help, #change_password_help, #confirm_password_help').html('');

    if (firstPwd === '') {
        $('#change_password_help').html('비밀번호를 입력하세요');
    } else if (!regex.test(firstPwd)) {
        $('#change_password_help').html('8-15자 영문 숫자 특수문자를 포함해주세요');
    } else if (firstPwd !== secondPwd) {
        $('#confirm_password_help').html("비밀번호를 확인해주세요");
    } else if (firstPwd === secondPwd) {
        $('#confirm_password_help').html("");
        $('#change_password_help').html("");
        $('#edit-password').attr('disabled', false);
        return true;
    }
    return false;
}

