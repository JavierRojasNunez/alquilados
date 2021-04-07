$(document).ready(function(){

    var url = 'http://localhost/alquilados/public';   
    //servidor
    //var url = 'https://azimutweb.es/alquilados/public/index.php'; 

    

    $("#anounce-add").click(function(e){
        
        e.preventDefault();
        $('#exampleModalCenter').modal('show');

    });

    $(".btn.btn-danger.delete").click(function(e){

        e.preventDefault();
        var anuncio_id = $(this).attr('data-id');
        $('#delete-anounce-modal-'+anuncio_id).modal('show');

    });
     
    $(".image_delete").click(function(e){

        e.preventDefault();
        //recupero id:imagen
        var value = $(this).attr('value');
        //recupero id:anuncio
        var anounce_id = $(this).attr('data-anounce'); 
        $.ajax({

            url: url + '/eliminar-imagenes/'+  value + '/' +  anounce_id, 
            
            success: function( result ){

                
            if(result.numImages == 5 ){


                $('#form-images-5').html(`
                <div class="card">
                    <div class="card-header" >Imagenes</div>  
                        <div class="card-body"> 
                            <div class="form-row"> 
                            <div class="form-group col-md-12">
                            <div id="progress_bar"></div>
                                <div class="invoiceBox">
                                <label for="foto1">
                                <div class="boxFile" id="boxFile" data-text="Seleccionar archivo">
                                Imagenes
                                </div>
                                </label>         
                            <input type="file" id="foto1" name="foto1[]" multiple=""  >
                            <div style="color: red"  id="errorFiles"></div>         
                            </div>         
                            </div>
                            </div>
                        </div>
                    </div>
                    <div style="text-align: center; margin-top:20px">       
                    <button  type="submit" id="submit1" class="btn btn-primary" style="width: 50%;text-align:center ">Enviar</button>
                </div>
                `);

                //cargamos esdta funcion de nuevo pues cuando se carha el form anterior no esta en el DOM todaia 
                //cuando carga document.ready.function
                
                document.querySelector('#foto1').addEventListener('change', function(e) {

                    var editing = $("#edit-images").val();
            
                    //si es el formulario de imagenes editar anuncio que no ssuba mas de 4
                    if (editing ==  '76345976' && e.target.files.length > 4){
                        $("#errorFiles").text('Lo Sentimos, no se pueden subir mas de 4 Imagenes.');
                        return false;
                    }
            
                    if (e.target.files.length <= 5){
                    
                        var boxFile = document.querySelector('.boxFile');
                        boxFile.classList.remove('attached');
                        boxFile.innerHTML = boxFile.getAttribute("data-text");
                        if(this.value != '') {
                        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif\.tiff)$/i;
                        if(allowedExtensions.exec(this.value)) {
            
                            var maxMb = 20000000; //20Mb
                            var sizeFiles = 0;
                            
                            boxFile.innerHTML = '';
                            boxFile.innerHTML = 'Imagenes cargadas!!<br>';
                            for(let i=0; i<e.target.files.length; i++){
            
                                sizeFiles += parseInt(e.target.files[i].size);
                                boxFile.innerHTML += '<b>Imagen ' + (i+1) + ' </b>- '  + e.target.files[i].name + '<br>';
                                if (sizeFiles > maxMb){
                                    this.value = '';
                                    boxFile.classList.remove('attached');
                                    $("#errorFiles").text('Eyy!! no se pueden subir mas de 20Mb en total y los archivos pesan mas.');
                                    boxFile.innerHTML = "<p> Imagenes.</p>"
                                    return false;
                                }
                                
                            }               
            
                            boxFile.classList.add('attached');
            
                        } else {
                            this.value = '';
                           // alert('El archivo que intentas subir no está permitido.\nLos archivos permitidos son .pdf, .jpg, .jpeg, .png, .gif y .tiff');
                            $("#errorFiles").text('El archivo que intentas subir no está permitido.\nLos archivos permitidos son .jpg, .jpeg, .png y .gif ');
                            boxFile.classList.remove('attached');
                        }
                        }
                    }else{
            
                        $("#errorFiles").text('Eyy!! no se pueden subir mas de 5 Imagenes.');
            
                    }
            
            
                
                  });
                
                
            }
                   
            if(result.respuesta == 1){      
                
                $('#image' + value).remove();
                
                $('#imageModal').fadeIn('500').delay('700').fadeOut();

                
    
            }else if (result.respuesta == 2)
            {
                $('#imageModal-error-ultima').modal('show');
            }else
            {
                $('#imageModal-error').modal('show');
            }
            
            }});
            

    });
        
    $("#province_rent").change(function(e){

        e.preventDefault();
        var province = $(this).val();
        var province_id = province.split( '-');
        province_id = province_id[0].trim();
         
    $.ajax({
        url: url + '/cities/'+  province , 
        beforeSend: function () 
            {
                
                $("#province_rent").prop('disabled', true);
                $("#city_rent").prop('disabled', true);

            },
        success: function( result ){

        $("#province_rent").prop('disabled', false);
        $("#city_rent").prop('disabled', false);
        $("#city_rent").find('option').remove();
       
        if(result){      
            
            for( i=0; i<result.ciudades.length; i++)
           {
              $("#city_rent").append('<option class="province_id" data-id="'+ province_id +'" value="' + result.ciudades[i].city_name + '">' + result.ciudades[i].city_name + '</option>');
           }           
           
        }
        else
        {
            $("#city_rent").append('<option>Elige Prov..</option>');
        }
        
        }});
        
       
    
    });
        
    $("#adress_rent").on('keyup',function(e){

        e.preventDefault();
        var letter = $(this).val();
        var province_id = '';
        province_id = $(".province_id").attr("data-id");

        $.ajax({
        url: url + '/adress/'+  letter + '/' + province_id , 
        beforeSend: function () {
                    
        },
        success: function( result ){


           // console.log(result);
            $("#suggestions").html("");
            var arrayCiudades = result.calles;

            arrayCiudades = Object.values(arrayCiudades);
            for(var i = 0; i<arrayCiudades.length; i++){
                                                        
                 $("#suggestions").append('<div><a class="suggest-element" data-cp="' + arrayCiudades[i].CPOS + '" id="' + arrayCiudades[i].NVIAC + '" data="' 
                  + arrayCiudades[i].NVIAC+ '">'
                  + arrayCiudades[i].NVIAC + ' - ' 
                  + arrayCiudades[i].NNUCLE50 + ' - ' 
                  + arrayCiudades[i].CPOS +
                  '</a></div>');
            }

            $('.suggest-element').on('click', function(){
                
                var id = $(this).attr('id');
                var cp = $(this).attr('data-cp'); 

                $('#adress_rent').val(id);
                $('#cp_rent').val(cp);

                $('#suggestions').fadeOut(500);

                
        });
                
        if(result){      
            
                   
           
        }
        else
        {
           
        }
        
        }});
        


       
    
    });
 
    $("#form_anuncio").submit(function(e){


        
        if( $("#foto1").val() == "" ){	
            e.preventDefault(); 
            $("#errorFiles").text('Selecciona una imagen minimo.');
            return false;
        }else{
            $('#progress_bar').html(`
            <p>Subiendo imagenes</p>
            <div class="meter">
                <span style="width:80%;"><span class="progress"></span></span>
            </div>
            `);
            $('#submit1').attr("disabled", true);
            $('#form_anuncio').submit();
        }
    });

    $("#form_imagenes").submit(function(e){
        
        if( $("#foto1").val() == "" ){	
            e.preventDefault(); 
            $("#errorFiles").text('Selecciona una imagen minimo.');
            return false;
        }else{
            
            $('#progress_bar').html(`
            <p>Subiendo imagenes</p>
            <div class="meter" >
                <span style="width:80%;"><span class="progress"></span></span>
            </div>
            `);
            $('#submit1').attr("disabled", true);
            $('#form_anuncio').submit();
        }
    });
   
    
    document.querySelector('#foto1').addEventListener('change', function(e) {

        var editing = $("#edit-images").val();

        //si es el formulario de imagenes editar anuncio que no ssuba mas de 4
        if (editing ==  '76345976' && e.target.files.length > 4){
            $("#errorFiles").text('Lo Sentimos, no se pueden subir mas de 4 Imagenes.');
            return false;
        }

        if (e.target.files.length <= 5){
        
            var boxFile = document.querySelector('.boxFile');
            boxFile.classList.remove('attached');
            boxFile.innerHTML = boxFile.getAttribute("data-text");
            if(this.value != '') {
            var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif\.tiff)$/i;
            if(allowedExtensions.exec(this.value)) {

                var maxMb = 20000000; //20Mb
                var sizeFiles = 0;
                
                boxFile.innerHTML = '';
                boxFile.innerHTML = 'Imagenes cargadas!!<br>';
                for(let i=0; i<e.target.files.length; i++){

                    sizeFiles += parseInt(e.target.files[i].size);
                    boxFile.innerHTML += '<b>Imagen ' + (i+1) + ' </b>- '  + e.target.files[i].name + '<br>';
                    if (sizeFiles > maxMb){
                        this.value = '';
                        boxFile.classList.remove('attached');
                        $("#errorFiles").text('Eyy!! no se pueden subir mas de 20Mb en total y los archivos pesan mas.');
                        boxFile.innerHTML = "<p> Imagenes.</p>"
                        return false;
                    }
                    
                }               

                boxFile.classList.add('attached');

            } else {
                this.value = '';
               // alert('El archivo que intentas subir no está permitido.\nLos archivos permitidos son .pdf, .jpg, .jpeg, .png, .gif y .tiff');
                $("#errorFiles").text('El archivo que intentas subir no está permitido.\nLos archivos permitidos son .jpg, .jpeg, .png y .gif ');
                boxFile.classList.remove('attached');
            }
            }
        }else{

            $("#errorFiles").text('Eyy!! no se pueden subir mas de 5 Imagenes.');

        }


    
      });




    });

    function currentPhoto(anounce_id){

        var currentPhoto;
        var currentPhoto_id;
        var totalPhotos;
        currentPhoto = $(".carousel-item." + anounce_id + ".active").attr("data-current-photo");
        currentPhoto_id = parseInt(currentPhoto)+1;
        totalPhotos = $("#total-photo" + anounce_id).attr("data-total");
        $(".carousel-control-prev."+anounce_id).show();
        $("#current-photo"+anounce_id).html(currentPhoto_id);

        if(currentPhoto_id == totalPhotos){
            $(".carousel-control-next."+anounce_id).hide();
        }else{
            $(".carousel-control-next."+anounce_id).show();
        }
    }

    function currentPhotoPrev(anounce_id){
     
        var currentPhoto;
        var currentPhoto_id;
        currentPhoto = $(".carousel-item." + anounce_id + ".active").attr("data-current-photo");
        currentPhoto_id = parseInt(currentPhoto)-1;
        totalPhotos = $("#total-photo" + anounce_id).attr("data-total");
        $("#current-photo"+anounce_id).text(currentPhoto_id);
        $(".carousel-control-next."+anounce_id).show();

        if(currentPhoto_id == 1){
            $(".carousel-control-prev."+anounce_id).hide();
        }else{
            $(".carousel-control-prev."+anounce_id).show();
        }
    }