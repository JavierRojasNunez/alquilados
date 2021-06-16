<template> 
<div class="row justify-content-center">
<div class="col-md-10">      

    <!-- @new="addProduct" esd la escucha del evento addProduct que se emite de la forma this.$emit('new', user); en FormComponent  -->
    <!-- <form-component ></form-component> -->

    <!-- v-for es un blucle en Vue le decimos que itere cada user de users
         con :user="user" le decimo que en el componente <user-component>
         haya una variable llamada user con la info de cada user 
         indicamos que la :key que envie al conmtrollador para eliminar sea la id-->
    <user-component
        :user="users"
        :key="users.id" 
        @update="updateUser(index, ...arguments)"
        @delete="deleteUser(index)">
    </user-component>

       
    </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                users: '',
                saludo: ''
            }
        },
        mounted() {

            let hola = 'hola';
            axios.get('/alquilados/public/perfil').then((response) => {
                this.users = response.data;
                this.saludo = hola;
            });
        },
        methods: {           
            updateUser(user) {
                this.user = user;
            }
        }
    }
</script>