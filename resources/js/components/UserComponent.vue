<template>

<div class="card" style="margin-bottom: 25px">
    <div class="card-body">
    <form action="" v-on:submit.prevent="newUser()">

            <div class="form-group">  
                <label v-if="editMode" for="name">Nombre</label>
                <input v-if="editMode" type="text" class="form-control"  v-model="user.name" >
                <h5 v-else>{{ user.name }}</h5>
            </div>
            
            <div class="form-group">  
                <label v-if="editMode" for="name">Apellidos</label>
                <input v-if="editMode" type="text" class="form-control" v-model="user.surname">
                <h5 v-else>{{ user.surname }}</h5>
            </div>
            <div class="form-group">  
                <label v-if="editMode" for="name">Email</label>
                <input v-if="editMode" type="text" disabled class="form-control" v-model="user.email" aria-describedby="emailHelp">
                 <small v-if="editMode" id="emailHelp" class="form-text text-muted">Por razones de seguridad para cambiar el email contacte con el admin de la web.</small>
                <h5 v-else>{{ user.email }}</h5>
            </div>
            
 </form>
        </div>

        <div class="card-footer" >
            <button v-if="editMode" class="btn btn-success" v-on:click="onClickUpdate()">
                Guardar cambios
            </button>
            <button v-else class="btn btn-primary" v-on:click="onClickEdit()">
                Editar
            </button>

            <button  v-if="editMode" class="btn btn-danger" v-on:click="onClickCancel()">
                cancelar
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                editMode: false
            };
        },
        mounted() {
            console.log('Component user mounted.')
        },
        methods: {
            
            onClickEdit() {
                this.editMode = true;
            },
            onClickCancel(){
                this.editMode = false;
            },
            onClickUpdate() {
                const params = {
                    name: this.user.name,
                    surname: this.user.surname,
                    email: this.user.email
                    
                };
                
                axios.put(`/alquilados/public/perfil/${this.user.id}`, params).then((response) => {
                    this.editMode = false;
                    const user = response.data;
                    this.$emit('update', user);
                });
            }
        }
    }
</script>