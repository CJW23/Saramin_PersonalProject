let urlData = [];
function requestCreateUrl() {
    $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        url: '/url/create',
        dataType: 'json',
        data: {
            'url': $('#enter_url').val(),
            'userid': 1
        },
        success: function (data) {
            console.log(data);
            if(data['shortUrl'] == "false"){
                $("#shortUrl").text("유효하지 않은 URL");
            }
            else {
                urlData.push(data);
                makeTemplate();
            }
            console.log(urlData);
        },
        error: function (data) {
            console.log(data);

        }
    });
}
function makeTemplate(){
    let html = "";
    for(let i =0; i<urlData.length; i++){
        html +=
            '<tr>' +
            '<td>'+ urlData[i]["originalUrl"] +'</td>'+
            '<td><a href="' + urlData[i]["shortUrl"]+'" id="shortUrl">' + urlData[i]['shortUrl'] + '</a>' +
            '</td>' +
            '</tr>';
    }
    html += "</table>";
    $("#urlList").html(html);
}
