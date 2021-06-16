
  <div class="modal fade" id="contact_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Datos de contacto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="text-align: left; padding-left:60px">
          <p><img src="../icons/phone.png" class="icons-small" id="anouce_phone" title="Télefono" alt="Télefono"> &nbsp; {{$anuncio->phone}}</p>
          <p><img src="../icons/email.png" class="icons-small" title="Email" alt="Email"> &nbsp; {{$anuncio->user->email}}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          
        </div>
      </div>
    </div>
  </div>