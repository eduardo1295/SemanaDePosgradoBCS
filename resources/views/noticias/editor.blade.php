<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <title>Summernote - Bootstrap 4</title>
  <!-- include jquery -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>

  <!-- include libs stylesheets -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <!-- include summernote -->
  <link href="/css/summer/summernote-list-styles-bs4.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.js"></script>


  <script src="/js/summer/summernote-text-findnreplace.js"></script>
  <script src="/js/summer/summernote-list-styles-bs4.js"></script>
  <script type="text/javascript">
    $(document).ready(function () {

      $('.summernote').summernote({
        toolbar: [
          // [groupName, [list of button]]
           // The button
           ['color', ['color']],
           ['style', ['style']],
           ['fontname', ['fontname']],
           ['fontsize', ['fontsize']],
          ['font', ['bold', 'italic', 'underline', 'clear']],
          
          
          ['para', ['ul', 'ol', 'paragraph']],
          ['height', ['height']],
          ['table', ['table']],
          ['insert', ['link', 'hr']],
          ['view', ['fullscreen', 'codeview']],
          ['custom', ['findnreplace']],
        ],
        styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
      });

      $('.summernote').summernote({
  shortcuts: false
});

$('.summernote').summernote({
  disableDragAndDrop: true
});

      $('.summernote').summernote({
        popover: {
          image: [
            ['custom', ['imageTitle']],
            ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
            ['float', ['floatLeft', 'floatRight', 'floatNone']],
            ['remove', ['removeMedia']]
          ],
        },
        lang: 'en-US', // Change to your chosen language

      });
      $('.summernote').summernote({
        height: 500,
        maxHeight: null,
        tabsize: 2,
      });


    });

  </script>


  <style>
    html {
      overflow-y: scroll;
    }
  </style>

  <script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>
</head>

<body>

  <div class="container">

 


    <div class="row">

      
      <div class="col-xs-12 col-sm-12 col-md-12">
        <form method="POST" action="{{ route('noticia.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
          <center>
            <h1>What would you see in Laravel 5.7 ? </h1>
            <h4>Just share your idea.</h4>
          </center>
          <div class="form-group">
            <label for="usr">Title of Feature:</label>
            <input type="text" class="form-control" name="titulo">
          </div>
          <div class="form-group">
            <strong>Details:</strong>
            <textarea class="form-control summernote" name="contenido"></textarea>
          </div>
          <input type="file"  name="imgnoticia" class="form-control-file" id="logo">
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>

    </div>
  </div>

</body>

</html>