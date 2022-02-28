<template>
    <div id="postcards">
        <h2>I tuoi menu</h2>
        <div @click="newDish()" class="mb-2 btn btn-success">create</div>        


        <section v-if="createForm" id="create">
            <div>
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
                <button @click.prevent="submitDish()" class="mb-5 btn btn-success">Submit</button>
            </div>
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
            data: {},
        };
    },

    methods: {
        newDish() {
            this.createForm = !this.createForm;
        },

        submitDish() {
            this.data = {
                dish_name: this.dish_name,
                description: this.description,
                price: this.price,
                ingredients: this.ingredients,
            }
            console.log(this.data);
            axios.post('/api/create', this.data)
            .then(function (response) {
                console.log(response);
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