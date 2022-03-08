<template>
    <section id="edit" class="container">
        <form class="row" method="POST" enctype="multipart/form-data" @submit.prevent="updateDish">
            <!-- dish name - edit -->
            <label for="name" class="col-6">
                Inserisci il nome&colon;
                <input class="form-control" type="text" id="name" min="4" max="50" required v-model="editDish_name" name="dish_name">
            </label>
            <!-- dish description - edit -->
            <label for="desription" class="col-12">
                Inserisci il una descrizione&colon;
                <textarea class="form-control" v-model="editDescription" id="desription" cols="50" rows="3" required></textarea>
            </label>
            <!-- dish price - edit -->
            <label for="price" class="col-4">
                Inserisci il prezzo&colon;
                <input class="form-control" type="number" min="0.00" max="999.99" step="0.01" id="price" required v-model="editPrice">
            </label>
            <!-- dish category - edit -->
            <label for="category" class="col-4">
                Categoria&colon;
                <select class="form-control" v-model="editCategory" name="category" id="category">
                    <option v-for="category in categories" :key="category.id" :value="category.id" >
                        {{category.category_name}}
                        {{category.id}}
                    </option>
                </select>
            </label>
            <!-- dish ingredients - edit -->
            <label for="ingredients" class="col-12">
                Aggiungi gli ingredienti&colon;
                <textarea class="form-control" v-model="editIngredients" id="ingredients" cols="50" rows="3" required></textarea>
            </label>
            <!-- dish image - edit -->
            <label for="img" class="col-4">
                Aggiungi immagine&colon;
                <input class="form-control" type="file" @change="saveUpdatedImg" id="img">
            </label> 
            <!-- dish availabiliy - edit -->
            <label for="available">
                Disponibilit&agrave;&colon;
                <input type="checkbox" name="available" v-model="editAvailable" id="available">
            </label>
            <!-- submit edit form -->
            <input type="submit" class="btn btn-success" value="submit">
            <!-- close edit form -->
            <div class="text-right">
                <!-- <button class="btn btn-danger" @click="toggleEditDish">Chiudi</button> -->
            </div>
        </form>
    </section>
</template>

<script>
export default {
    data: function() {
        return {
            editAvailable: false,
            editDish_name: '',
            editDescription: '',
            editPrice: 0,
            editIngredients: '',
            editCategory: 0,
            editDishes_img: "",

        }
    },
    props: {
        categories: Array,
        editDishArr: Object,
    },
    methods: {
        // save updated user img - useful format
        saveUpdatedImg(img) {
            this.editDishes_img = img.target.files[0];
        },
                // update existing dish
        updateDish(event) {
            let form = new FormData(event.target);
            form.append("dish_name", this.editDish_name);
            form.append("description", this.editDescription);
            form.append("price", this.editPrice);
            form.append("ingredients", this.editIngredients);
            if(this.editDishes_img != ''){
                form.append("dishes_img",this.editDishes_img);  
            };
            form.append("category", this.editCategory);
            if (this.editAvailable === true || this.editAvailable === 1) {
                this.editAvailable = 1;
            } else {
                this.editAvailable = 0;
            }
            form.append("available", this.editAvailable);

            // post form 
            axios.post(`/api/updateDish/${this.editDishArr.id}`, form)
            .then( response => {
                // let ind = this.getDishIndById(this.dishEdit_id);
                this.$emit('updateDish', response.data)
                // this.dishes.splice(ind, 1, response.data)             
                this.$emit('toggleEditDish',)
            })
            .catch(function (error) {
                console.error(error);
            });
        },
        toggleForm() {
            this.$emit('toggleEditDish',)
        }
    },
    mounted() {
        this.editAvailable = this.editDishArr.available;
        this.editDish_name = this.editDishArr.dish_name;
        this.editDescription = this.editDishArr.description; 
        this.editPrice = this.editDishArr.price;
        this.editIngredients = this.editDishArr.ingredients; 
        this.editCategory = this.editDishArr.category_id; 
        this.editDishes_img = this.editDishArr.dishes_img; 
    }
}
</script>