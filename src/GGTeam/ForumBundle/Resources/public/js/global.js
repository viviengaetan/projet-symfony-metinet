$(document).ready(function() {

});

function messageAlert(message, level) {
    level = typeof level !== undefined ? level : "info";
    $(".alert-"+level).removeClass("hidden");
    $(".alert-"+level).text(message);
    setTimeout(function () {
        $(".alert-"+level).addClass("hidden");
        $(".alert-"+level).text("");
    }, 5000);

}