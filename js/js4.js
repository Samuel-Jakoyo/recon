$(document).ready(function() {
        $(document).on("change", ".all:not('.minus')", function (e) {
    $(':checkbox').prop("checked", $(this).is(":checked"));
});

$(document).on("change", ".all.minus", function (e) {
    $(':checkbox').prop("checked", false);
    $(".all").removeClass("minus");
});
$(document).on("change", ":checkbox:not('.all')", function (e) {
    if ($(':checkbox').not(".all").length == $(':checkbox:checked').not(".all").length) {
        $(".all").prop("checked", true).removeClass("minus");
    } else {
        $(".all").prop("checked", false).addClass("minus");
        if ($(':checkbox:checked').not(".all").length == 0) {
            $(".all").removeClass("minus");
        }
    }
});
    });
