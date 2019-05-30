@extends('layoutsM1.principal')
@section('links')
    <link rel="stylesheet" href="{{ mix('css/Maqueta2.css')}} ">
@endsection
@section('menu')
    @include('layoutsM2.navbar')
@endsection
@section('footer')
    @include('layoutsM2.footer')
@endsection    
@section('scripts')
        <script src="/js/menumaker.js"></script>
@endsection

@section('contenido')
    <div class="container"  >
        <div class="row">
            <div class="col-12">
                <h1 id="Titulo" class="display-5  font-weight-bold rounded text-center p-auto pt-3">Noticias</h1> <br>
            </div>
        </div>
    </div>
        <div id="noticias">
            @include('noticias.paginacionNoticias')
        </div>

<script>
    $(document).ready(function () {

        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

        function fetch_data(page) {
            $.ajax({
                url: "/noticia/fetch_data?page=" + page,
                success: function (data) {
                    $('#noticias').html(data);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }

    });
</script>
@endsection