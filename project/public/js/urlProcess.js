let urlData = [];

//비로그인 URL 변환
function requestGuestCreateUrl() {
    let url = $('#enter_url').val();

    //URL 입력이 없을때.
    if (url === "") {
        return;
    }

    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        url: '/url/create',
        dataType: 'json',
        data: {
            'url': url,
            'userid': 1
        },
        success: function (data) {
            console.log(data);
            if (data['shortUrl'] === "false") {
                urlData.push(data);
                makeGuestUrlTemplate();
            } else {
                urlData.push(data);
                makeGuestUrlTemplate();
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

//로그인 유저 URL 변환
function requestUserCreateUrl(id) {
    //유효하지 않은 URL 표현 없애기(있는 경우)
    $('#url_register_help').html("");
    let url = $('#url-register').val();
    let nameUrl = $('#url-name-register').val();

    //URL 입력이 없을때.
    if (url === "" || url === "http://" || url === "https://") {
        $('#url_register_help').html("URL을 입력하세요");
        return;
    }
    alert("awd");
    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        url: '/users/urls/create',
        dataType: 'json',
        data: {
            'url': url,
            'userid': id,
            'nameUrl': nameUrl
        },
        success: function (data) {
            console.log(data['result']);
            if (data['result'] === "not exist") {
                $('#url_register_help').html("유효하지 않은 URL입니다.");
                return 0;
            } else if (data['result'] === "already exist") {
                $('#url_register_help').html("이미 등록한 url입니다.");
                return 0;
            }
            $('#url-register-modal').modal("hide");
            makeUserUrlTemplate(data);
            requestTotalData(); //total 데이터 갱신
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function requestUserRemoveUrl() {
    if (confirm("정말 삭제하시겠습니까?") === false) {
        return;
    }
    let deleteList = []
    $('input:checkbox[name=url-check]:checked').each(function () {
        deleteList.push(this.id);           //체크된 URL들 배열에 넣음
    });
    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'delete',
        url: '/users/urls/delete',
        dataType: 'json',
        data: {
            'urlIdList': deleteList
        },
        success: function (data) {
            makeUserUrlTemplate(data);
            requestTotalData();     //total데이터 갱신
            $('.url-detail-view').show();
            $('.url-delete-view').hide();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function makeUserUrlTemplate(datas) {
    let html = "";

    datas.forEach(data => {
        html +=
            "<div class='url-list'>" +
            "<input type='checkbox' id='" + data['id'] + "' name='url-check' onclick='urlCheck()' style='float: right'>" +
            "<div id='" + data['id'] + "' onclick='requestUrlDetail(this)'>" +
            "<div class='original-url-text'>" +
            data['original_url'] +
            "</div>" +
            "<div class='container'>" +
            "<div class='shortening-url-text row justify-content-between'>" +
            "<div>" +
            data['short_url'] +
            "</div>" +
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

function makeGuestUrlTemplate() {
    let html = "";
    for (let i = 0; i < urlData.length; i++) {
        if (urlData[i]['shortUrl'] === "false") {
            html +=
                '<tr>' +
                '<td>' + urlData[i]["originalUrl"] + '</td>' +
                '<td>유효하지 않은 URL입니다</a>' +
                '</td>' +
                '</tr>';
        } else {
            html +=
                '<tr>' +
                '<td>' + urlData[i]["originalUrl"] + '</td>' +
                '<td><a href="http://' + urlData[i]["shortUrl"] + '" id="shortUrl">' + urlData[i]['shortUrl'] + '</a>' +
                '</td>' +
                '</tr>';
        }
    }
    html += "</table>";
    $("#urlList").html(html);
}

function initModalButton() {
    $('#url_register_help').html("");
    $('#url-register').val("http://");
    $('#url-name-register').val("");
}
