! function(p) {
    "use strict";

    function t() {}
    t.prototype.send = function(t, i, o, e, n, a, s, r) {
        var c = {
            heading: t,
            text: i,
            position: o,
            loaderBg: e,
            icon: n,
            hideAfter: a = a || 3e3,
            stack: s = s || 1
        };
        r && (c.showHideTransition = r), console.log(c), p.toast().reset("all"), p.toast(c)
    }, p.NotificationApp = new t, p.NotificationApp.Constructor = t
}(window.jQuery),
function(i) {
    "use strict";
    i(".nama-jabatan-toast").on("click", function(t) {
        i.NotificationApp.send("Informasi!", "Nama Jabatan tidak bisa diubah.", "top-center", "#da8609", "warning")
    }),  i(".unor-toast").on("click", function(t) {
        i.NotificationApp.send("Informasi!", "Nama Unit Organisasi tidak bisa diubah.", "top-center", "#da8609", "warning")
    }), i(".tmt-jabatan-toast").on("click", function(t) {
        i.NotificationApp.send("Informasi!", "TMT Jabatan tidak bisa diubah.", "top-center", "#da8609", "warning")
    }), i(".nama-jabatan-sekarang-toast").on("click", function(t) {
        i.NotificationApp.send("Informasi!", "Nama Jabatan Sekarang tidak bisa diubah. Jika Nama Jabatan Sekarang anda tidak sesuai harap hubungi pihak BKPSDM.", "top-center", "#da8609", "warning")
    }), i(".tmt-jabatan-sekarang-toast").on("click", function(t) {
        i.NotificationApp.send("Informasi!", "TMT Jabatan Sekarang tidak bisa diubah.", "top-center", "#da8609", "warning")
    })
}(window.jQuery);