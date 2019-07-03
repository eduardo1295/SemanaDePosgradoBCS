<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gafete participación</title>
    <style>
    .container{ margin: 0 auto;}
    .logos{ text-align: center; width: 100% }
    .qr{ width: 100%; text-align: center; margin-top: 25px }
    .titulo{
        width: 100%;
        text-align: center; 
        font-size: 36px; 
        margin-bottom: 25px;
        background-color: rgb(0, 72, 131);
        color: white;
        padding-bottom: 5px;
        padding-top: 5px;
    }
    .nombre{
        text-align: center;
        font-size: 28px;
        margin-top: 25px;
        font-family: 'YanoneKaffeesatz';
    }
    .institucion{ 
        text-align: center; 
        font-size: 28px; 
        margin-top: 20px;
    }
    .footer{ 
        margin-top: 25px; 
        text-align: center; 
        font-size: 28px;  
        background-color: rgb(0, 72, 131);
        color: white;
        padding-bottom: 5px;
        padding-top: 5px;
    }

    /**{border: 1px solid black}*/
    </style>
</head>
<body>
    <div class="container">
        <div class="titulo">
            {{$semana->nombre}}
        </div>
        <div class="logos">
            {!! $imagenes !!}   
        </div>
        <div class="nombre" style="font-family: 'YanoneKaffeesatz-Regular';">
            {{$alumno->nombre.' '.$alumno->primer_apellido.' '.$alumno->segundo_apellido}}
        </div>
        <div class="institucion">
                {{$alumno->instituciones->nombre}}
        </div>
        <div class="qr">
            @php
            $datos = $alumno->email.','.$alumno->alumnos->num_control.','.$alumno->nombre.' '. utf8_encode($alumno->primer_apellido).' '. utf8_encode($alumno->segundo_apellido).','.$alumno->instituciones->siglas;
            @endphp
            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(250)->generate($datos)) !!}" >
        </div>
        <div class="footer">
            Participante
        </div>
        
        
    </div>
    
</body>
</html>