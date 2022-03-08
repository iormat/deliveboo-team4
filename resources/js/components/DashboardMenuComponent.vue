<template>
    <div id="dishes_menu">
        <!-- button to toggle create - form -->
        <div @click="createNewDish" class="mb-2 btn btn-success">Create</div>        

        <!-- dish menu -->
        <section id="menu">
            <h2>I tuoi piatti</h2>
            <div class="container">
                <div class="row">
                    <ul class="col-sm-12 col-md-6 col-lg-4" v-for="dish in dishes" :key="dish.id">
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
                                        <p v-for="category in categories" :key="category.id">
                                            <span v-if="category.id === dish.category_id"> Categoria: {{category.category_name}} </span>
                                        </p>
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
        <EditDishComponent
        v-if="changeForm"
        :editDishArr="editDishArr"
        :categories="categories"
        @updateDish="updateDish"
        @toggleEditDish="toggleEditDish"
        />
    </div>
</template>

<script>
import CreateDishComponent from './CreateDishComponent.vue';
import EditDishComponent from './EditDishComponent.vue';
export default {
    components: { 
        CreateDishComponent,
        EditDishComponent,
    },
    data: function(){
        return{
            // db data
            dishes: [],
            categories: [],

            // utility
            createForm: true,
            changeForm: false,
            

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
            this.editDishArr = selectedDish;
            this.changeForm = !this.changeForm;
        },
        // save updated user img - useful format
        saveUpdatedImg(img) {
            this.editDishes_img = img.target.files[0];
        },
        // update existing dish
        updateDish(dish) {
            let ind = this.getDishIndById(dish.id);
            this.dishes.splice(ind, 1, dish)             
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