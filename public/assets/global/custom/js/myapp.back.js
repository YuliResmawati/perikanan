(function($) {
    "use strict";
    $(document).ready(function() {
        $("#sidebar-menu > ul#side-menu a").filter(function () {
            var tesurl = $(this).attr("href");
            if(uri_mod !== undefined) {
                return ((tesurl == window.location) || (tesurl == uri_mod)) ?  true : false;
            }else{
                return tesurl == window.location;
            }
        }).closest("li").addClass("menuitem-active").parent().addClass("show").parent().addClass("menuitem-active");

        if($.fn.initial !== undefined) {
            $('.avatar-initial').initial();
        }
    });
})(jQuery);