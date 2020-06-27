export const is404 = function(error) {
    return error.response && error.response.status && error.response.status===404;
}
