/**
 * Guest URL 등록 응답
 * @param data
 */
function guestCreateResponse(data) {
    if (data['shortUrl'] === "false") {
        urlData.push(data);
        makeGuestUrlTemplate();
        return 0;
    }
    let urlList = JSON.parse(localStorage.getItem("lists"));
    if (urlList != null) {
        urlList.push(data);
        localStorage.setItem("lists", JSON.stringify(urlList));
    } else {
        let arr = []
        arr.push(data);
        localStorage.setItem("lists", JSON.stringify(arr));
    }
    urlData.push(data);
    makeGuestUrlTemplate();
}

/**
 * 유저가 Index페이지에 접속할 시 과거에 등록했던 URL 리스트 LocalStorage에서 가져옴
 */
function makeStorageUrlList() {
    let lists = JSON.parse(localStorage.getItem("lists"));
    for(let i=0; i<lists.length; i++){
        urlData.push(lists[i]);
    }
    makeGuestUrlTemplate();
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
