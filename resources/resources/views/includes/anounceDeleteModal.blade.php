<div class="modal" tabindex="-1" role="dialog" id="delete-anounce-modal-{{$anuncio->id}}">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ey...!!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="">
          <p>Vas a eliminar el anuncio, ¿estas seguro?.</p>
        </div>
        <div class="modal-footer">
            <a href="{{ route('delete.anounce', ['id' => $anuncio->id] ) }}"  type="button" class="btn btn-primary" >Eliminar</a>
          
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>