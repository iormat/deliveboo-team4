<template>
    <div id="dishes_menu">
        <h2>I tuoi menu</h2>
        <!-- button to toggle create - form -->
        <div @click="createNewDish" class="mb-2 btn btn-success">Create</div>        
        <button @click="check" >CHECK</button>
        <!-- <CreateComponent/> -->
        <!-- <create-component                               
            v-bind:createForm.sync="createForm" 
            :categories="categories"
            @update:arrayPush="arrayPush">
        </create-component> -->

        <!-- create new dish - form -->
        <section v-if="createForm" id="create">
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
        <!--  table to display user menu -->
        <table border="2">
            <tr>
                <th>name</th>
                <th>desciption</th>
                <th>price</th>
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
                <td>{{dish.user_id}}</td>
                <td>{{dish.available}}</td>
                <td>
                    <button @click="changeDish(dish.id)" class="m-2 btn btn-primary">edit</button>
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
                    <input type="text" id="name" min="4" max="50" required v-model="editDishArr[0].dish_name">
                </label>
                <br>
                <!-- dish description - edit -->
                <label for="desription">
                    Inserisci il una descrizione&colon;
                    <br>
                    <textarea v-model="editDishArr[0].description" id="desription" cols="50" rows="5" required></textarea>
                </label>
                <br>
                <!-- dish price - edit -->
                <label for="price">
                    Inserisci il prezzo&colon;
                    <br>
                    <input type="number" min="0.00" max="999.99" step="0.01" id="price" required v-model="editDishArr[0].price">
                </label>
                <br>
                <!-- dish ingredients - edit -->
                <label for="ingredients">
                    Aggiungi gli ingredienti&colon;
                    <br>
                    <textarea v-model="editDishArr[0].ingredients" id="ingredients" cols="50" rows="5" required></textarea>
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
                <select v-model="editDishArr[0].category" class="my-3" name="category">
                    <option selected disabled>{{editDishArr[0].category_id}}</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id" >
                        {{category.category_name}}
                        {{category.id}}
                    </option>
                </select>
                <br>
                <!-- dish availabiliy - edit -->
                <label for="available">
                    Disponibilit&agrave;&colon;
                    <input @click="checkAvailable" v-model="editDishArr[0].available" type="checkbox" name="available" id="available">
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
            available: false,

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
        // toggle close edit - form
        toggleEditDish() {
            this.changeForm = !this.changeForm;
        },
        // get selected dish open edit - form
        changeDish(id) {
            console.log(id);
            this.editDishArr = [];
            this.dishEdit_id = id;
            this.dishes.forEach(dish => {
                if(dish.id === id) {
                    this.editDishArr.push(dish)
                }
            });
            console.log('questo è il piatto: ', this.editDishArr);
            this.changeForm = !this.changeForm;
        },
        // save user img - useful format
        saveImg(img) {
            this.dishes_img = img.target.files[0];
            console.log("dishes_img:", this.dishes_img);
        },
        // save updated user img - useful format
        saveUpdatedImg(img) {
            this.editDishArr[0].dishes_img = img.target.files[0];
            console.log("updated dishes_img:", this.editDishArr[0].dishes_img);
        },
        // test button
        check() {
            console.log("check:", this.dishesPull(dishess));
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
                self.dishes.push(response.data)
                console.log("api create:", response.data);
            })
            .catch(function (error) {
                console.error(error);
            });
            // reset all dish properties
            this.dish_name = this.description = this.ingredients = this.dishes_img = '';
            this.price = this.category = 0;
            this.data = {};
            this.createForm = !this.createForm;
        },
        // toggle availability
        checkAvailable() {
            this.available = !this.available
        },
        // update existing dish
        updateDish(event) {
            console.log('questo è event: ', event);
            let form = new FormData(event.target);
                form.append("dish_name", this.editDishArr[0].dish_name);
                form.append("description", this.editDishArr[0].description);
                form.append("price", this.editDishArr[0].price);
                form.append("ingredients", this.editDishArr[0].ingredients);
                if(this.editDishArr[0].dishes_img != ''){
                  form.append("dishes_img",this.editDishArr[0].dishes_img);  
                };
                form.append("category", this.editDishArr[0].category);
                form.append("user_id", this.editDishArr[0].user_id);
                if(this.editDishArr[0].available === true) {
                    form.append('available', true)
                }
            // post form 
            let self = this;
            axios.post(`/api/updateDish/${this.dishEdit_id}`, form)
            .then(function (response) {
                self.dishes.push(response.data)
                console.log("api update:", response.data);
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
            this.dishes.splice(dishInd, 1);
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
                return -1;
            }
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

