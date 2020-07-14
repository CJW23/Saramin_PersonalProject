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
                let html = "<table>";
                for(let i =0; i<urlData.length; i++){
                    html += '<tr><td>' + urlData[i]['shortUrl'] + '</td></tr>';
                }
                html += "</table>";
                $("#test").html(html);
                //$("#shortUrl").html(data['shortUrl']);
                //$("#shortUrl").attr("href", data['shortUrl']);
                console.log(Handlebars);
            }
            console.log(urlData);
        },
        error: function (data) {
            console.log(data);

        }
    });
}
