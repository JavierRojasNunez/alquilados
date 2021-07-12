<template>
    <div class="panel panel-default">

        <div class="panel-heading">Nuevo producto</div>
        <div>
            <!-- con esta sintaxis es como reconoce Vue.js la propiedad src del attr <img> -->
            <img :src="img" :title="imgAlt" :id="id">
            <img v-bind:src="img">
        </div>
        <div>
            Carrito Cantidad: <b>{{cartQuantity}}</b>
            <br>
            <button type="buttom" class="btn btn-primary" v-on:click="cartQuantity += 1" >Mas</button>
            <br>
            <button type="buttom" class="btn btn-primary" @click="downCart()">Menos</button>
        </div>
        {{message}}
        <!-- el metodo reversedMessage nos devuelve el valor de message pero esta vex con HTML
        para qie Vue.js pueda renderizar la vista hay que colocarlo en un <div> de esta manera
            y no usando las dobles llaves y aqui tambien se puede concatenar -->
        <div v-html="message + ' - y ahora alrevés ' +  reversedMessage"></div>
        <div class="panel-body">
            <!-- v-on:submit.prevent es  la manera que tiene vue de enviar el formulario en este caso ejecutando newProduct -->
            <form action="" v-on:submit.prevent="newProduct()">
                
                <div class="form-group">
                    <label for="reference">Referencia:</label>
                    <input
                        type="text"
                        class="form-control"
                        name="reference"
                        v-model="reference"
                    />
                </div>
                <div class="form-group">
                    <label for="caregory">Categoria:</label>
                    <input
                        type="text"
                        class="form-control"
                        name="category"
                        v-model="category"
                    />
                </div>
                <div class="form-group">
                    <label for="cost">Coste:</label>
                    <input
                        type="text"
                        class="form-control"
                        name="cost"
                        v-model="cost"
                    />
                </div>
                <div class="form-group">
                    <label for="quantity">Cantidad:</label>
                    <input
                        type="text"
                        class="form-control"
                        name="quantity"
                        v-model="quantity"
                    />
                </div>
                <button type="submit" class="btn btn-primary">
                    Enviar Producto
                </button>
                <br>
                <br>
                <button v-if="isVisible == false" type="submit" class="btn btn-dark" @click="onClickShowProducts()">
                    Ver Productos
                </button>
                
                <button v-else type="submit" class="btn btn-dark" @click="onClickHideProducts()">
                    Ocultar Productos
                </button>
            </form>
        </div>
    </div>
</template>

<script>
// en export default en la funcion data tenemos que crear un objeto con las variables que recogeremos del componente
export default {
    
    data() {
        return {
            reference: "",
            category: "",
            cost: "",
            quantity: "",
            message: "",
            isVisible:false,
            img: '../public/images/106/6072cf7c7af25-5568835-1.jpg',
            imgAlt: 'esto es una imagen....',
            id:25,
            cartQuantity:0
            
        };
    },
    mounted() {
        //aqui podemos incluir toda la logica JS que queramos
        let message = 'Hola, ¿Que tal?';
        this.message = message;
       // console.log("Component form mounted.");
    },
    computed: {
    // a computed getter
    //creamos una variable con la logica dentro de computed que quedará en cache a diferencia de si lo tuvieramos en methods
    reversedMessage: function () {
      return '<b>' +this.message.split('').reverse().join('') + '</b>'
    }
  },
    methods: {
        newProduct() {
            const params = {
                reference: this.reference,
                category: this.category,
                cost: this.cost,
                quantity: this.quantity,
                
            };
            //eliminamos los valores para que los campos del formulario se vacien
            this.reference = "";
            this.category = "";
            this.cost = "";
            this.quantity = "";
            //con this.$emit('new', product); emite un evento que será recogido por my-products-component  por @new="addProduct"
            axios.post("/alquilados/public/producto", params).then(response => {
                const product = response.data;
                console.log(product);
                this.$emit("new", product);
            });
        },
         onClickShowProducts(){
             this.isVisible = true;
              this.$emit("show");
         },
         onClickHideProducts(){
             this.isVisible = false;
              this.$emit("hide");
         },
         upCart(){
            this.cartQuantity ++;
         },
         downCart(){
             
             if(this.cartQuantity == 0){
                  this.cartQuantity;
             }else{
                  this.cartQuantity --;
             }

         },
         whatch:{
             cartQuantity: function(val){
                 console.log('valor de: ' + val)
             }
         }
    }
};
</script>
