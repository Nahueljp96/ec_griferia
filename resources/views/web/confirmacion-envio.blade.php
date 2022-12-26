@extends ("web.plantilla")

@section ("contenido")
<section class="book_section layout_padding-bottom">
      <div class="container">
      <div class=" mx-auto mt-5">
      <div class="heading_container"></div>
      <h2 class="pb-4">Gracias por contactarnos</h2>
      <div class="row">
         <div class="col-md-6">
            @csrf
            <p> Mensaje enviado! </p>
         </div>   

      </div>
      </div>
      </div>
</section>



@endsection