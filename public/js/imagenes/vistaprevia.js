function readURL(input,idimg) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#'+idimg)
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }else{
        $('#'+idimg)
        .attr('src', '');
    }
}

function mostrar(idMostrar) {
        $('#' + idMostrar).removeClass('d-none');
    }