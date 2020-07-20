//이름 수정 요청
function requestEditInfo(){
    let name = $('#name').val();
    if(name.length > 10){
        alert('10자 이내로 입력하세요');
    }
    else {
        $.ajax({
            //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'put',
            url: '/users/setting/info',
            data: {
                'name': name
            },
            success: function (data) {
                alert('수정 완료');
                window.location.href = '/users/setting/edit-info';
            },
            error: function (data) {
                alert('오류 발생');
            }
        });
    }
}

//닉네임 수정 요청
function requestNickname(){
    let originalNickname = $('#nickname').attr('name');
    let inputNickname = $('#nickname').val();

    if(originalNickname === inputNickname){
        alert('기존과 동일합니다');
    }
    else if(inputNickname.length === 0 ){
        alert('별명을 입력해주세요');
    }
    else if(inputNickname.length > 10){
        alert('별명은 10자이내로 입력해주세요');
    }
    else {
        $.ajax({
            //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'put',
            url: '/users/setting/nickname',
            data: {
                'nickname': inputNickname
            },
            success: function (data) {
                alert('수정 완료');
                window.location.href = '/users/setting/nickname';
            },
            error: function (data) {
                console.log(data);
                alert('오류 발생');
            }
        });
    }
}

//비밀번호 수정 요청
function requestPassword(){
    if(!validationPassword()){
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
            if(data['type'] === 1){
                $('#change_password_help').html(data['msg']);
            }
            //기존 비밀번호 틀림
            else if(data['type'] === 2){
                $('#password_help').html(data['msg']);
            }
            //변경 완료
            else {
                alert(data['msg']);
                window.location.href = '/users/setting/info';
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function requestDropUser() {
    if(!dropUserTextCheck()){
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
        success: function (data) {
            console.log(data);
            if(data === 'true'){
                alert("탈퇴 완료");
                window.location.href = '/';
            }
            else{
                $('#drop_text_help').html("");
                $('#password_help').html("비밀번호를 확인해주세요");
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function dropUserTextCheck(){
    return $('#drop-text').val() === "탈퇴 요청";
}
//비밀번호 검증
function validationPassword(){
    let firstPwd = $('#new_password').val();
    let secondPwd = $('#new_confirm_password').val();
    let regex = /(?=.*\d{1,50})(?=.*[~`!@#$%\^&*()-+=]{1,50})(?=.*[a-zA-Z]{2,50}).{8,50}$/;
    $('#password_help, #change_password_help, #confirm_password_help').html('');

    if(firstPwd === ''){
        $('#change_password_help').html('비밀번호를 입력하세요');
    }
    else if(secondPwd === ''){
        $('#confirm_password_help').html('비밀번호를 입력하세요');
    }
    else if(!regex.test(firstPwd)){
        $('#change_password_help').html('8-15자 영문 숫자 특수문자를 포함해주세요');
    }
    else if(firstPwd !== secondPwd){
        $('#confirm_password_help').html("비밀번호를 확인해주세요");
    }
    else{
        return true;
    }
    return false;
}

