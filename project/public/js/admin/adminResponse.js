/**
 * 응답
 * @param {string} rst
 */
function adminReloadResponse(rst) {
    if (rst === TRUE) {
        location.reload();
    }
}

/**
 * 금지 URL 등록 응답
 * @param {string} rst
 * @param {string} msg
 */
function adminCreateBanUrlResponse(rst, msg) {
    if (rst === TRUE) {
        location.reload();
    } else {
        $('#register-ban-guest-help').html(msg);
    }
}
