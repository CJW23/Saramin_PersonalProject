//URL 상세정보 요청
function requestUrlDetail(urlId) {
    let id = $(urlId).attr('id');
    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'get',
        url: '/url/detail/' + id,
        dataType: 'json',
        success: function (data) {
            let dateTime = convertDate(data['created_at']);
            $('.detail-created-date').html("CREATED " + dateTime['ymd']);
            $('.detail-created-time').html("TIME "+dateTime['time']);
            $('.detail-original-url').html(data['original_url']);
            $('.detail-short-url').html(data['short_url']);
            $('.detail-count').html(data['count']);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

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

}
//시간 데이터 포맷
function convertDate(date){
    let ymd = String(date).substring(0,10);
    let time = String(date).substring(11,19);
    return {
        'ymd': ymd,
        'time': time
    };
}
