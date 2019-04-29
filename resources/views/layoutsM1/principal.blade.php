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

    <title>19 Semana de Posgrado</title>
    
    <link rel="stylesheet" href="{{ mix('css/bootstrap.css')}} ">
    <script  src="{{mix('js/app.js')}} "> </script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    
    @yield('links')

</head>

<body>


    
    @yield('menu','')
    @yield('contenido','')
    @yield('footer','')
    @yield('scripts','')
    

</body>

</html>