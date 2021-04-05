<div class="card">
    <div class="card-header">{{ __('Empecemos a rellenar los datos.') }}</div>
    
      <div class="card-body">
      
        <div class="form-row">
            
            <div class="form-group col-md-4">
    
              @if (isset($anounce_id) && $anounce_id)
                <input type="hidden" value="{{$anounce_id}}" name="anounce_id">
              @endif
    
              <label for="type_rent">{{ __('Que alquilas') }}<sup style="color:red; font-size:16px">*</sup></label>
              
              <select id="type_rent" name="type_rent" class="form-control @error('type_rent') is-invalid @enderror"    required  >
                <option selected > {{ $anuncio ? $anuncio->type_rent :  old('type_rent') }} </option>                                   
                <option>{{ __('Piso') }}</option>
                <option>{{ __('Casa') }}</option>
                <option>{{ __('Habitación') }}</option>
                <option>{{ __('Apartamento') }}</option>
                <option>{{ __('Compartir apartamento') }}</option>
                <option>{{ __('Local') }}</option>
                <option>{{ __('Casa rural') }}</option>
                <option>{{ __('Apartamento rural') }}</option>
                <option>{{ __('Loft') }}</option>
                <option>{{ __('Estudio') }}</option>
                <option>{{ __('Dúplex') }}</option>
                <option>{{ __('Ático') }}</option>
                <option>{{ __('Masía') }}</option>
                <option>{{ __('Bungalow') }}</option>
              </select>
              @error('type_rent')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
            </div>
            <div class="form-group col-md-4">
              <label for="price">{{ __('Por cuanto (€)') }}<sup style="color:red; font-size:16px">*</sup></label>
              <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror"   value="{{ $anuncio ? $anuncio->price :   old('price') }}" required autocomplete="price"  >
              @error('price')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="payment_period">{{ __('Periodo de pago') }}<sup style="color:red; font-size:16px">*</sup></label>
                <select id="payment_period" name="payment_period" class="form-control @error('payment_period') is-invalid @enderror"   value="{{ old('payment_period') }}" required autocomplete="payment_period" >
                  <option   selected>{{  $anuncio ? $anuncio->payment_period :  old('payment_period') }}</option>
                  <option>{{ __('diario') }}</option>
                  <option>{{ __('semanal') }}</option>
                  <option> {{ __('mensual') }}</option>
                  <option> {{ __('trimestal') }}</option>
                  <option> {{ __('semestral') }}</option>
                  <option> {{ __('anual') }}</option>
                  <option> {{ __('con opción a compra') }}</option>
                </select>
                @error('payment_period')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
            </div>
          
            <div class="form-group col-md-3">
                <label for="num_rooms">{{ __('Habitaciones') }}</label>
                <select id="num_rooms" name="num_rooms" class="form-control @error('num_rooms') is-invalid @enderror"  >
                    <option selected > {{ $anuncio ? $anuncio->num_rooms :   old('num_rooms') }} </option>                                   
                    <option>{{ __('1') }}</option>
                    <option>{{ __('2') }}</option>
                    <option>{{ __('3') }}</option>
                    <option>{{ __('4') }}</option>
                    <option>{{ __('5') }}</option>
                    <option>{{ __('6') }}</option>
                    <option>{{ __('7') }}</option>
                    <option>{{ __('8') }}</option>
                    <option>{{ __('9') }}</option>
                    <option>{{ __('10') }}</option>
                </select>
                @error('num_rooms')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
              </div>

              <div class="form-group col-md-3">
                <label for="num_baths">{{ __('Baños') }}</label>                     
                <select id="num_baths" name="num_baths" class="form-control @error('num_baths') is-invalid @enderror"  >
                    <option selected > {{ $anuncio ? $anuncio->num_baths :   old('num_baths') }} </option>                                   
                    <option>{{ __('1') }}</option>
                    <option>{{ __('2') }}</option>
                    <option>{{ __('3') }}</option>
                    <option>{{ __('4') }}</option>
                    <option>{{ __('5') }}</option>
                    <option>{{ __('6') }}</option>
                    <option>{{ __('7') }}</option>
                    <option>{{ __('8') }}</option>
                    <option>{{ __('9') }}</option>
                    <option>{{ __('10') }}</option>
                </select>
               
                @error('num_baths')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
              </div>
          <div class="form-group col-md-3">
            <label for="meter2">{{ __('Superficie ') }}m<sup>2</sup></label>
            <input type="number" id="meter2" placeholder="0"  name="meter2" class="form-control @error('meter2') is-invalid @enderror"   value="{{  $anuncio ? $anuncio->meter2 :   old('meter2') }}"  autocomplete="meter2" >
            @error('meter2')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
          </div>

          
          <div class="form-group col-md-3">
            <label for="deposit">{{ __('¿Depósito inicial? (€)') }}</label>
            <input type="number"  id="deposit" name="deposit"  class="form-control @error('deposit') is-invalid @enderror"   value="{{ $anuncio ? $anuncio->deposit :   old('deposit') }}"  autocomplete="deposit" >
            @error('deposit')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
          </div>
          <div class="form-group col-md-3">
            <label for="available_date">{{ __('Fecha disponibilidad') }}</label>
            <input type="date"  name="available_date" id="available_date" class="form-control @error('available_date') is-invalid @enderror"   value="{{  $anuncio ? $anuncio->available_date :   old('available_date') }}"  autocomplete="available_date" >
            @error('available_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
          </div>
        </div>
      </div>
    </div>