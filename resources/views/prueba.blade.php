<html>
<head>
  <style>
    @page { margin: 125px 70px; }
    .header { position: fixed; top: -60px; left: 0px; right: 0px; width: 100%; height: 150px}
    .footer { position: fixed; bottom: -60px; left: 0px; right: 0px;}
    p { page-break-after:always }
    body{ font-size: 16px;}
    thead tr th{ background-color: #c1f6e7 }
    .contenido{ font-size: 14px !important; }
    table{ padding-top: 20px; border-collapse: collapse; width: 100%; }
    table td, table th { border: 1px solid #ddd; padding: 8px;}
    table tr:nth-child(even){background-color: #f2f2f2;}
    table th { padding-top: 12px; padding-bottom: 12px; text-align: left;  }
  </style>
  <title>{{$modalidad->nombre}}</title>
</head>
<body>
  <header style="position: fixed; top: -60px; left: 0px; right: 0px; width: 100%; height: 150px">
    <div style="width: 100% ; ">
      <div style="width:80%;  float: left; margin: 0">
           Programación: Sesión de {{$modalidad->nombre}} <br>
           <small>{{$semana->nombre}};  {{$fInicio}}  a {{$fFin}} </small>
      </div>
      <div style="width: 20%;  float: left; margin: 0">
          <img src="{{asset('img/logo.png')}}"  alt=""  width="95px" height="50px"  style="float: right;">
      </div>
    </div>
  </header>
  <main>
      <div style="text-align: justify">
      {!!$modalidad->descripcion!!}
      </div>
        <p>
              @php $x=1; $dia = ""; $sesion = 0 @endphp 
              @foreach($trabajo as $trab)
                @php
                $fecha = new Date($trab->dia);
                $fecha = $fecha->format('l d').' de '.$fecha->format('F');
                $horaInicio = new Date($trab->hora_inicio);
                $horaInicio = $horaInicio->format('H:i');
                $horaFin = new Date($trab->hora_fin);
                $horaFin = $horaFin->format('H:i');
                @endphp
                @if($dia == "")
                <div>{{$fecha.', Hora:('.$horaInicio .' - '.$horaFin.')'.'  Lugar: '.$trab->lugar}}</div>
                <table  style="width: 100%; padding-top: 0px;">
                    <thead>
                      <tr>
                        <th style="text-align: center; "></th>
                      <th style="text-align: center; ">Apellido Paterno</th>
                      <th style="text-align: center; ">Apellido Materno </th>
                      <th style="text-align: center; ">Nombre           </th>
                      <th style="text-align: center; ">Institución      </th>
                      <th style="text-align: center; ">Área      </th>
                      <th style="text-align: center; ">Titulo           </th>
                      </tr>
                </thead>
                <tbody>
                @php $dia = $trab->dia; @endphp

                @elseif(($dia != $trab->dia) || ($sesion != 0 && $sesion != $trab->id_sesion))
                @php $dia = $trab->dia; @endphp
                @php $x = 1; @endphp
                </tbody>
                </table>
                <div style="margin-top: 25px;">{{$fecha.' ('.$horaInicio .' - '.$horaFin.') '.'  Lugar: '.$trab->lugar}}</div>
                <table  style="width: 100%; margin-top: 0px; padding-top: 0px" >
                  <thead>
                    <tr>
                      <th style="text-align: center; "></th>
                      <th style="text-align: center; ">Apellido Paterno</th>
                      <th style="text-align: center; ">Apellido Materno </th>
                      <th style="text-align: center; ">Nombre           </th>
                      <th style="text-align: center; ">Institución      </th>
                      <th style="text-align: center; ">Área      </th>
                      <th style="text-align: center; ">Titulo           </th>
                    </tr>
                  </thead>
                  <tbody>
                @endif
                <tr>
                    <th>{{$x}}</th>
                    <td style="text-align: justify !important; width: 12.5%">{{$trab->primer_apellido}}</td>
                    <td style="text-align: justify !important; width: 12.5%">{{$trab->segundo_apellido}}</td>
                    <td style="text-align: justify !important; width: 12.5%">{{$trab->nombre}}</td>
                    <td style="text-align: justify !important; width: 12.5%">{{$trab->siglas}}</td>  
                    <td style="text-align: justify !important; width: 22.5%">{{$trab->area}}</td>  
                    <td style="text-align: justify !important; width: 22.5%">{{$trab->titulo}}</td>  
                </tr>
                @php $x++; @endphp    
                @php $sesion = $trab->id_sesion @endphp
              @endforeach
              </tbody>      
            </table>
            </p>
    </main>
  <footer class="footer">
      <span class="page-number" style="float: right"></span>
  </footer>
</body>
</html>