<template>

         <!-- edit existing dish - form -->
    <section id="edit">
        <form 
            method="POST" 
            enctype="multipart/form-data" 
            @submit.prevent="updateDish">
            <!-- dish name - edit -->
            <label for="name">
                Inserisci il nome&colon;
                <br>
                <input type="text" id="name" min="4" max="50" required v-model="editDish_name" name="dish_name">
            </label>
            <br>
            <!-- dish description - edit -->
            <label for="desription">
                Inserisci il una descrizione&colon;
                <br>
                <textarea v-model="editDescription" id="desription" cols="50" rows="5" required></textarea>
            </label>
            <br>
            <!-- dish price - edit -->
            <label for="price">
                Inserisci il prezzo&colon;
                <br>
                <input type="number" min="0.00" max="999.99" step="0.01" id="price" required v-model="editPrice">
            </label>
            <br>
            <!-- dish ingredients - edit -->
            <label for="ingredients">
                Aggiungi gli ingredienti&colon;
                <br>
                <textarea v-model="editIngredients" id="ingredients" cols="50" rows="5" required></textarea>
            </label>
            <br>
            <!-- dish image - edit -->
            <label for="img">
                Aggiungi immagine&colon;
                <br>
                <input type="file" @change="saveUpdatedImg" id="img">
            </label> 
            <br>
            <!-- dish category - edit -->
            <select v-model="editCategory" class="my-3" name="category">
                <option v-for="category in categories" :key="category.id" :value="category.id" >
                    {{category.category_name}}
                    {{category.id}}
                </option>
            </select>
            <br>
            <!-- dish availabiliy - edit -->
            <label for="available">
                Disponibilit&agrave;&colon;
                <input type="checkbox" name="available" v-model="editAvailable" id="available">
            </label>
            <br>
            <!-- submit edit form -->
            <input type="submit" class="mb-5 btn btn-success" value="submit">
            <!-- close edit form -->
            <div class="text-right">
                <button class="btn btn-danger" @click="toggleEditDish">Chiudi</button>
            </div>
        </form>
    </section>

</template>
<script>
export default {
    data: function(){
        return{     
            // editAvailable: false,
            // editDish_name: '',
            // editDescription: '',
            // editPrice: 0,
            // editIngredients: '',
            // editCategory: -1,
            // editDishes_img: "",
        };
    },

    props: {
        dishEdit_id:      Number,
        categories:       Array,
        dishes:           Array,
        editAvailable:    Number,
        editDish_name:    String,
        editDescription:  String,
        editPrice:        Number,
        editIngredients:  String,
        editCategory:     Number,
        editDishes_img:   String,
        dish_id:          Number,
    },

    methods: {
        toggleEditDish() {
            this.changeForm = !this.changeForm;
            },
        saveUpdatedImg(img) {
            this.editDishes_img = img.target.files[0];
            console.log("updated dishes_img:", this.editDishes_img);
        },
       
       // submit create dish - form
         editDish(id) {
           
            dishEdit_id = id;
            let selectedDish = this.dishes[this.getDishIndById(id)];
            this.changeForm = !this.changeForm;
        },
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
            // form.append("user_id", this.editUser_id);

            if (this.editAvailable === true || this.editAvailable === 1) {
                this.editAvailable = 1;
            } else {
                this.editAvailable = 0;
            }
            form.append("available", this.editAvailable);
            console.log("available", this.editAvailable);


            // post form 
            axios.post(`/api/updateDish/${this.dishEdit_id}`, form)
            .then( response => {
                let ind = this.getDishIndById(this.dishEdit_id);
                this.dishes.splice(ind, 1, response.data)             
            })
            .catch(function (error) {
                console.error(error);
            });
            this.changeForm = !this.changeForm;
        },

            getDishIndById(id){
            // let id = this.dish_id;
            for (let i = 0; i < this.dishes.length; i++) {
                const dish = this.dishes[i];
                if (dish.id == id) {
                    return i;
                    console.log(id);
                }
            }
            return -1
        }
    },
}
</script>