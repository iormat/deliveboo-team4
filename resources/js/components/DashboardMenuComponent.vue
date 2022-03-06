<template>
    <div id="dishes_menu">
        <h2>I tuoi menu</h2>
        <!-- button to toggle create - form -->
        <div @click="createNewDish" class="mb-2 btn btn-success">Create</div>        
        <button @click="check" >CHECK</button>
        <!-- <create-component                               
            v-bind:createForm.sync="createForm" 
            :categories="categories"
            @update:arrayPush="arrayPush">
        </create-component> -->
        <create-component 
        :dishes="dishes"
        :categories="categories"
        v-if="createForm"
        @createNewDish="createNewDish"
        @getNewDishes="getNewDishes"

        >
        </create-component>

        <!-- create new dish - form -->
        
        <!--  table to display user menu -->
        <table border="2">
            <tr>
                <th>name</th>
                <th>desciption</th>
                <th>price</th>
                <th>ingredients</th>
                <th>user id</th>
                <th>available</th> 
                <th>edit</th>  
                <th>delete</th>
                <th>category</th>
                <th>image</th>
            </tr>

            <tr v-for="dish in dishes" :key="dish.id">
                <td>{{dish.dish_name}}</td>
                <td>{{dish.description}}</td>
                <td>{{dish.price}}</td>
                <td>{{dish.ingredients}}</td>
                <td>{{dish.user_id}}</td>
                <td>{{dish.available}}</td>
                <td>
                    <button @click="editDish(dish.id)" class="m-2 btn btn-primary">edit</button>
                </td>
                <td><button class="m-2 btn btn-danger" @click="deleteDish(dish.id)">Delete</button></td>

                <td>
                    <div v-for="category in categories" :key="category.id">
                        <span v-if="category.id == dish.category_id">{{category.category_name}}</span>
                    </div>
                </td>
                <td> 
                    <img class="w-25" v-if="dish.dishes_img"
                        :src="'/storage/dishes/' + dish.dishes_img"
                        alt=""><span v-else>image</span> 
                </td>

                <!-- <td><img :src="'storage/dishs/' + dish.image"></td> -->
            </tr>
        </table>

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
import CreateComponent from './CreateComponent.vue';
export default {
    components: { 
        'create-component' : CreateComponent
    },
    data: function(){
        return{
            // db data
            dishes: [],
            categories: [],

            // utility
            createForm: false,
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
        },

        // get new dish from CreateComponent
        getNewDishes(newDishes) {
            // console.log("dishes prima", this.dishes);
            console.log("asd",newDishes);
            this.dishes = newDishes;
            // console.log("dishes dopo", this.dishes);

        },

        // toggle close edit - form
        toggleEditDish() {
            this.changeForm = !this.changeForm;
        },
        // get selected dish open edit - form
        editDish(id) {
            // console.log(id);
            // this.editDishArr = [];
            // this.dishes.forEach(dish => {
                //     if(dish.id === id) {
                    //         this.editDishArr.push(dish)
            //     }
            // });

            this.dishEdit_id = id;
            let selectedDish = this.dishes[this.getDishIndById(id)];
            // console.log("selectedDish",selectedDish);

            this.editAvailable = selectedDish.available;
            this.editDish_name = selectedDish.dish_name;
            this.editDescription = selectedDish.description; 
            this.editPrice = selectedDish.price;
            this.editIngredients = selectedDish.ingredients; 
            this.editCategory = selectedDish.category; 
            this.editDishes_img = selectedDish.dishes_img; 
            

            // console.log('questo è il piatto: ', selectedDish.available);
            this.changeForm = !this.changeForm;
        },
        // save user img - useful format
        
        // save updated user img - useful format
        saveUpdatedImg(img) {
            this.editDishes_img = img.target.files[0];
            console.log("updated dishes_img:", this.editDishes_img);
        },
        // test button
        check() {
            console.log("check", this.dishes);

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
        // delete dish
        deleteDish(id) {
            console.log(id)
            let dishInd = this.getDishIndById(id);
            console.log(dishInd);
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

