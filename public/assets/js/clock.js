function showTime(am) {
    var session = "";
    // to get current time/ date.
    var date = new Date();
    // to get the current hour
    var h = date.getHours();
    // to get the current minutes
    var m = date.getMinutes();
    //to get the current second
    var s = date.getSeconds();
    if (am == 12) {
        // AM, PM setting
        session = "AM";

        //conditions for times behavior 
        if (h == 0) {
            h = 12;
        }
        if (h >= 12) {
            session = "PM";
        }

        if (h > 12) {
            h = h - 12;
        }
    }
    m = (m < 10) ? m = "0" + m : m;
    s = (s < 10) ? s = "0" + s : s;

    //putting time in one variable
    var time = h + ":" + m + ":" + s + " " + session;
    //putting time in our div
    $('#clock').html(time);
    //to change time in every seconds
    setTimeout(showTime, 1000);
}
showTime(24);

function count_time() {
    let current_time = $(".total-timeactive").text();
    let time = current_time.split(":");
    h = parseInt(time[0]);
    m = parseInt(time[1]);
    s = parseInt(time[2]);
    s++;
    if (s >= 60) {
        m++;
        s = 0;
    }
    if (m >= 60) {
        h++;
        m = 0;
    }
    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;
    $(".total-timeactive").text(h + ":" + m + ":" + s)
}

setInterval(count_time, 1000);
