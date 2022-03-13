<template>
    <!-- <section> -->
    <section class="loginRegister">
        <form id="create_form" method="POST" enctype="multipart/form-data" @submit.prevent="submitDish">
            <!-- dish name - create -->
            <label for="name">
                Inserisci il nome del piatto&colon;
                <input class="form-control" type="text" id="name" v-model="dish_name" min="4" maxlength="50" required>
            </label>
            <!-- dish description - create -->
            <label for="desription">
                Aggiungi una descrizione&colon;
                <textarea class="form-control" v-model="description" id="desription" cols="50" rows="3" required></textarea>
            </label>
            <!-- dish price - create -->
            <label for="price">
                Inserisci il prezzo&colon;
                <input class="form-control" type="number" min="0.00" max="999.99" step="0.01" id="price" v-model="price" required onkeypress="return event.charCode>=48 && event.charCode<=57">
            </label>
            <!-- dish img - create -->
            <label for="dish_img">
                Aggiungi immagine&colon;
                <input class="form-control" type="file" @change="saveImg" id="dish_img">
            </label> 
            <!-- categories select - create -->
            <label for="category">
                Seleziona una categoria di appartenenza&colon;
                <select id="category" class="form-select" v-model="category" name="category">
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{category.category_name}}
                    </option>
                </select> 
            </label>
            <!--  -->
            <div class="text-right">
                <button form="create_form" class="btn btn-success">Crea</button>
                <button class="btn btn-danger" @click="toggleForm">Chiudi</button>
            </div>

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
            category: 1,
            dishes_img: "",

            newDishes: [],
        };
    },

    props: {
        dishes: Array,
        categories: Array,
    },

    methods: {
        // save form image
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
                self.$emit("getNewDishes", self.newDishes);
            })
            .catch(function (error) {
                console.error(error);
            });

            // reset all dish properties
            this.dish_name = this.description = this.ingredients = this.dishes_img = '';
            this.price = this.category = 0;
            this.createForm = !this.createForm;

            this.$emit("createNewDish");
        },
        toggleForm() {
            this.$emit("createNewDish");
        }
    },
}
</script>