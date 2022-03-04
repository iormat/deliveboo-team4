<template>
    <!-- <section> -->
    <section id="create">
        <!-- display errors component -->
        <form-error-component
        v-if="validationErrors"
        :errors='validationErrors'
        ></form-error-component>

        <!-- edit - form -->
        <form method="POST" enctype="multipart/form-data" @submit.prevent="submitDish">
            <!-- dish name - create -->
            <label for="name">
                Inserisci il nome&colon;
                <br>
                <input type="text" id="name" v-model="dish_name" min="4" max="50" required>
            </label>
            <br>
            <!-- dish description - create -->
            <label for="desription">
                Inserisci il una descrizione&colon;
                <br>
                <textarea v-model="description" id="desription" cols="50" rows="5" required></textarea>
            </label>
            <br>
            <!-- dish price - create -->
            <label for="price">
                Inserisci il prezzo&colon;
                <br>
                <input type="number" min="0.00" max="999.99" step="0.01" id="price" v-model="price" required>
            </label>
            <br>
            <!-- dish ingredients - create -->
            <label for="ingredients">
                Aggiungi gli ingredienti&colon;
                <br>
                <textarea v-model="ingredients" id="ingredients" cols="50" rows="5" required></textarea>
            </label>
            <br>
            <!-- dish img - create -->
            <label for="img">
                Aggiungi immagine&colon;
                <br>
                <input type="file" @change="saveImg" id="img">
            </label> 
            <br>
            <!-- categories select - create -->
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
            available: true,
            dish_name: '',
            description: '',
            price: 0,
            ingredients: '',
            category: -1,
            dishes_img: "",

            newDishes: [],
            validationErrors: '',
        };
    },

    props: {
        dishes: Array,
        categories: Array,
    },

    methods: {
        saveImg(img) {
            this.dishes_img = img.target.files[0];
            console.log("dishes_img:", this.dishes_img);
        },
       
       // submit create dish - form
        submitDish(e) {
            let form = new FormData(e.target);
                form.append("dish_name", this.dish_name);
                form.append("description", this.description);
                form.append("price", this.price);
                form.append("ingredients", this.ingredients);
                if(this.dishes_img != ''){
                  form.append("dishes_img",this.dishes_img);  
                };
                form.append("category", this.category);
                form.append("user_id", this.user_id);
            // post form 

            let self = this;
            axios.post('/api/store', form)
            .then(function (response) {
                self.newDishes = self.dishes;
                self.newDishes.push(response.data);
                // console.log("api create:", self.newDishes);
                self.$emit("getNewDishes", self.newDishes);

                // reset all dish properties
                // this.dish_name = this.description = this.ingredients = this.dishes_img = '';
                // this.price = this.category = 0;
                // this.createForm = !this.createForm;

                this.$emit("createNewDish");

            })
            .catch(error => {
                if(error.response.status == 422) {
                    this.validationErrors = error.response.data.errors;
                }
                console.error(error);
            });

            // reset all dish properties
            this.dish_name = this.description = this.ingredients = this.dishes_img = '';
            this.price = this.category = 0;
            this.createForm = !this.createForm;

            // this.$emit("createNewDish");
        },
    },
}
</script>

