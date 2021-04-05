<div class="col-md-9">
    <br />
  <div class="card">
    <div class="card-header">{{ __('Perfil de los ocupantes actuales') }}</div>
  
    <div class="card-body">
  
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="num_people_in">{{ __('Número personas ahora') }}</label>
            
            <input type="number"  id="num_people_in" name="num_people_in" placeholder="0" class="form-control @error('num_people_in') is-invalid @enderror"   value="{{  $anuncio ? $anuncio->num_people_in :    old('num_people_in') }}"  autocomplete="num_people_in" >
            @error('num_people_in')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
          </div>
          
        <div class="form-group col-md-4">
          <label for="people_in_sex">{{ __('Quién vive en ella') }}</label>                 
          <select id="people_in_sex" class="form-control @error('people_in_sex') is-invalid @enderror" name="people_in_sex"  value="{{ old('people_in_sex') }}"  autocomplete="people_in_sex" >
            <option selected >{{   $anuncio ? $anuncio->people_in_sex :    old('people_in_sex')  }}</option>
            <option>{{ __('Chicas') }}</option>
            <option>{{ __('Chicos') }}</option>
            <option>{{ __('Mixto') }}</option>
            <option>{{ __('Indiferente') }}</option>
            <option>{{ __('Nadie') }}</option>
          </select>
          @error('people_in_sex')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
        </div>
        
        <div class="form-group col-md-4">
            <label for="people_in_job">{{ __('Ocupación')}}</label>
            <select id="people_in_job"  class="form-control @error('people_in_job') is-invalid @enderror" name="people_in_job"  value="{{ old('people_in_job') }}"  autocomplete="people_in_job" >
              <option selected>{{   $anuncio ? $anuncio->people_in_job :    old('people_in_job') }}</option>
              <option>{{ __('Profesional') }}</option>
              <option>{{ __('Estudiantes') }}</option>
              <option>{{ __('Mixto') }}</option>
              <option>{{ __('Indiferente') }}</option>
            </select>
            @error('people_in_job')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
          </div>
          
      </div>
      <br /> 
      <div class="form-row">
        <div class="form-group col-md-6">
          <label class="switchBtn">
            <input class="form-check-input" type="checkbox" id="people_in_tabaco" {{ ( $anuncio and $anuncio->people_in_tabaco) ? 'checked' : ''}} name="people_in_tabaco" class="form-control @error('people_in_tabaco') is-invalid @enderror"    >
                                            
            <div class="slide round">{{ __('Fuman') }}</div>
        </label>
            
          </div>
          <div class="form-group col-md-6">
            <label class="switchBtn">
              <input class="form-check-input" type="checkbox" id="people_in_pet" {{ ( $anuncio and $anuncio->people_in_pet )? 'checked' : ''}} name="people_in_pet" class="form-control @error('people_in_pet') is-invalid @enderror"    >
                                                
              <div class="slide round">{{ __('Mascotas') }}</div>
          </label>
            
          </div>
      </div>
  
    </div>
  </div>
  
  </div>