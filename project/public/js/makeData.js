/**
 * chartjs config에 넣을 dataSet
 */
function makeDayData(data) {
    //날짜 리스트
    let dateArr = getDates(lastWeek(), new Date())
        .map((v) => v.toISOString().slice(5, 10))
        .join(" ")
        .split(' ');

    //날짜별 접근 횟수 저장
    let countData = [];
    let cnt = 0;
    let dataLength = data.length;
    //날짜별 접근 횟수 리스트 생성
    for (let i = 0; i < dateArr.length; i++) {
        //접근한 날짜가 존재하면
        if (cnt < dataLength && data[cnt]['dates'] === dateArr[i]) {
            countData.push(Number(data[cnt]['count']));
            ++cnt;
        } else {
            countData.push(0);
        }
    }
    return {
        'countData': countData,
        'dateArr': dateArr
    };
}

function makeLinkData(data) {
    let linkName = [];
    let linkCount = [];
    for(let i = 0; i<data.length; i++){
        linkName.push(data[i]['before_url']);
        linkCount.push(data[i]['cnt']);
    }
    return {
        'linkName': linkName,
        'linkCount': linkCount
    };
}

//////한달전 날짜에서 현재 날짜까지의 리스트 구하는 함수
function getDates(start, end) {
    var arr = [];
    for (dt = start; dt <= end; dt.setDate(dt.getDate() + 1)) {
        arr.push(new Date(dt));
    }
    return arr;
}

function lastMonth() {
    var d = new Date()
    var monthOfYear = d.getMonth();
    d.setMonth(monthOfYear - 1);
    return d
}

function lastWeek() {
    var d = new Date()
    var day = d.getDate();
    d.setDate(day - 7);
    return d
}

////////////
