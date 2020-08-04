let urlData = [];

/**
 * url URL 등록 요청
 */
function requestGuestCreateUrl() {
    let url = $('#enter_url').val();
    //URL 입력이 없을때.
    if (url === "") {
        return;
    }
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        url: 'url/create',
        dataType: 'json',
        data: {'url': url},
        success: function (data) {
            guestCreateResponse(data);
        },
        error: function (data) {
            console.log(data);
        }
    });
}
