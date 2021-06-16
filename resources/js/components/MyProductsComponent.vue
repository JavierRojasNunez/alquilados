<template> 
<div class="col-md-10">      

    <!-- @new="addProduct" esd la escucha del evento addProduct que se emite de la forma this.$emit('new', product); en FormComponent  -->
     <form-component @new="addProduct"></form-component> 

    <!-- v-for es un blucle en Vue le decimos que itere cada product de products
         con :product="product" le decimo que en el componente <product-component>
         haya una variable llamada product con la info de cada product 
         indicamos que la :key que envie al conmtrollador para eliminar sea la id-->
    <product-component
        v-for="(product, index) in products"
        :key="product.id"
        :product="product" 
        
        @update="updateProduct(index, ...arguments)"
        @delete="deleteProduct(index)"> 
    </product-component>

        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                products: []
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
            }
        }
    }
</script>