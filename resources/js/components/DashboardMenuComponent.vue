<template>
    <div id="postcards">
        <h2>I tuoi menu</h2>
        <div @click="newDish()" class="mb-2 btn btn-success">create</div>        
        <button @click="check" >CHECK</button>

        <section v-if="createForm" id="create">
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
                    <input type="number" min="0.00" max="999.99" id="price" v-model="price" required>
                </label>
                <br>
                <label for="ingredients">
                    Aggiungi gli ingredienti
                    <br>
                    <textarea v-model="ingredients" id="ingredients" cols="50" rows="5" required></textarea>
                </label>
                <br>
                

                 <label for="img">
                    Aggiungi gli ingredienti
                    <br>
                    <input type="file" @change="saveImg" id="img" required>
                </label> 
                <br>

                <select v-model="category" class="my-3" name="category">
                    <!-- <option selected disabled>{{category}}</option> -->
                    <option v-for="category in categories" :key="category.id" :value="category.id" >
                        {{category.category_name}}
                        {{category.id}}
                    </option>
                </select>
                
                <br>

                <input type="submit" class="mb-5 btn btn-success" value="submit">
            </form>
        </section>

        <table border="2">
            <tr>
                <!-- <th>{{user.id}}</th> -->
                <th>name</th>
                <th>desciption</th>
                <th>price</th>
                <th>user id</th> 
                <th>edit</th>  
                <th>delete</th>
                <th>category</th>
            </tr>

            <tr v-for="dish in dishes" :key="dish.id">
                <td>{{dish.dish_name}}</td>
                <td>{{dish.description}}</td>
                <td>{{dish.price}}</td>
                <td>{{dish.user_id}}</td>
                <td><button class="m-2 btn btn-primary">edit</button></td>
                <td><button class="m-2 btn btn-danger">delete</button></td>

                <td>
                    <div v-for="category in categories" :key="category.id">
                        <span v-if="category.id == dish.category_id">{{category.category_name}}</span>
                    </div>
                </td>

                <!-- <td><img :src="'storage/dishs/' + dish.image"></td> -->
            </tr>
        </table>
    </div>
</template>
<script>
export default {
    data: function(){
        return{
            dishes: [],
            categories: [],
            createForm: false,
            
            dish_name: '',
            description: '',
            price: 0,
            ingredients: '',
            category: -1,
            dishes_img: {},
            data: {},        
        };
    },

    props:[ 
        "csfr",
    ],

    methods: {
        newDish() {
            this.createForm = !this.createForm;
        },

        saveImg(img) {
            this.dishes_img = img.target.files[0];
            console.log("dishes_img:", this.dishes_img);

            //  let form = new FormData();
            // form.set("dish_name",this.dish_name);
            // form.set("description",this.description);
            // form.set("price",this.price);
            // form.set("ingredients",this.ingredients);
            // form.set("dishes_img",this.dishes_img);

            // axios.post('/api/saveImg',  form)
            // .then(function (response) {
            //     console.log("api saveimg:", response);
            // })
            // .catch(function (error) {
            //     console.log(error);
            // });
        },

        check() {
            console.log("check:", this.form);
        },

        submitDish() {
            // let form = new FormData();
            // form.set("dishes_img",this.dishes_img);
            
            this.data = {
                dish_name: this.dish_name,
                description: this.description,
                price: this.price,
                ingredients: this.ingredients,
                category: this.category,
                dishes_img: this.dishes_img,
                user_id: this.user_id,
            }
            console.log("data", this.data);

            axios.post('/api/create', this.data)
            .then(function (response) {
                console.log("api create:", response);
            })
            .catch(function (error) {
                console.log(error);
            });

            
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