
@if ($anounce_id == false)
<div class="card">
  <div class="card-header" >{{ __('Imagenes') }}</div>

  <div class="card-body">

      <div class="form-row">

    <div class="form-group col-md-12">
      <div id="progress_bar"></div>
        <div class="invoiceBox">
        <label for="foto1">
          <div class="boxFile" id="boxFile" data-text="Seleccionar archivo">
            {{ __('Imagenes (una como minimo). ') }}
          </div>
        </label>
        
        <input type="file" id="foto1" name="foto1[]" multiple=""  >
        <div style="color: red"  id="errorFiles"></div>
        @error('foto1')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        
    @enderror
        </div>
        
      </div>

      </div>
  </div>
     
  @else
     
  
  <div class="card">
    <div class="card-header" >{{ __('Imagenes') }}</div>
  
    <div class="card-body">
  
        <div class="form-row">
  
      <div class="form-group col-md-12">
        <div id="progress_bar"></div>
          <div class="invoiceBox">
          <label for="foto1">
            <div class="boxFile" id="boxFile" data-text="Seleccionar archivo">
              {{ __('Imagenes ') }}
            </div>
          </label>
          
          <input type="file" id="foto1" name="foto1[]" multiple=""  >
          <div style="color: red"  id="errorFiles"></div>
          @error('foto1')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          
      @enderror
          </div>
          
        </div>
  
        </div>
    </div>
  </div>


  @endif