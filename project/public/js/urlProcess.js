let urlData = [];
function requestCreateUrl() {
    let url = $('#enter_url').val();

    //URL 입력이 없을때.
    if(url === ""){
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
            if(data['shortUrl'] === "false"){
                urlData.push(data);
                makeTemplate();
            }
            else {
                urlData.push(data);
                makeTemplate();
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}
function makeTemplate(){
    let html = "";
    for(let i =0; i<urlData.length; i++){
        if(urlData[i]['shortUrl'] === "false"){
            html +=
                '<tr>' +
                '<td>'+ urlData[i]["originalUrl"] +'</td>'+
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
