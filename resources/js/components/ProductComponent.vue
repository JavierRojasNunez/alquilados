<template>
    <div class="card" style="margin-bottom: 25px">
        <div class="panel-heading">Publicado en {{ product.created_at }} - Última actualización: {{ product.updated_at }}</div>

        <div class="card-body">
 
            <input v-if="editMode" type="text" class="form-control" v-model="product.reference">
            <p v-else>{{ product.reference }}</p>

            <input v-if="editMode" type="text" class="form-control" v-model="product.category">
            <p v-else>{{ product.category }}</p>

            <input v-if="editMode" type="text" class="form-control" v-model="product.cost">
            <p v-else>{{ product.cost }}</p>

            <input v-if="editMode" type="text" class="form-control" v-model="product.quantity">
            <p v-else>{{ product.quantity }}</p>
            <p v-if="!editMode">{{calculateSum(product.quantity , 5)}}</p>
 
        </div>

        <div class="card-footer" >
            <button v-if="editMode" class="btn btn-success" v-on:click="onClickUpdate()">
                Guardar cambios
            </button>
            <button v-else class="btn btn-primary" v-on:click="onClickEdit()">
                Editar
            </button>
            <button v-if="editMode" class="btn btn-primary" v-on:click="onClickCancel()">
                cancelar
            </button>

            <button class="btn btn-danger" v-on:click="onClickDelete()">
                Eliminar
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['product'],
        data() {
            return {
                editMode: false,
                
                
            };
        },
        mounted() {
            console.log('Component product mounted.')
        },
        methods: {
            onClickDelete() {
                axios.delete(`/alquilados/public/eliminar-producto/${this.product.id}`).then(() => {
                    this.$emit('delete');
                });
            },
            onClickEdit() {
                this.editMode = true;
            },
            onClickCancel() {
                this.editMode = false;
            },
            onClickUpdate() {
                const params = {
                    reference: this.product.reference,
                    category: this.product.category,
                    cost: this.product.cost,
                    quantity: this.product.quantity
                };
                axios.put(`/alquilados/public/actualizar-producto/${this.product.id}`, params).then((response) => {
                    this.editMode = false;
                    const product = response.data;
                    this.$emit('update', product);
                });
            },
            calculateSum(value1, value2){
                return value1 + value2;        
            }
        }
    }
</script>