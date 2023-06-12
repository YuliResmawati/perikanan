/* Select2 Init*/
function init_dropify() {
    "use strict";
    if($.fn.dropify !== undefined){
        if($('[data-plugins="dropify"]').length > 0){
            $('[data-plugins="dropify"]').dropify({
                messages:{default:"Drag and drop file atau klik disini",
                replace:"Drag and drop atau klik untuk mengganti file",
                remove:"Remove",error:"Maaf, sepertinya ada masalah."},
                error:{fileSize:"Ukuran file terlalu besar."}
            });
        }
    }else{
        console.error('Dropify library not loaded');
    }
}

function reinit_dropify(element) {
    "use strict";
    if($.fn.dropify !== undefined){
        if(element.length > 0){
            var imagenUrl = element.attr('data-default-file');
            var drEvent = element.data('dropify');
            drEvent.resetPreview();
            drEvent.clearElement();
            drEvent.settings.defaultFile = imagenUrl;
            drEvent.destroy();
            drEvent.init();
        }else{
            console.error('Element not valid');
        }
    }else{
        console.error('Dropify library not loaded');
    }
}

init_dropify();