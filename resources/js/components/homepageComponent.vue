<template>
    <section id="restaurants">
        <section class="container">
            <h2>I nostri consigliati</h2>
            <div class="fav-restaurants">
                <ul class="row flex-nowrap">
                    <li v-for="favRes in favRestaurants" :key="favRes.id" class="col-sm-12 col-md-6 p-3">
                        <div @click="goToRestaurant(favRes.id)">
                            <div class="card flex-row">
                                <div class="business-img">
                                    <img src="https://picsum.photos/300/300" alt="">
                                </div>
                                <div class="card-body">
                                    <h3>{{favRes.business_name}}</h3>
                                    <p>{{favRes.business_description}}</p>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>

        <!-- search for restaurant  type -->
        <div class="container">
            <h2>Quale cucina vorresti provare?</h2>
            <div class="types_container">
                <div class="type" v-for="type in types" :key="type.id"> 
                    <input @click="getRestaurants($event, type.type_name)" :value="type.type_name" type="checkbox" :id="type.type_name">
                    <label :for="type.type_name">{{type.type_name}}</label>
                </div>
            </div>
        </div>
        
        <!-- get restaurant to display -->
        <div class="container">
            <ul class="row">
                <li v-for="restaurant in restaurants" :key="restaurant.id" class="col-sm-12 col-md-6 p-3">
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

            favRestaurants: [],
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
                            }
                        });
                    })
            }else {
                // remove restaurants from list if type unchecked
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

        axios.get('/api/fav/restaurants')
            .then(res => {
                res.data.forEach(element => {
                    this.favRestaurants.push(element);
                });
            })
    },
}
</script>