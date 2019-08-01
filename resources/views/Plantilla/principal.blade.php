<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Expires" content="-1" >
    <meta http-equiv="Pragma" content="no-cache">

    <title>Semana de Posgrado BCS</title>
    
    {{-- <link rel="stylesheet" href="{{ env('APP_URL').mix('css/bootstrap.css')}} ">
    <script  src="{{ env('APP_URL').mix('js/app.js')}} "> </script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
  
    <link rel="stylesheet" href="{{ asset('fonts/fontawesomeweb/css/all.css')}}">
    <script>
     window.onscroll = function() {scrollFunction()};
    /*Se usa para el desplazamiento de la barra*/
    function scrollFunction() {
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
      } else {
        document.getElementById("myBtn").style.display = "none";
      }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        var body = $("html, body");
            body.stop().animate({scrollTop:0}, 500, 'swing', function() { 
            
        });
    }
    /*Aqui termina desplazamiento de la barra*/
    var turaIdioma = "{{ asset('/js/datatableJS/es.json') }}";
    </script>
    @yield('links')
</head>

<body>
    <!--Boton que se usa para el desplazamiento-->
    <button onclick="topFunction()" id="myBtn"><i  id="flecha" class="fas fa-arrow-up"></i></button>
    @include('layoutsM2.navbar')
    <div style="min-height:100vh">
    @yield('contenido','')   
</div>
    @yield('extra')
    
    @include('layoutsM2.footer')
    @yield('scripts','')
    <script src="{{ asset('js/menumaker.js') }}"></script>
</body>
</html>