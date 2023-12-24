var idleTime = 0;

$(document).ready(function () {
    setInterval(function () {
        idleTime++;
        if (idleTime > 299) { // 5 minutes in seconds
            window.location.href = '/logout';
        }
    }, 1000);

    $(this).mousemove(function (e) {
        idleTime = 0;
    });

    $(this).keypress(function (e) {
        idleTime = 0;
    });
});
