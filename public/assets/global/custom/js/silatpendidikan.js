$(document).ready(function() {
    $("[data-password]").on('click', function() {
        if($(this).attr('data-password') == "false"){
            $(this).siblings("input").attr("type", "text");
            $(this).attr('data-password', 'true');
            $(this).addClass("show-password");
        } else {
            $(this).siblings("input").attr("type", "password");
            $(this).attr('data-password', 'false');
            $(this).removeClass("show-password");
        }
    });

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

function load_page(load) {
	$(load).block({
        message: '<span class="spinner-border spinner-border-sm mr-1 text-primary"></span>',
        overlayCSS: {
            backgroundColor: '#fff',
            opacity: 0.8,
            cursor: 'wait'
        },
        css: {
            border: 0,
            padding: 0,
            backgroundColor: 'none'
        }
    });
}

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
        c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
        }
    }
    return "";
}
