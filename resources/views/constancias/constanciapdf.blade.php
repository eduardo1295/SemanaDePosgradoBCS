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

        @font-face {
            font-family: 'Arial';
            src: url({{ storage_path('fonts\arialbd.ttf') }}) format("truetype");
        }
       
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
        {!! $constancia[0]->cHTML !!}

</body>


</html>
