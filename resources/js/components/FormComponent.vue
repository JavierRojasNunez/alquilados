<template>
    <div class="panel panel-default">
        <div class="panel-heading">Nuevo producto</div>

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
            quantity: ""
        };
    },
    mounted() {
        console.log("Component form mounted.");
    },
    methods: {
        newProduct() {
            const params = {
                reference: this.reference,
                category: this.category,
                cost: this.cost,
                quantity: this.quantity
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
        }
    }
};
</script>
