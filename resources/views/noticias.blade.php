@extends('layoutsM1.principal')
@section('links')
    <link rel="stylesheet" href="/css/Maqueta2.css ">
    
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
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 pr-0 pl-0">
                <h1 id="Titulo" class="display-3 text-center font-weight-bold rounded p-auto">Noticias</h1> <br>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mb-3 hvr-underline-from-left">
                    <div class="row no-gutters align-items-center">
                        <div class="col-sm-4 col-md-2">
                            <img src="/img/logo.png" class="card-img" alt="...">
                        </div>
                        <div class="col-sm-8 col-md-10">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                    additional content. This content is a little bit longer.</p>
                                <div class="d-flex justify-content-between ">
                                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                    <h4><a href="/unaNota" class="badge badge-primary">Ver Mas</a></h4>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
    
            </div>
        </div>
        <div class="row">
                <div class="col-12">
                    <div class="card mb-3 hvr-underline-from-left">
                        <div class="row no-gutters align-items-center">
                            <div class="col-sm-4 col-md-2">
                                <img src="/img/logo.png" class="card-img" alt="...">
                            </div>
                            <div class="col-sm-8 col-md-10">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                        additional content. This content is a little bit longer.</p>
                                    <div class="d-flex justify-content-between ">
                                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                        <h4><a href="/unaNota" class="badge badge-primary">Ver Mas</a></h4>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
        
                </div>
            </div>
            <div class="row">
                    <div class="col-12">
                        <div class="card mb-3 hvr-underline-from-left">
                            <div class="row no-gutters align-items-center">
                                <div class="col-sm-4 col-md-2">
                                    <img src="/img/logo.png" class="card-img" alt="...">
                                </div>
                                <div class="col-sm-8 col-md-10">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                            additional content. This content is a little bit longer.</p>
                                        <div class="d-flex justify-content-between ">
                                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                            <h4><a href="/unaNota" class="badge badge-primary">Ver Mas</a></h4>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
            
                    </div>
                </div>
    </div>

    
@endsection

