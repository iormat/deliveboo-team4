<template>

        <!-- <section> -->
        <section v-if="createForm" id="create">
            <h1>funzionaa</h1>
            <form method="POST" enctype="multipart/form-data" @submit.prevent="submitDish">
                <label for="name">
                    Inserisci il nome
                    <br>
                    <input type="text" id="name" v-model="dish_name" min="4" max="50" required>
                </label>
                <br>
                <label for="desription">
                    Inserisci il una descrizione
                    <br>
                    <textarea v-model="description" id="desription" cols="50" rows="5" required></textarea>
                </label>
                <br>
                <label for="price">
                    Inserisci il prezzo
                    <br>
                    <input type="number" min="0.00" max="999.99" step="0.01" id="price" v-model="price" required>
                </label>
                <br>
                <label for="ingredients">
                    Aggiungi gli ingredienti
                    <br>
                    <textarea v-model="ingredients" id="ingredients" cols="50" rows="5" required></textarea>
                </label>
                <br>
                

                 <label for="img">
                    Aggiungi immagine
                    <br>
                    <input type="file" @change="saveImg" id="img">
                </label> 
                <br>

                <select v-model="category" class="my-3" name="category">
                    <option v-for="category in categories" :key="category.id" :value="category.id" >
                        {{category.category_name}}
                        {{category.id}}
                    </option>
                </select>
                
                <br>

                <input type="submit" class="mb-5 btn btn-success" value="submit"> 

            </form>

        </section>

</template>
<script>
export default {
    data: function(){
        return{
            dishes: [],

            dish_name: '',
            description: '',
            price: 0,
            ingredients: '',
            category: -1,
            dishes_img: "",
            data: {},        
            
        };
    },

    props: {
        createForm: Boolean,
        categories: Array
    },

    methods: {

        // newDish() {
        //     this.createForm = !this.createForm;
        // },

        saveImg(img) {
            this.dishes_img = img.target.files[0];
            console.log("dishes_img:", this.dishes_img);

        },

        submitDish(e) {
            let form = new FormData(e.target);
                form.append("dish_name",this.dish_name);
                form.append("description", this.description);
                form.append("price", this.price);
                form.append("ingredients", this.ingredients);
                if(this.dishes_img != ''){
                  form.append("dishes_img",this.dishes_img);  
                };
                form.append("category", this.category);
                form.append("user_id", this.user_id);

            let self = this;

            axios.post('/api/store', form)
            .then(function (response) {
                self.dishes.push(response.data)
                console.log("api create:", response.data);
            })
            .catch(function (error) {
                console.log(error);
            });

            this.dish_name =   this.description = this.ingredients = this.dishes_img ='';
            this.price = this.category = 0;
            this.data = {};
            this.createForm = !this.createForm;

            this.$emit('update:createForm', e.createForm);
            this.$emit('ArrayPush', dishes);

        }
    },
}
</script>

