let urlData = [];

/**
 * Guest URL 등록 요청
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
        url: '/guest/create',
        dataType: 'json',
        data: {'url': url},
        success: function (data) {
            if (data['rst'] === "false") {
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

/**
 * Guest URL 등록시 URL 리스트 갱신
 */
function makeGuestUrlTemplate() {
    let html = "";
    for (let i = 0; i < urlData.length; i++) {
        if (urlData[i]['shortUrl'] === "false") {
            html +=
                '<tr>' +
                '<td>' + urlData[i]["originalUrl"] + '</td>' +
                '<td>' + urlData[i]["msg"] + '</a>' +
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
