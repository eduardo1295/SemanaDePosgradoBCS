function registerSummernote(element, placeholder, max, callbackMax) {
    $(element).summernote({
        callbacks: {
            onInit: function () {
                $(".note-editor").on('click', '.btn-fullscreen', function (e) {
                    $(".modal-dialog").toggleClass('modal100');
                });
            },
            onImageUpload: function (files) {
                if (!files.length) return;
                var file = files[0];
                // create FileReader
                var reader = new FileReader();
                reader.onloadend = function () {
                    // when loaded file, img's src set datauri

                    var img = $("<img>").attr({ src: reader.result, width: "50%", style: "margin:1px;float: left;", class: "img-responsive note-float-left" }); // << Add here img attributes !

                    $("#contenido").summernote("insertNode", img[0]);
                }

                if (file) {
                    // convert fileObject to datauri
                    reader.readAsDataURL(file);
                }
            }

        },
        //toolbarContainer: '.my-toolbar',

        placeholder,
        lang: 'es-ES', // Change to your chosen language
        disableResizeEditor: true,
        dialogsInBody: true,
        dialogsFade: false,
        shortcuts: false,
        disableDragAndDrop: true,
        height: 200,                 // set editor height
        minHeight: 200,             // set minimum height of editor
        maxHeight: 200,
        toolbar: [

            ['color', ['color']],
            ['style', ['style']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['picture'],

            ['para', ['ul', 'ol', 'listStyles', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'hr']],
            ['view', ['fullscreen']], //, 'codeview'
        ],
        popover: {
            image: [
                ['custom', ['imageTitle']],
                ['imagesize', ['imageSize100', 'imageSize50']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']]
            ],
        },
        cleaner: {
            action: 'both', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
            newline: '<br>', // Summernote's default is to use '<p><br></p>'
            notStyle: 'position:relative;top:0;left:0;right:0', // Position of Notification
            icon: '<i class="note-icon">[Your Button]</i>',
            keepHtml: false, // Remove all Html formats
            keepOnlyTags: ['<p>', '<br>', '<ul>', '<li>', '<b>', '<strong>', '<i>', '<a>'], // If keepHtml is true, remove all tags except these
            keepClasses: false, // Remove Classes
            badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
            badAttributes: ['style', 'start'], // Remove attributes from remaining tags
            limitChars: max, // 0/false|# 0/false disables option
            limitDisplay: 'text', // text|html|both
            limitStop: true // true/false
        },
        styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
    });

}