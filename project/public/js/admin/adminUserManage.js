/**
 * 관리자가 유저 삭제 요청
 * @param tagData
 */
function requestAdminDeleteUser(tagData) {
    if (confirm("정말 삭제하시겠습니까?") === false) {
        return;
    }
    let id = $(tagData).parent().parent().attr('id');
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'delete',
        url: '/admin/users/' + id,
        dataType: 'json',
        success: function (data) {
            adminReloadResponse(data['result']);
        },
        error: function (data) {
            alert("에러 발생");
        }
    });
}

/**
 * 관리자가 유저에게 권한 부여 요청
 * @param tagData
 */
function requestAdminGiveAuth(tagData) {
    if (confirm("정말 권한을 부여하겠습니까?") === false) {
        return;
    }

    let id = $(tagData).parent().parent().attr('id');
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'put',
        url: '/admin/users/give-auth/' + id,
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
 * 관리자가 유저의 권한 회수 요청
 * @param tagData
 */
function requestAdminWithdrawAuth(tagData) {
    if (confirm("정말 권한을 회수하시겠습니까?") === false) {
        return;
    }

    let id = $(tagData).parent().parent().attr('id');
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'put',
        url: '/admin/users/withdraw-auth/' + id,
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
 * 유저 검색 빈칸 검증
 * @returns {boolean}
 */
function checkUserSelector() {
    if ($('#search').val() === "") {
        $('#user-search-help').show();
        $('#user-search-help').html("검색어를 입력하세요");
        $("#search").addClass("is-invalid");
        return false;
    }
}
