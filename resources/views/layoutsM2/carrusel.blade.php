<div id="carrusel" class="container-fluid">
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      @for ($i = 0; $i < $carrusel->count(); $i++)
        @if ($i== 0)
         <li data-target="#carouselExampleIndicators" data-slide-to='{{$i}}' class="active"></li>
        @else
        <li data-target="#carouselExampleIndicators" data-slide-to='{{$i}}' ></li>
        @endif  
      @endfor
    </ol> 
    

    <div class="carousel-inner" role="listbox">
      <!-- Slide One - Set the background image for this slide in the line below -->
      @php
          $x = 0
      @endphp
      @foreach ($carrusel as $slide)
        @if ($x == 0)
        @php    
        $x++;
        @endphp
            <div class="carousel-item active" style="">
        @else
        <div class="carousel-item" style="">
        @endif
          @if(isset($slide->link_web))
          <a href="{{$slide->link_web}}" target="_blank">
            <img src="{{url('img/carrusel')}}/{{ $slide->url_imagen }}" alt="" class="w-100 h-100">
          </a>
          @else
            <img src="{{url('img/carrusel')}}/{{ $slide->url_imagen }}" alt="" class="w-100 h-100">
          @endif
          
            <div class="carousel-caption d-none">
            </div>
          </div>
      @endforeach

      
      <!-- Slide Two - Set the background image for this slide in the line below 
      <div class="carousel-item" style="background-image: url()">
        <div class="carousel-caption d-none">
          <h3 class="display-4">Second Slide</h3>
          <p class="lead">This is a description for the second slide.</p>
        </div>
      </div>
      Slide Three - Set the background image for this slide in the line below 
      <div class="carousel-item" style="background-image: url('/images/3.jpg')">
        <div class="carousel-caption d-none">
          <h3 class="display-4">Third Slide</h3>
          <p class="lead">This is a description for the third slide.</p>
        </div>
      </div>-->
    </div>


    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
  </div>
</div>