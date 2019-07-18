    $(document).ready(function () {
        $('.custom-file-input').on('change', function () {
            let fileName = $(this).val().split('\\').pop();
            if (!fileName.trim()) {
                $(this).next('.custom-file-label').removeClass("selected").html('Ningún archivo seleccionado');
                readURL(this, 'vistaPrevia1')
            } else {
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            }
        });

        $('.btn-guardar').on('click', function () {
            var datos = new FormData($("#colorForm")[0]);
            console.log(Array.from(datos));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                //url: "{{route('VistaLogin.store')}}",
                url: "/admin/cambiarColores",
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    var unique = $.now();
                    mostrarSnack("Actualización exitosa.");
                    $('#nuevaImagen').addClass('d-none');
                    $('#nuevaImagen2').addClass('d-none');
                    $('#vistaPrevia').prop('src', "");
                    $('.custom-file-label').removeClass("selected").html('Seleccionar archivo');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    mostrarSnackError("Error");
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);

                },


            });
        })
    });
    function readURL(input, idimg, contenedor) {

        if (input.files && input.files[0]) {
            $('#' + contenedor).removeClass('d-none');
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#' + idimg)
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);

        }
        else {
            $('#' + idimg)
                .attr('src', '');
            $('#' + contenedor).addClass('d-none');
        }
    }

    function mostrar(idMostrar) {
        //$('#' + idMostrar).removeClass('d-none');
    }

    $(function () {
        $('.colores').colorpicker({
            format: 'auto'
        });
        $('.colores').colorpicker({
            format: null
        });
    });
