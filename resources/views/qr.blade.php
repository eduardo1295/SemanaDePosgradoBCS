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
            <div class="col-6">
            </div>
        </div>
    </div>
    <div class="visible-print text-center">
    	<h1>Laravel 5.7 - QR Code Generator Example</h1>

        {!! QrCode::size(250)->generate('ItSolutionStuff.com'); !!}

        <p>example by ItSolutionStuf.com.</p>
    </div>
</body>
</html>