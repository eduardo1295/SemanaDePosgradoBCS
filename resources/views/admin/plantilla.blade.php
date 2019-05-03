<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
  <link rel="stylesheet" href="{{ mix('css/Maqueta2.css')}} ">

  <link rel="stylesheet" href="/css/admin/jquery.mCustomScrollbar.min.css">
  <!--
  <link rel="stylesheet" href="../css/admin/main.css">
  -->
  <link rel="stylesheet" href="/css/admin/menu2.css">
  <link rel="stylesheet" href="/css/admin/sidebar-themes.css">
  <link rel="stylesheet" href="/css/admin/jquery.mCustomScrollbar.css" />
  
  @yield('estilos')
</head>

<body>

  <div class="page-wrapper light-theme toggled" id="menuAd">

    @include('admin.menu')
    {{-- comment 
    
    <div class="nav-header container-fluid" style="">
        <div class="nav-contenido">
            
        </div>
    
    </div>
    --}}
    

    <main class="page-content">
        <div id="overlay" class="overlay"></div>
        @include('admin.navbar')
    @yield('contenido')
    </main>
    
    @yield('extra')

  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="/js/admin/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="/js/admin/main.js"></script>
  <script src="/js/menumaker.js"></script>
  @yield('scripts')
</body>

</html>