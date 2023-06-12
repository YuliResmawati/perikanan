! function(n) {
    "use strict";

    function e() {
        this.$body = n("body")
    }
    e.prototype.init = function() {
        n(".wel-custom-textarea").summernote({
            placeholder: "Tulis Sesuatu...",
            lang: 'id-ID',
            height: 230,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link']]
            ],
            disableResizeEditor: true,
            codeviewFilter: false,
            codeviewIframeFilter: true,
            callbacks: {
                onInit: function(e) {
                    n(e.editor).find(".custom-control-description").addClass("custom-control-label").parent().removeAttr("for");
                    n(e.editor).find(".note-modal").remove();
                    n(e.editor).find(".note-table-popover").remove();
                    n(e.editor).find(".note-image-popover").remove();
                }
            }
        })
    }, n.Summernote = new e, n.Summernote.Constructor = e
}(window.jQuery),
function() {
    "use strict";
    window.jQuery.Summernote.init()
}();