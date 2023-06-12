$(document).ready(function() {
    init_mask();
});

function init_mask() {
    $('[data-toggle="input-mask"]').each(function(a, e) {
        var t = $(e).data("maskFormat"),
        n = $(e).data("reverse");

        null != n ? $(e).mask(t, {
            reverse: n
        }) : $(e).mask(t)
    })  
}
