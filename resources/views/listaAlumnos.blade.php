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
            background-color: #c1f6e7
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
                Lista de participantes, institucion: {{$institucion->nombre}} <br>
                <small>{{$semana->nombre}} del {{$fInicio}} a {{$fFin}} </small>
            </div>
            <div style="width: 20%;  float: left; margin: 0">
                <img src="{{asset('img/logo.png')}}" alt="" width="95px" height="50px" style="float: right;">
            </div>
        </div>
    </header>
    <main>

        @php $x=1; $semestre = ""; $sesion = 0 @endphp
        @foreach($alumnos as $alumno)
        @php
        @endphp
        @if($semestre == "")
        <div>{{'Semestre: '. $alumno->semestre}}</div>
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
                @php $semestre = $alumno->semestre; @endphp

                @elseif($semestre != $alumno->semestre)
                @php $semestre = $alumno->semestre @endphp
                @php $x = 1; @endphp
            </tbody>
        </table>
        <div style="margin-top: 25px;" >{{'Semestre: '. $alumno->semestre}}</div>
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