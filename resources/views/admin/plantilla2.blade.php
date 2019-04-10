<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">


  <!-- Bootstrap CSS CDN -->
  
<!-- Our Custom CSS -->
<link rel="stylesheet" href="../css/admin/menu.css">
<!-- Scrollbar Custom CSS -->
<link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

  <!--
  <link rel="stylesheet" href="../css/admin/jquery.mCustomScrollbar.min.css">
  <link rel="stylesheet" href="../css/admin/main.css">
  <link rel="stylesheet" href="../css/admin/sidebar-themes.css">
  <link rel="stylesheet" href="../css/admin/jquery.mCustomScrollbar.css" />
  <link rel="stylesheet" href="../css/contenido.css">
  -->
  @yield('estilos')
</head>

<body>

  <div class="wrapper" id="menuAd">

    @include('admin.menu0')
    @yield('contenido')

  </div>
<!-- jQuery CDN - Slim version (=without AJAX) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
  
  
<!-- jQuery Custom Scroller CDN -->
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function () {
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar, #content').toggleClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
</script>
  <!--
  <script src="../js/admin/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="../js/admin/main.js"></script>
  -->
  @yield('scripts')
</body>

</html>