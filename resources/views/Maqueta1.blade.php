{{-- SECCION BLADE--}}

@extends('Plantilla.principal')
@section('contenido')
@include('Plantilla.carrusel')
@include('Plantilla.noticias')
@include('Plantilla.comite')

@section('links')
    <link rel="stylesheet" href="{{ mix('css/Maqueta1.css')}} "> 
    <script  src="/js/owl.carousel.min.js"> </script> 
@endsection



{{-- END SECCION BLADE--}}
<div class="space-small bg-default">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="well-block">
                    <div class="product-desc-side">
                        <h3>Información </h3>
                        <h4>Semana de posgrado en Baja California Sur</h4>
                        <p class="text-justify">Las instituciones de nivel superior del estado de Baja California Sur
                            convocan a alumnos y profesores de nivel
                            maestría y doctorado a la 18 semana de posgrado en Baja California Sur del 21 al 25 de mayo
                            del 2018.</p>
                        <ul>
                            <li class="mb-1">La Universidad Autónoma de Baja California Sur (UABCS) </li>
                            <li class="mb-1">El Centro de Investigaciones Biológicas del Noroeste, S.C. (CIBNOR)</li>
                            <li class="mb-1">El Centro Interdisciplinario de Ciencias Marinas (CICIMAR-IPN) </li>
                            <li class="mb-1">El Instituto Tecnológico de La Paz (ITLP) </li>
                        </ul>
                        <p class="text-justify">Con el propósito de promover un espacio académico que permita la
                            interacción entre los estudiantes de los
                            Programas
                            de Posgrado del estado de Baja California Sur, reconocidos en el PNPC.</p>
                        <p class="text-justify">Se convocan a sus estudiantes a compartir sus proyectos y/o avances de
                            tesis, conforme al periodo escolar que
                            cursan y de acuerdo a las siguientes.</p>
                        <p>
                            Modalidades de presentación
                            <strong>
                                <a href="modalidades.php">Más información</a>
                            </strong>
                        </p>
                        <ul>
                            <li>Cartel</li>
                            <li>Entrevista</li>
                            <li>Video</li>
                            <li>Ponencia oral</li>
                        </ul>
                        <p>
                            Periodo de registro en línea
                            <strong>
                                <a href="login.php">Registro</a>
                            </strong>
                        </p>
                        <p>Del 16 al 30 de abril de 2018</p>


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!--
<div class="container">
        <div id="map">
                
                 How to change your own map point
                       1. Go to Google Maps
                       2. Click on your location point
                       3. Click "Share" and choose "Embed map" tab
                       4. Copy only URL and paste it within the src="" field below
                
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1197183.8373802372!2d-1.9415093691103689!3d6.781986417238027!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xfdb96f349e85efd%3A0xb8d1e0b88af1f0f5!2sKumasi+Central+Market!5e0!3m2!1sen!2sth!4v1532967884907" width="100%" height="400px" frameborder="0" style="border:0" allowfullscreen=""></iframe>
            </div>
    </div>
-->


@endsection