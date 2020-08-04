/**
 * 차트 설정에 넣을 dataSet
 * 날짜 데이터(일주일전부터 지금)
 * 날짜별 데이터(URL접근, URL등록 등...)
 * 분리
 */
function makeDayData(data) {

    /*
     * 지난주(lastWeek() 부터 지금까지의 날짜를 dateArr에 담음)
     */
    let dateArr = getDates(lastWeek(), new Date())
        .map((v) => v.toISOString().slice(5, 10))
        .join(" ")
        .split(' ');

    let countData = [];             // 일별 데이터 담을 배열
    let cnt = 0;                    // 데이터 개수 체크
    let dataLength = data.length;   // 데이터 개수
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

/**
 * 이전 URL링크 차트 데이터 생성
 * @param data
 * @returns {{linkCount: [], linkName: []}}
 */
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
/**
 * 날짜 리스트 생성
 * @param start
 * @param end
 * @returns {[]}
 */
function getDates(start, end) {
    var arr = [];
    for (dt = start; dt <= end; dt.setDate(dt.getDate() + 1)) {
        arr.push(new Date(dt));
    }
    return arr;
}

/**
 * 한달전의 날짜 반환
 * @returns {Date}
 */
function lastMonth() {
    var d = new Date()
    var monthOfYear = d.getMonth();
    d.setMonth(monthOfYear - 1);
    return d
}

/**
 * 일주일전의 날짜 반환
 * @returns {Date}
 */
function lastWeek() {
    var d = new Date()
    var day = d.getDate();
    d.setDate(day - 7);
    return d
}

////////////
