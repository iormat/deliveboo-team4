<template>
    <section id="restaurants">
        <!-- search for restaurant  type -->
        <div class="d-flex align-items-center justify-content-center h-25 divisore">
            <div class=" container-select-type d-flex align-items-center justify-content-center">
                <div class="type" v-for="type in types" :key="type.id">
                    <label :for="type.type_name">
                        {{type.type_name}}
                        <input @click="getRestaurants($event, type.type_name)" :value="type.type_name" type="checkbox" :id="type.type_name">
                    </label>
                </div>
            </div>
        </div>
        
        <!-- get restaurant to display -->
        <div class="container">
            <ul class="row">
                <li v-for="restaurant in showFiltered" :key="restaurant.id" class="col-sm-12 col-md-6 p-3">
                    <div @click="goToRestaurant(restaurant.id)">
                        <div class="card flex-row">
                            <div class="business-img">
                                <img src="https://picsum.photos/300/300" alt="">
                            </div>
                            <div class="card-body">
                                <h3>{{restaurant.business_name}}</h3>
                                <p>{{restaurant.business_description}}</p>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </section>
</template>

<script>
export default {

    data: function() {
        return {
            types : [],
            selectType : 'Tutti',

            restaurants: [],
        }
    },
    
    methods: {
        // redirect to restaurant details page
        goToRestaurant(id) {
            axios.get(`/restaurant/details/${id}`)
            .then(res => {
                window.location.href = `/restaurant/details/${id}`;
            })
            .catch(err => {
                console.log(err);
            })
        },
        // get selected restaurants types
        getRestaurants(event, type) {
            if(event.target.checked) {
                axios.post('/api/user/chosen/restaurants', type)
                    .then(res => {
                        res.data.forEach(element => {
                            const parsed = JSON.stringify(this.restaurants);
                            if(!parsed.includes(`"id":${element.id}`)) {
                                element.type = type;
                                this.restaurants.push(element)
                                console.log(element)
                            }
                        });
                    })
            }else {
                this.restaurants = this.restaurants.filter(function(element){
                    if(element.type != type) {
                        return element
                    }
                })
            }
        },
    },
    mounted() {
        axios.get('/api/restaurants/types')
        .then(res => {
            this.types = res.data;
        })
    },
}
</script>