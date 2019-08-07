<html>

<head>
    <style>
        @page {
            margin: 125px 70px;
        }

        .header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            width: 100%;
            height: 150px
        }

        .footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
        }

        p {
            page-break-after: always
        }

        body {
            font-size: 16px;
        }

        thead tr th {
            background-color: #3f77bc;
            color: #ffff;
        }

        .contenido {
            font-size: 14px !important;
        }

        table {
            padding-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }

        table td,
        table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
        }
    </style>
    <title>Lista de participantes</title>
</head>

<body>
    <header style="position: fixed; top: -60px; left: 0px; right: 0px; width: 100%; height: 150px">
        <div style="width: 100% ; ">
            <div style="width:80%;  float: left; margin: 0">
                Lista de participantes, institución: {{$institucion->nombre}} <br>
                <small>{{$semana->nombre}} del {{$fInicio}} a {{$fFin}} </small>
            </div>
            <div style="width: 20%;  float: left; margin: 0">
                @if(isset($semana->url_logo))
                <img src="{{asset('img/semanaLogo/'.$semana->url_logo)}}"  alt=""  width="95px" height="50px"  style="float: right;">
                @else
                <img src="{{asset('img/semanaLogo/logo_evento.png')}}"  alt=""  width="95px" height="50px"  style="float: right;">
                @endif
            </div>
        </div>
    </header>
    <main>

        @php $x=1; $semestre = ""; $sesion = 0 ; $nivel = "" @endphp
        @foreach($alumnos as $alumno)
        @php
        @endphp
        @if($semestre == "" && $nivel == "" )
        <div>{{$alumno->nivel.' : '. $alumno->semestre}}</div>
        <table style="width: 100%; padding-top: 0px;">
            <thead>
                <tr>
                    <th style="text-align: center; "></th>
                    <th style="text-align: center; ">Número Control</th>
                    <th style="text-align: center; ">Apellido Paterno</th>
                    <th style="text-align: center; ">Apellido Materno </th>
                    <th style="text-align: center; ">Nombre </th>
                </tr>
            </thead>
            <tbody>
                @php $semestre = $alumno->semestre; $nivel = $alumno->nivel @endphp

                @elseif($semestre != $alumno->semestre || $nivel != $alumno->nivel)
                @php $semestre = $alumno->semestre; $nivel = $alumno->nivel @endphp
                @php $x = 1; @endphp
            </tbody>
        </table>
        <div style="margin-top: 25px;" >{{$alumno->nivel.' : '. $alumno->semestre}}</div>
        <table style="width: 100%; margin-top: 0px; padding-top: 0px">
            <thead>
                <tr>
                    <th style="text-align: center; "></th>
                    <th style="text-align: center; ">Numero Control</th>
                    <th style="text-align: center; ">Apellido Paterno</th>
                    <th style="text-align: center; ">Apellido Materno </th>
                    <th style="text-align: center; ">Nombre </th>
                </tr>
            </thead>
            <tbody>
                @endif
                <tr>
                    <th>{{$x}}</th>
                    <td style="text-align: justify !important; width: 25%">{{$alumno->num_control}}</td>
                    <td style="text-align: justify !important; width: 25%">{{$alumno->primer_apellido}}</td>
                    <td style="text-align: justify !important; width: 25%">{{$alumno->segundo_apellido}}</td>
                    <td style="text-align: justify !important; width: 25%">{{$alumno->nombre}}</td>
                </tr>
                @php $x++; @endphp
                @endforeach
            </tbody>
        </table>
    </main>
    <footer class="footer">
        <span class="page-number" style="float: right"></span>
    </footer>
</body>

</html>