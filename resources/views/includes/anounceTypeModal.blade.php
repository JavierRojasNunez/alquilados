  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: 0px; text-align:center">
          <h5 class="modal-title" id="exampleModalLongTitle">¿Que vas a publicar?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span> 
        </div>
        <div class="" style="align-items:center ; padding:20px; " >
        <div style="width: 50%; float:left; text-align:center">
            <a type="buttom" class="btn btn-primary" href="{{ route('create.anounce',['type'=>'venta']) }}" id="anounce-add" class="nav-link">Venta</a>
        </div>
        <div style="width: 50%; float:left; text-align:center">   
            <a type="buttom" class="btn btn-primary" href="{{ route('create.anounce',['type'=>'alquiler']) }}" id="anounce-add" class="nav-link">Alquiler</a>    
        </div>
        </div>
        <div class="modal-footer" style="border-top: 0px">
         

        </div>
      </div>
    </div>
  </div>