<template>
    <div id="postcards">
        <h2>I tuoi menu</h2>
        <div @click="newDish" class="mb-2 btn btn-success">create</div>        
        <button @click="check" >CHECK</button>
        <!-- <CreateComponent/> -->
        <create-component                               
                            v-bind:createForm.sync="createForm" 
                            :categories="categories"
                            @update:arrayPush="arrayPush">
            </create-component>

        <!-- <section v-if="createForm" id="create">
            <form method="POST" enctype="multipart/form-data" @submit.prevent="submitDish">
                <input type="hidden" name="_token" :value="csfr">
                

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
        </section> -->

        <table border="2">
            <tr>
                <!-- <th>{{user.id}}</th> -->
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
                    <button @click="changeDish" class="m-2 btn btn-primary">edit</button>
                </td>
                <td><button class="m-2 btn btn-danger">delete</button></td>

                <td>
                    <div v-for="category in categories" :key="category.id">
                        <span v-if="category.id == dish.category_id">{{category.category_name}}</span>
                    </div>
                </td>
                <td> <img class="w-25" v-if="dish.dishes_img"
                        :src="'/storage/dishes/' + dish.dishes_img"
                        alt=""><span v-else>image</span> 
                </td>

                <!-- <td><img :src="'storage/dishs/' + dish.image"></td> -->
            </tr>

        <section v-if="changeForm" id="edit">
            <form method="POST" enctype="multipart/form-data" @submit.prevent="submitDish">
                <input type="hidden" name="_token" :value="csfr">
                

                <label for="name">
                    Inserisci il nome
                    <br>
                    <input type="text" id="name" v-model="dish_name" min="4" max="50" required value="">
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
                    <input type="file" @change="saveImg" id="img" required>
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


        </table>
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
            dishes: [],
            categories: [],
            createForm: false,
            changeForm: false,
            
            available: true,
            dish_name: '',
            description: '',
            price: 0,
            ingredients: '',
            category: -1,
            dishes_img: "",
            data: {},        
        };
    },

    props:[ 
        "csfr",
    ],
    computed:{
        // arrayPush(dishes) {
        //     this.dishes = dishes;
        // },
    },

    methods: {
       
        newDish() {
            this.createForm = !this.createForm;
        },
        changeDish() {
            this.changeForm = !this.changeForm;
        },

        saveImg(img) {
            this.dishes_img = img.target.files[0];
            console.log("dishes_img:", this.dishes_img);

        },

        check() {
            console.log("check:", this.dishesPull(dishess));
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

            axios.post('/api/create', form)
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

        }
    },
    mounted() {
        axios.get('/api/dishes/')
            .then(r=> this.dishes = r.data)
            .catch(e=>console.error(e));

        axios.get('/api/categories')
            .then(r=> this.categories = r.data)
            .catch(e=>console.error(e));
    },

}
</script>

