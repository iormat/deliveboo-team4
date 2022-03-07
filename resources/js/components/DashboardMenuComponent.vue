<template>
    <div id="dishes_menu">
        <h2>I tuoi piatti</h2>
        <!-- button to toggle create - form -->
        <div @click="createNewDish" class="mb-2 btn btn-success">Create</div>        

        <!-- dish menu -->
        <section id="menu" v-if="!createForm">
            <div class="container">
                <div class="row">
                    <ul class="col-sm-12 col-md-6 col-lg-4 col-xxl-3" v-for="dish in dishes" :key="dish.id">
                        <li class="card mycard">
                            <div class="card-main-info">
                                <h3>{{dish.dish_name}}</h3>
                                <span>{{dish.price}} &euro;</span>
                            </div>
                            <div class="card-body">
                                <div class="card-content">
                                    <div class="dish-img">
                                        <img :src="'/storage/dishes/' + dish.dishes_img" :alt="dish.dish_name">
                                    </div>
                                    <div class="details">
                                        <p>{{dish.description}}</p>
                                    </div>
                                </div>
                                <div class="mod-container">
                                    <span class="modifiers" @click="editDish(dish.id)"> edit </span>
                                    <span class="modifiers" @click="deleteDish(dish.id)"> cest </span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- create new dish component -->
        <CreateDishComponent 
        :dishes="dishes"
        :categories="categories"
        v-if="createForm"
        @createNewDish="createNewDish"
        @getNewDishes="getNewDishes"
        />
        
        <!-- edit existing dish - form -->
        <section v-if="changeForm" id="edit">
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

    </div>
</template>

<script>
import CreateDishComponent from './CreateDishComponent.vue';
export default {
    components: { 
        CreateDishComponent,
    },
    data: function(){
        return{
            // db data
            dishes: [],
            categories: [],

            // utility
            createForm: true,
            changeForm: false,

            // dish info
            available: true,
            dish_name: '',
            description: '',
            price: 0,
            ingredients: '',
            category: -1,
            dishes_img: "",
            
            editAvailable: false,
            editDish_name: '',
            editDescription: '',
            editPrice: 0,
            editIngredients: '',
            editCategory: -1,
            editDishes_img: "",

            // retrive for edit single dish info
            editDishArr: [],  
            dishEdit_id: -1,   
        };
    },

    methods: {
        // toggle create - form
        createNewDish() {
            this.createForm = !this.createForm;
            console.log(this.createForm)
        },

        // get new dish from CreateComponent
        getNewDishes(newDishes) {
            this.dishes = newDishes;
        },

        // toggle close edit - form
        toggleEditDish() {
            this.changeForm = !this.changeForm;
        },
        // get selected dish open edit - form
        editDish(id) {
            this.dishEdit_id = id;
            let selectedDish = this.dishes[this.getDishIndById(id)];
            this.editAvailable = selectedDish.available;
            this.editDish_name = selectedDish.dish_name;
            this.editDescription = selectedDish.description; 
            this.editPrice = selectedDish.price;
            this.editIngredients = selectedDish.ingredients; 
            this.editCategory = selectedDish.category; 
            this.editDishes_img = selectedDish.dishes_img; 
            this.changeForm = !this.changeForm;
        },
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

        // delete dish
        deleteDish(id) {
            axios.get(`/api/dishDelete/${id}`)
            .then(res => { 
                const dish = res.data;
                let dishInd = this.getDishIndById(dish.id);
                this.dishes.splice(dishInd, 1); 
            })
        },

        getDishIndById(id){
            for (let i = 0; i < this.dishes.length; i++) {
                const dish = this.dishes[i];
                if (dish.id == id) {
                    return i;
                }
            }
            return -1
        }
    },
    mounted() {
        //  get all dishes
        axios.get('/api/dishes/')
            .then(r=> this.dishes = r.data)
            .catch(e=>console.error(e));
        //  get all dishes category
        axios.get('/api/categories')
            .then(r=> this.categories = r.data)
            .catch(e=>console.error(e));
    },
}
</script>