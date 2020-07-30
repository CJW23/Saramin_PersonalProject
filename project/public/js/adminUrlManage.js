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
            if (data['result'] === 'true') {
                location.reload();
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

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
            if (data['result'] === 'true') {
                location.reload();
            } else {
                $('#register-ban-url-help').html(data['msg']);
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

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
            if (data['result'] === 'true') {
                location.reload();
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function checkUrlSelector() {
    if($('#url-search').val() === ""){
        $('#url-search-help').show();
        $('#url-search-help').html("검색어를 입력하세요");
        $("#url-search").addClass("is-invalid");
        return false;
    }
}

function checkBanUrlSelector() {
    if($('#url-ban-search').val() === ""){
        $('#url-ban-search-help').show();
        $('#url-ban-search-help').html("검색어를 입력하세요");
        $("#url-ban-search").addClass("is-invalid");
        return false;
    }
}
