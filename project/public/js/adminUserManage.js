function requestAdminDeleteUser(tagData) {
    if (confirm("정말 삭제하시겠습니까?") === false) {
        return;
    }

    let id = $(tagData).parent().parent().attr('id');
    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'delete',
        url: '/admin/users/' + id,
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

function requestAdminGiveAuth(tagData) {
    if (confirm("정말 권한을 부여하겠습니까?") === false) {
        return;
    }

    let id = $(tagData).parent().parent().attr('id');
    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'put',
        url: '/admin/users/give-auth/' + id,
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

function requestAdminWithdrawAuth(tagData) {
    if (confirm("정말 권한을 회수하시겠습니까?") === false) {
        return;
    }

    let id = $(tagData).parent().parent().attr('id');
    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'put',
        url: '/admin/users/withdraw-auth/' + id,
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

function checkUserSelector() {
    if($('#search').val() === ""){
        $('#user-search-help').show();
        $('#user-search-help').html("검색어를 입력하세요");
        $("#search").addClass("is-invalid");
        return false;
    }
}
