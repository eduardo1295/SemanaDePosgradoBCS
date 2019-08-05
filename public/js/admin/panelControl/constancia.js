var id;
$(window).resize(function() {
    clearTimeout(id);
        id = setTimeout(doneResizing, 500);
});

function doneResizing(){
    if(screen.width === window.innerWidth){
            var resPantalla = document.body.scrollWidth-$(window).width()-260*2-40;
            const element = document.querySelector("#menuAd");

            document.getElementById('contenedor').setAttribute("style","width: calc(100% + "+resPantalla+"px);z-index:0;background:#ececec;");
    }else{
    var tPantalla = $(window).width();
            var x = document.body.scrollWidth-tPantalla;
            document.getElementById('contenedor').setAttribute("style","width: calc(100% + "+x+"px);z-index:0;background:#ececec;");
    }
}

        
        var componenetes = "";
        $(document).ready(function () {
            var tPantalla = $(window).width();
            var x = document.body.scrollWidth-tPantalla;
            document.getElementById('contenedor').setAttribute("style","width: calc(100% + "+x+"px);z-index:0;background:#ececec;");
            if (constancia[0].url_imagen_fondo != "") {
                var unique = $.now();
                $(".gjs-frame").contents().find("#wrapper").css('background-image', 'url("' + constancia[0]
                    .url_imagen_fondo + '/?' + unique + '")');
                $(".gjs-frame").contents().find("#wrapper").css('background-size', '100% 100%');
                $(".gjs-frame").contents().find("#wrapper").css('background-repeat', 'no-repeat');
            }
        });

        $('.btnprueba').click(function () {
            const domComponents = JSON.stringify(editor.getComponents());
            var sinquotes = JSON.stringify(domComponents);
            var HtmlE = editor.getHtml();
            var CssE = editor.getCss();
            var componente = editor.getComponents('gjs-components');
            const head = editor.Canvas.getDocument().body;
            const all = getAllComponents(editor.DomComponents.getWrapper());
            const x = JSON.stringify(componente);
            var imagen = $(".gjs-frame").contents().find("#wrapper").css('background-image');
            imagen = imagen.replace('url(', '').replace(')', '').replace(/\"/gi, "");
            
        })

$('.btnGuardarDiseno').click(function () {
    $('.mensajeError').text("");
    $(".btnGuardarDiseno").prop("disabled", true);
    $("#btn-close").prop("disabled", true);
    var actionType = $('#btn-save').val();
    $('.btnGuardarDiseno').html('Guardando...');
    var datos = new FormData($("#constanciaForm")[0]);
    const domComponents = JSON.stringify(editor.getComponents());
    var HtmlE = editor.getHtml();
    var CssE = editor.getCss();
    datos.append('cComponentes', domComponents);
    datos.append('cHTML', HtmlE);
    datos.append('cCSS', CssE);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ruta,
        type: "POST",
        data: datos,
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            var unique = $.now();
            $(".gjs-frame").contents().find("#wrapper").css('background-image', 'url("' +
                data.url_imagen_fondo + '/?' + unique + '")');
            $(".gjs-frame").contents().find("#wrapper").css('background-size', '100% 100%');
            $(".gjs-frame").contents().find("#wrapper").css('background-repeat',
                'no-repeat');
            $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
            mostrarSnack("Cambios guardados exitosamente");
        },
        error: function (data) {
            if (data.status == 422) {
                var errores = data.responseJSON['errors'];
                $.each(errores, function (key, value) {
                    $('#' + key + "_error").text(value);
                });
            }
            mostrarSnackError("Error al guardar los cambios");
        },
        complete: function (data) {
            $(".btnGuardarDiseno").prop("disabled", false);
            $(".btnGuardarDiseno").prop("disabled", false);
            $('.btnGuardarDiseno').html('Guardar');
            $(".loader").hide();
        }
    });
})


$('.custom-file-input').on('change', function () {
    let fileName = $(this).val().split('\\').pop();
    if (!fileName.trim()) {
        $(this).next('.custom-file-label').removeClass("selected").html('Ningún archivo seleccionado');
    } else {
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    }
});
