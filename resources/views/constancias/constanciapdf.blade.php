<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ $titulo }}</title>
    
    <style>
        @media print {
            html, body {
                width: 100%;
                background-color: red;
                
                page-break-inside: avoid;

            }
        }
        @page{
            margin: 0in;   
        }
        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            /*margin: 20px;*/
            margin-bottom:0 !important;
            border: none;
            /*font-family: Impact, Haettenschweiler, "Franklin Gothic Bold", Charcoal, "Helvetica Inserat", "Bitstream Vera Sans Bold", "Arial Black", "sans serif";*/
            padding-bottom: 0;
        }

        @font-face {
            font-family: 'Arial';
            src: url({{ storage_path('fonts\Arial.ttf') }}) format("truetype");
        }

        @font-face {
            font-family: 'Impact';
            src: url({{ storage_path('fonts\Impact.ttf') }}) format("truetype");
        }

        
        /*
        .gjs-cell {
            
            display: inline-block;
            
            vertical-align: top;
        }

        .gjs-row {
            padding: 10px;
            width: 100%; 
            background: cyan;
        }

        .c0 {
            width: 100%;
            
        }

        .c1 {
            width: 33%;
        }

        .c2 {
            width: 49%;
        }

        .c525 {
            vertical-align: top;
            width: 130px;
            height: 100px;
        }

        .c532 {
            vertical-align: top;
            width: 130px;
            height: 100px;
        }

        .c539 {
            vertical-align: top;
            width: 130px;
            height: 100px;
        }

        .c546 {
            vertical-align: top;
            width: 130px;
            height: 100px;
        }

        .c516 {
            width: 100%;
        }

        .c508 {
            border: 1px solid black;
            width: 100%;
        }
        */
       /* * { box-sizing: border-box; } body {margin: 0;}body{width:100%;border:none;}.c525{vertical-align:top;width:130px;height:100px;}.c532{vertical-align:top;width:130px;height:100px;}.c539{vertical-align:top;width:130px;height:100px;}.c546{vertical-align:top;width:130px;height:100px;}.c516{vertical-align:top;width:100%;}.c508{width:100%;}.gjs-row{width:100%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;}.gjs-cell{display:inline-block;min-height:25px;}.c723{width:49%;vertical-align:top;}.c732{width:49%;vertical-align:top;}.c876{width:33%;vertical-align:top;}.c885{width:33%;vertical-align:top;}.c894{width:33%;vertical-align:top;}.c1001{vertical-align:top;width:130px;height:100px;}.c1008{vertical-align:top;width:130px;height:100px;}.c1015{vertical-align:top;width:130px;height:100px;}.c1022{vertical-align:top;width:130px;height:100px;}.c993{vertical-align:top;width:100%;}.c985{width:100%;text-align:center;}@media (max-width: 768px){.gjs-cell{width:100%;display:block;}}*/
         /*{ box-sizing: border-box; } body {margin: 0;}body{width:100%;border:none;}.c632{vertical-align:top;width:318.6000061035156px;height:245px;}.c696{vertical-align:top;width:130px;height:100px;}.c734{vertical-align:top;width:130px;height:100px;}.c772{vertical-align:top;width:130px;height:100px;}.c810{vertical-align:top;width:130px;height:100px;}.c848{vertical-align:top;width:130px;height:100px;}.gjs-row{width:100%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;}.gjs-cell{display:inline-block;min-height:25px;}.c945{width:38.1%;vertical-align:top;}.c954{width:61.9%;vertical-align:top;}@media (max-width: 768px){.gjs-cell{width:100%;display:block;}}*/
        /** { box-sizing: border-box; } body {margin: 0;}body{width:100%;border:none;padding:20px;}.c599{vertical-align:top;width:130px;height:100px;}.c671{vertical-align:top;width:130px;height:100px;}.c709{vertical-align:top;width:130px;height:100px;}.c747{vertical-align:top;width:130px;height:100px;}.c785{vertical-align:top;width:130px;height:100px;}.c823{vertical-align:top;width:130px;height:100px;}.c860{vertical-align:top;width:130px;height:100px;}.c898{vertical-align:top;width:105.60000610351562px;height:100px;}*/
        

       /* * { box-sizing: border-box; } body {margin: 0;}body{width:100%;border:none;padding:20px;}.gjs-row{width:100%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;}.gjs-cell{display:inline-block;min-height:25px;vertical-align:top;}.c574{width:49%;vertical-align:top;}.c583{width:49%;vertical-align:top;}.c643{padding:10px;}.c703{vertical-align:top;width:130px;height:100px;}@media (max-width: 768px){.gjs-cell{display:inline-block;min-height:25px;vertical-align:top;}}*/
       /** { box-sizing: border-box; } body {margin: 0;}body{width:100%;border:none;padding:20px;background-color:rgba(204,23,23,0.17);}#i1nf{text-align:center;padding:10px 10px 0 10px;}#idwv{text-align:center;padding:0 10px 10px 10px;}#i0qm{padding:0 10px 0 10px;text-align:center;}#i4z19{padding:0 10px 0 10px;}.gjs-row{width:100%;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;}.gjs-cell{display:inline-block;min-height:25px;vertical-align:top;}.c678{width:33%;vertical-align:top;}.c687{width:33%;vertical-align:top;}.c696{width:33%;vertical-align:top;}.c774{width:33%;vertical-align:top;}.c783{width:33%;vertical-align:top;}.c792{width:33%;vertical-align:top;}.c870{width:33%;vertical-align:top;}.c879{width:33%;vertical-align:top;}.c888{width:33%;vertical-align:top;}.c966{width:33%;vertical-align:top;}.c975{width:33%;vertical-align:top;}.c984{width:33%;vertical-align:top;}.c1050{vertical-align:top;width:130px;height:100px;}.c1087{vertical-align:top;width:130px;height:100px;}.c1124{vertical-align:top;width:130px;height:100px;}.c1161{vertical-align:top;width:130px;height:100px;}.c1202{padding:10px;text-align:center;}.c1273{padding:10px;}.c1344{padding:10px;}.c1415{padding:10px;text-align:center;}.c1595{width:67.5%;vertical-align:top;background-color:#bc3333;border-radius:0 30px 30px 0;}.c1716{vertical-align:top;width:130px;height:100px;}.c1753{vertical-align:top;width:130px;height:100px;}.c1790{vertical-align:top;width:130px;height:100px;}.c1827{vertical-align:top;width:130px;height:100px;}.c1864{vertical-align:top;width:130px;height:100px;}.c2009{width:100%;vertical-align:top;text-align:center;}.c2075{padding:10px 10px 10px 10px;text-align:center;font-size:25px;width:500px;margin:0 0 0 250px;color:#eb4242;}.c2157{padding:10px;text-align:center;font-size:22px;font-family:Arial, Helvetica, sans-serif;}.participante{font-family:Arial, Helvetica, sans-serif;font-size:30px;text-align:center;}.c2338{padding:10px;text-align:center;font-size:20px;font-family:Arial, Helvetica, sans-serif;}.trabajo{text-align:center;font-size:20px;font-family:Arial, Helvetica, sans-serif;}@media (max-width: 768px){.gjs-cell{display:inline-block;min-height:25px;vertical-align:top;}}*/
       
       
       * { box-sizing: border-box; } body {margin: 0;}body{width:100%;padding:20px;}
         body{
            
            padding-bottom: 0 !important;
            
        }
        {{ $constancia[0]->cCSS }}
        
        
        #watermark {
                position: fixed;

                /** 
                    Set a position in the page for your image
                    This should center it vertically
                **/
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                /** Change image dimensions**/
                width: 100%;
                /**height: 822px;**/
                
                
                /** Your watermark should be behind every content**/
                z-index:  -1000;
            }

            #watermark img{
                width:100%;
                
                position:absolute;
                z-index:1;
            }
    </style>
</head>

<body >
    <div id="watermark">
        @if ($constancia[0]->url_imagen_fondo!="")
            {!! '<img src="'.$constancia[0]->url_imagen_fondo.'" height="100%" width="100%" />' !!}    
        @endif
    </div>

    <!-- sirve
        <div data-highlightable="1" class="gjs-row c508">
                <div data-highlightable="1" class="gjs-cell c516">
                    <img 
                        src="http://prueba.test/img/logo/logo_4_2019.png" class="c525">
                    <img
                        src="http://prueba.test/img/logo/logo_3_2019.png" class="c532">
                    <img
                        src="http://prueba.test/img/logo/logo_2_2019.png" class="c539">
                    <img
                        src="http://prueba.test/img/logo/logo_1_2019.png" class="c546">
                    </div>
            </div>

    <div class="gjs-row">
        <div class="gjs-cell c1">
            <div data-highlightable="1" class="evento">Aquí se muestra el nombre del evento</div>
        </div>
        <div class="gjs-cell c1">
            <div data-highlightable="1" class="participante">Aquí se muestra el nombre del participante</div>
        </div>
        <div class="gjs-cell c1">
            <div data-highlightable="1" class="trabajo">Aquí se muestra el nombre del trabajo</div>
        </div>
    </div>
    <div class="gjs-row ">
        <div class="gjs-cell c0">
            <img 
                src="http://prueba.test/img/logo/logo_4_2019.png" class="c525">
        </div>
    </div>
     <div  class="gjs-row c508">
        <div class="gjs-cell c516">
            <img 
                src="http://prueba.test/img/logo/logo_4_2019.png" class="c525">
            <img
                src="http://prueba.test/img/logo/logo_3_2019.png" class="c532">
            <img
                src="http://prueba.test/img/logo/logo_2_2019.png" class="c539">
            <img
                src="http://prueba.test/img/logo/logo_1_2019.png" class="c546">
            </div>
    </div>
    <div class="gjs-row">
        <div class="gjs-cell c2 " style="text-align: left;">
                <div>Inserta tu texto aquí asd sasad </div>
                <img 
                src="http://prueba.test/img/logo/logo_4_2019.png" class="c525">
            
        </div>
        <div class="gjs-cell c2">
            <img 
                src="http://prueba.test/img/logo/logo_4_2019.png" class="c525">
        </div>
    </div>

     <div  class="gjs-row c508">
        <div class="gjs-cell c516">
            <img 
                src="http://prueba.test/img/logo/logo_4_2019.png" class="c525">
            <img
                src="http://prueba.test/img/logo/logo_3_2019.png" class="c532">
            <img
                src="http://prueba.test/img/logo/logo_2_2019.png" class="c539">
            <img
                src="http://prueba.test/img/logo/logo_1_2019.png" class="c546">
            </div>
    </div>
    

sirve-->

<!--
<div data-highlightable="1" class="gjs-row c508"><div data-highlightable="1" class="gjs-cell c516"><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c525"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c532"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c539"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c546"/></div></div><div data-highlightable="1" class="participante">Aquí se muestra el nombre del participante</div><div class="gjs-row"><div class="gjs-cell c723"><div data-highlightable="1" class="trabajo">Aquí se muestra el nombre del trabajo</div></div><div class="gjs-cell c732"><div data-highlightable="1" class="participante">Aquí se muestra el nombre del participante</div></div></div><div class="gjs-row"><div class="gjs-cell c876"></div><div class="gjs-cell c885"></div><div class="gjs-cell c894"></div></div><div data-highlightable="1" class="gjs-row c985"><div data-highlightable="1" class="gjs-cell c993"><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c1001"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c1008"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c1015"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c1022"/></div></div>  
<div data-highlightable="1" class="gjs-row c508"><div data-highlightable="1" class="gjs-cell c516"><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c525"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c532"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c539"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c546"/></div></div><div data-highlightable="1" class="participante">Aquí se muestra el nombre del participante</div><div class="gjs-row"><div class="gjs-cell c723"><div data-highlightable="1" class="trabajo">Aquí se muestra el nombre del trabajo</div></div><div class="gjs-cell c732"><div data-highlightable="1" class="participante">Aquí se muestra el nombre del participante</div></div></div><div class="gjs-row"><div class="gjs-cell c876"></div><div class="gjs-cell c885"></div><div class="gjs-cell c894"></div></div><div data-highlightable="1" class="gjs-row c985"><div data-highlightable="1" class="gjs-cell c993"><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c1001"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c1008"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c1015"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c1022"/></div></div>  
<div data-highlightable="1" class="participante">Aquí se muestra el nombre del participante</div><div data-highlightable="1" class="participante">Aquí se muestra el nombre del participante</div>
<p>putos todos menos yo</p>
<p>putos todos menos yo</p>
<p>putos todos menos yo</p>
<p>putos todos menos yo</p>

<div data-highlightable="1" class="participante">Aquí se muestra el nombre del participante</div><div class="gjs-row"><div class="gjs-cell c626"></div><div class="gjs-cell c635"></div><div class="gjs-cell c644"></div></div><div class="gjs-row"><div class="gjs-cell c945"><img src="http://prueba.test/img/semanaLogo/logo_2019.png" class="c632"/></div><div class="gjs-cell c954"><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c696"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c734"/><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c772"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c848"/><img src="http://prueba.test/img/semanaLogo/logo_2019.png" class="c810"/></div></div>
-->
<!--
<div class="gjs-row"><div class="gjs-cell c626"></div><div class="gjs-cell c635"></div><div class="gjs-cell c644"></div></div><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c599"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c671"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c709"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c747"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c785"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c823"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c860"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c898"/>
<div class="gjs-row"><div class="gjs-cell c626"></div><div class="gjs-cell c635"></div><div class="gjs-cell c644"></div></div><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c599"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c671"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c709"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c747"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c785"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c823"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c860"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c898"/>
<div class="gjs-row"><div class="gjs-cell c626"></div><div class="gjs-cell c635"></div><div class="gjs-cell c644"></div></div><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c599"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c671"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c709"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c747"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c785"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c823"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c860"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c898"/>
<div class="gjs-row"><div class="gjs-cell c626"></div><div class="gjs-cell c635"></div><div class="gjs-cell c644"></div></div><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c599"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c671"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c709"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c747"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c785"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c823"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c860"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c898"/>
<div class="gjs-row"><div class="gjs-cell c626"></div><div class="gjs-cell c635"></div><div class="gjs-cell c644"></div></div><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c599"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c671"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c709"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c747"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c785"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c823"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c860"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c898"/>
<div class="gjs-row"><div class="gjs-cell c626"></div><div class="gjs-cell c635"></div><div class="gjs-cell c644"></div></div><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c599"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c671"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c709"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c747"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c785"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c823"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c860"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c898"/>
<div class="gjs-row"><div class="gjs-cell c626"></div><div class="gjs-cell c635"></div><div class="gjs-cell c644"></div></div><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c599"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c671"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c709"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c747"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c785"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c823"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c860"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c898"/>
<div class="gjs-row"><div class="gjs-cell c626"></div><div class="gjs-cell c635"></div><div class="gjs-cell c644"></div></div><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c599"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c671"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c709"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c747"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c785"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c823"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c860"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c898"/>
<div class="gjs-row"><div class="gjs-cell c626"></div><div class="gjs-cell c635"></div><div class="gjs-cell c644"></div></div><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c599"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c671"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c709"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c747"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c785"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c823"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c860"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c898"/>
-->
<!--
<div class="gjs-row"><div class="gjs-cell c574"><div class="c643">Inserta tu texto aquí</div></div><div class="gjs-cell c583"><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c703"/></div></div>
<div class="gjs-row"><div class="gjs-cell c574"><div class="c643">Inserta tu texto aquí</div></div><div class="gjs-cell c583"><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c703"/></div></div>
<div class="gjs-row"><div class="gjs-cell c574"><div class="c643">Inserta tu texto aquí</div></div><div class="gjs-cell c583"><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c703"/></div></div>
<div class="gjs-row"><div class="gjs-cell c574"><div class="c643">Inserta tu texto aquí</div></div><div class="gjs-cell c583"><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c703"/></div></div>
<div class="gjs-row"><div class="gjs-cell c574"><div class="c643">Inserta tu texto aquí</div></div><div class="gjs-cell c583"><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c703"/></div></div>
<div class="gjs-row"><div class="gjs-cell c574"><div class="c643">Inserta tu texto aquí</div></div><div class="gjs-cell c583"><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c703"/></div></div>
<div class="gjs-row"><div class="gjs-cell c574"><div class="c643">Inserta tu texto aquí</div></div><div class="gjs-cell c583"><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c703"/></div></div>
<div class="gjs-row"><div class="gjs-cell c574"><div class="c643">Inserta tu texto aquí</div></div><div class="gjs-cell c583"><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c703"/></div></div>
-->
<!--<div class="gjs-row"><div class="gjs-cell c1595"><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c1716"/><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c1753"/><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c1790"/><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c1827"/><img src="http://prueba.test/img/semanaLogo/logo_2019.png" class="c1864"/></div></div><div class="gjs-row"><div class="gjs-cell c2009"><div class="c2075">EL COMITÉ ORGANIZADOR DE LA SEMANA DE POSGRADO EN BAJA CALIFORNIA SUR</div><div class="c2157">Otorga la presente constancia a:</div><div data-highlightable="1" class="participante"><b>Aquí se muestra el nombre del participante</b></div><div class="c2338">Por haber participado con el trabajo</div><div data-highlightable="1" class="trabajo">Aquí se muestra el nombre del trabajo</div></div></div><div class="gjs-row" id="i1nf"><div class="gjs-cell c678"><img src="http://prueba.test/img/logo/logo_4_2019.png" class="c1050"/></div><div class="gjs-cell c687"><img src="http://prueba.test/img/logo/logo_3_2019.png" class="c1087"/></div><div class="gjs-cell c696"><img src="http://prueba.test/img/logo/logo_2_2019.png" class="c1124"/></div></div><div class="gjs-row" id="idwv"><div class="gjs-cell c774"><div class="c1415"><div>Dra. Norma Y. Hernández Saavedra</div><div>Coordinadora UABCS</div></div></div><div class="gjs-cell c783"><div class="c1344"><div>Dr. Silverio López López</div><div>Coordinador CICIMAR</div></div></div><div class="gjs-cell c792"><div class="c1273"><div>MC. Juan Pablo Morales Alvarez</div><div>Coordinador</div></div></div></div><div class="gjs-row" id="i0qm"><div class="gjs-cell c870"></div><div class="gjs-cell c879"><img src="http://prueba.test/img/logo/logo_1_2019.png" class="c1161"/></div><div class="gjs-cell c888"></div></div><div class="gjs-row" id="i4z19"><div class="gjs-cell c966"></div><div class="gjs-cell c975"><div class="c1202"><div>Dr. Ricardo Bórquez Reyes</div><div>Coordinador UABCS</div></div></div><div class="gjs-cell c984"></div></div>-->

        {!! $constancia[0]->cHTML !!}

</body>


</html>
