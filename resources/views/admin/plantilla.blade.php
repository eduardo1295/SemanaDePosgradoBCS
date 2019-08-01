<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Semana de Posgrado BCS</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="Cache-control" content="no-cache">
  <meta http-equiv="Expires" content="-1" >
  <meta http-equiv="Pragma" content="no-cache">

  <link rel="stylesheet" href="{{ env('APP_URL').mix('css/bootstrap.css')}} ">
  <link rel="stylesheet" href="{{ asset('/fonts/fontawesomeweb/css/all.css')}} ">
  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"> --}}

  <link rel="stylesheet" href="{{ asset('/css/admin/jquery.mCustomScrollbar.min.css')}} ">

  <link rel="stylesheet" href="{{ asset('/css/admin/menu2.css')}} ">
  <link rel="stylesheet" href="{{ asset('/css/admin/sidebar-themes.css')}} ">
  <link rel="stylesheet" href="{{ asset('/css/admin/jquery.mCustomScrollbar.css')}} ">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css">
  
  
  <link rel="stylesheet" href="{{ asset('/css/Maqueta2.css')}} ">
  <link rel="stylesheet" href="{{ asset('/css/imagenes/imagenes.css')}} ">
  <link rel="stylesheet" href="{{ asset('/css/imagenes/cargando.css')}} ">
  
    <link rel="stylesheet" href="{{ asset('/plugins/datatables/DataTables-1.10.18/css/jquery.dataTables.min.css')}} ">
    <link rel="stylesheet" href="{{ asset('/plugins/datatables/Responsive-2.2.2/css/responsive.dataTables.min.css')}} ">
    <link rel="stylesheet" href="{{ asset('/css/modales/snackbar.css')}} ">
    <link rel="stylesheet" href="{{ asset('/css/datatable/colores.css')}} ">
    <link rel="stylesheet" href="{{ asset('/css/imagenes/imagenes.css')}} ">
    <link rel="stylesheet" href="{{ asset('/css/modales/modalresponsivo.css')}} ">
    <link rel="stylesheet" href="{{ asset('/plugins/jqueryconfirm/jquery-confirm.css')}} ">
    
    <style>
      .custom-file-input~.custom-file-label::after {
          content: "Elegir";
      }
      .tooltip{
            pointer-events: none;
        }
  </style>
  @yield('estilos')
</head>

<body>

  <div class="page-wrapper light-theme toggled" id="menuAd">

    <div class="container-fluid" style="">
        <div class="nav-contenido">
        @include('admin.menu')        
        </div>
    
    </div>

    <main class="page-content">
        @include('admin.navbar')
        <div id="overlay" class="overlay"></div>
    
      @yield('contenido')
    </main>
    
    @yield('extra')

    <div id="snackbar"></div>
    <div id="snackbarError" style="z-index:1051;"></div>
    <div id="loader" class="loader"></div>
  </div>

 
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
   --}}
  <script  src="{{ env('APP_URL').mix('js/app.js')}} "> </script>
  <script src="{{ asset('js/admin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
  <script src="{{ asset('js/admin/main.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
  <script src="{{ asset('js/snack/snack.js') }}"></script>
  <script src="{{ asset('plugins/datatables/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/Responsive-2.2.2/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('plugins/jqueryconfirm/jquery-confirm.js') }}"></script>
  <script>
      $(document).ready(function () {
 $("body").tooltip({
           selector: '[data-toggle="tooltip"]',
           container: 'body',
           trigger : 'hover'
       });
     });

     var turaIdioma = "{{ asset('/js/datatableJS/es.json') }}";
 </script>
  @yield('scripts')
</body>

</html>