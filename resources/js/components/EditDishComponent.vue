<template>
    <section id="edit" class="container">
        <form id="edit_form" method="POST" enctype="multipart/form-data" @submit.prevent="updateDish">
            <!-- dish name - edit -->
            <label for="name">
                Inserisci il nome&colon;
                <input class="form-control" type="text" id="name" min="4" maxlength="120" required v-model="editDish_name" name="dish_name">
            </label>
            <!-- dish description - edit -->
            <label for="desription">
                Inserisci il una descrizione&colon;
                <textarea class="form-control" v-model="editDescription" id="desription" maxlenght="300" cols="50" rows="3" required></textarea>
            </label>
            <!-- dish price - edit -->
            <label for="price">
                Inserisci il prezzo&colon;
                <input class="form-control" type="number" min="0.00" max="999.99" step="0.01" id="price" required v-model="editPrice" onkeypress="return event.charCode>=48 && event.charCode<=57">
            </label>
            <!-- dish category - edit -->
            <label for="category">
                Categoria&colon;
                <select class="form-control" v-model="editCategory" name="category" id="category">
                    <option v-for="category in categories" :key="category.id" :value="category.id" >
                        {{category.category_name}}
                        {{category.id}}
                    </option>
                </select>
            </label>
            <!-- dish image - edit -->
            <label for="img">
                Aggiungi immagine&colon;
                <input class="form-control" type="file" @change="saveUpdatedImg" id="img">
            </label> 
            <!-- dish availabiliy - edit -->
            <div class="check-button">
                <label for="available" class="check-btn" name="available">
                    Disponibile&colon; 
                    <input type="checkbox" id="available" class="check-check" v-model="editAvailable">
                    <div class="check-after"></div>
                </label>
            </div>
            <!-- submit edit form -->
            <!-- close edit form -->
            <div class="text-right">
                <button  form="edit_form" class="btn">Modifica</button>
                <button class="btn" @click="toggleForm">Chiudi</button>
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
                this.$emit('updateDish', response.data)
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
        this.editCategory = this.editDishArr.category_id; 
        this.editDishes_img = this.editDishArr.dishes_img; 
    }
}
</script>