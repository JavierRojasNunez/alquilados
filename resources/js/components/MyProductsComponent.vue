<template> 
<div class="col-md-10">      

    <!-- @new="addProduct" esd la escucha del evento addProduct que se emite de la forma this.$emit('new', product); en FormComponent  -->
     <form-component 
     @new="addProduct" 
     @show="visible"
     @hide="hideProducts">
     </form-component> 
     <!-- aplicamos una transición con opacidad para suavizar el show/hide las css estan abajo-->
    <transition name="slide-fade"> 
    <!-- v-for es un blucle en Vue le decimos que itere cada product de products
         con :product="product" le decimo que en el componente <product-component>
         haya una variable llamada product con la info de cada product 
         indicamos que la :key que envie al conmtrollador para eliminar sea la id-->
        
<div v-if="isVisible == true">
    <product-component
        v-for="(product, index) in products"
        :key="product.id"
        :product="product" 
        
        @update="updateProduct(index, ...arguments)"
        @delete="deleteProduct(index)"> 
    </product-component>
</div>
 </transition>        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                products: [],
                isVisible: false                
            }
        },
        mounted() {
            axios.get('/alquilados/public/todos-productos').then((response) => {
                this.products = response.data;
                console.log(response.data)
            });
        },
        methods: {
            addProduct(product) {
                this.products.push(product);
            },
            updateProduct(index, product) {
                this.products[index] = product;
            },
            deleteProduct(index) {
                this.products.splice(index, 1);
            },
            calculateSum(value1, value2){
                return value1 + value2;        
            },
            visible(){
                return this.isVisible = true;        
            },
            hideProducts(){
                return this.isVisible = false; 
            }
        }
    }
</script>
<style lang="css" scoped>
/* Las animaciones de entrada y salida pueden usar */
/* funciones de espera y duración diferentes.      */
.slide-fade-enter-active {
  transition: all .4s ease;
}
.slide-fade-leave-active {
  transition: all .4s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(500px);
  opacity: 0;
}
</style>