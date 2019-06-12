<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row">
                <h2>¡Hola!</h2>
                <p><h3>El director de tesis ya ha revisado su proyecto de tesis:</h3></p>
                @if(session('mensaje') == 1)
                <ul>
                    <li>El trabajo fue aceptado. </li> 
                </ul>
                @else
                <ul>
                    <li>El trabajo fue rechazado. </li> 
                </ul>
                @endif
                <p><h3>Con lo que le pedimos entrar al sitio para revisar los comentarios sobres su trabajo.</h3></p> 
            
                <a href="{{ route('login') }}" class="btn btn-info" style="color: #fff; background-color: #1e7e34; border-color: #1c7430; 
                padding: 0.25rem 0.5rem; font-size: 0.875rem; line-height: 1.5; text-decoration: none; border-radius: 0.2rem;">Ir al sitio</a>
        </div>
    </div>
    
    
</body>
</html>
