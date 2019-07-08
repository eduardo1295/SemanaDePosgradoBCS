function readURL(input,idimg) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            
            $(".gjs-frame").contents().find("#wrapper").css('background-image', 'url("'+e.target.result+'")');
            $(".gjs-frame").contents().find("#wrapper").css('background-size', '100% 100%');
            $(".gjs-frame").contents().find("#wrapper").css('background-repeat', 'no-repeat');
            
            //$('.gjs-dashed')
            //.css('background-image', 'url(https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png)');
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function mostrar(idMostrar) {
        $('#' + idMostrar).removeClass('d-none');
    }