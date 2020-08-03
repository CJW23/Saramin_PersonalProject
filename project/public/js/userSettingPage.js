//이름 수정 요청
function requestEditInfo() {
    let name = $('#name').val();
    if (name.length > 10 || name.length < 1) {
        alert('1자 이상 10자 이내로 입력하세요');
    } else {
        $.ajax({
            //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'put',
            url: '/users/setting/info',
            dataType: 'json',
            data: {
                'name': name
            },
            success: function (data) {
                if(data['rst'] === 'true') {
                    alert('수정 완료');
                    window.location.href = '/users/setting/edit-info';
                } else {
                    alert("오류 발생");
                }
            },
            error: function (data) {
                alert('통신 오류 발생');
            }
        });
    }
}

function requestCheckNickname() {
    let originalNickname = $('#nickname').attr('name');
    let nickname = $('#nickname').val();

    if (originalNickname === nickname) {
        $('#nickname-check').data('check', '0');
        $('#nickname-check-help').html("기존 닉네임과 동일합니다.");
        return;
    } else if (nickname.length > 10 || nickname.length < 3) {
        $('#nickname-check').data('check', '0');
        $('#nickname-check-help').html("3자 이상 10자이내로 입력해주세요");
        return;
    }

    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        url: '/users/setting/checknickname',
        data: {
            'nickname': nickname
        },
        success: function (data) {
            if (data['rst'] === 'true') {
                $('#nickname-check').data('check', '1');
                $('#nickname-check-help').html("사용가능한 닉네임입니다");
            } else {
                $('#nickname-check').data('check', '0');
                $('#nickname-check-help').html("이미 사용중인 닉네입니다");
            }
        },
        error: function (data) {
            console.log(data);
            alert('오류 발생');
        }
    });
}

//닉네임 수정 요청
function requestNickname() {
    if($('#nickname-check').data('check') == '0'){
        alert("닉네임을 확인해주세요");
        return;
    }

    let inputNickname = $('#nickname').val();
    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'put',
        url: '/users/setting/nickname',
        data: {
            'nickname': inputNickname
        },
        success: function (data) {
            if(data['rst'] === 'true') {
                alert('수정 완료');
                window.location.href = '/users/setting/nickname';
            } else {
                alert("오류 발생");
            }
        },
        error: function (data) {
            alert('통신 오류 발생');
        }
    });

}

//비밀번호 수정 요청
function requestPassword() {
    if (!validationPassword()) {
        return;
    }
    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'put',
        url: '/users/setting/password',
        data: {
            'current_password': $('#current_password').val(),
            'new_password': $('#new_password').val(),
            'new_confirm_password': $('#new_confirm_password').val()
        },
        success: function (data) {
            //기존 비밀번호와 변경할 비밀번호 같음
            if (data['type'] === 1) {
                $('#change_password_help').html(data['rst']);
            }
            //기존 비밀번호 틀림
            else if (data['type'] === 2) {
                $('#password_help').html(data['rst']);
            }
            //변경 완료
            else {
                alert(data['rst']);
                window.location.href = '/users/setting/info';
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function requestDropUser() {
    if (!dropUserTextCheck()) {
        $('#password_help').html('');
        $('#drop_text_help').html("문구를 입력해주세요");
        return;
    }
    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'delete',
        url: '/users/setting/delete',
        data: {
            'current_password': $('#current_password').val()
        },
        dataType: 'json',
        success: function (data) {
            if (data['rst'] === 'true') {
                alert("탈퇴 완료");
                window.location.href = '/';
            } else if(data['rst'] === 'wrong'){
                $('#drop_text_help').html("");
                $('#password_help').html("비밀번호를 확인해주세요");
            } else {
                alert("오류 발생");
            }
        },
        error: function (data) {
            console.log(data);
            alert("통신 오류 발생");
        }
    });
}

function dropUserTextCheck() {
    return $('#drop-text').val() === "탈퇴 요청";
}

//비밀번호 검증
function validationPassword() {
    $('#edit-password').attr('disabled', true);
    let firstPwd = $('#new_password').val();
    let secondPwd = $('#new_confirm_password').val();
    let regex = /(?=.*\d{1,50})(?=.*[~`!@#$%\^&*()-+=]{1,50})(?=.*[a-zA-Z]{2,50}).{8,50}$/;
    $('#password_help, #change_password_help, #confirm_password_help').html('');

    if (firstPwd === '') {
        $('#change_password_help').html('비밀번호를 입력하세요');
    } else if (!regex.test(firstPwd)) {
        $('#change_password_help').html('8-15자 영문 숫자 특수문자를 포함해주세요');
    } else if (firstPwd !== secondPwd) {
        $('#confirm_password_help').html("비밀번호를 확인해주세요");
    } else if (firstPwd === secondPwd){
        $('#confirm_password_help').html("");
        $('#change_password_help').html("");
        $('#edit-password').attr('disabled', false);
        return true;
    }
    return false;
}

