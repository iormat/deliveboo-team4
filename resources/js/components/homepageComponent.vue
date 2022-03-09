<template>
    <section id="restaurants">
        <!-- search for restaurant  type -->
        <select name="" id="" v-model="selectType">
            <option value="Tutti" selected>Tutti</option>
            <option v-for="type in types" :key="type.id" :value="type.id">{{type.type_name}}</option>
        </select>
        <!-- get restaurant to display -->
        <div class="container">
            <ul class="row">
                <li v-for="restaurant in showFiltered" :key="restaurant.id" class="col-sm-12 col-md-6 g-5">
                    <div @click="goToRestaurant(restaurant.id)">
                        <div class="card flex-row">
                            <div class="business-img">
                                <img src="https://picsum.photos/300/300" alt="">
                            </div>
                            <div class="card-body">
                                <h3>Restaurant&colon; {{restaurant.business_name}}</h3>
                                <p>Restaurant description&colon;</p>
                                {{restaurant.business_description}}
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
        }
    },

    props: {
            restaurants: Array,
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
        }
    },
    mounted() {
        axios.get('/api/restaurants/types')
        .then(res => {
            this.types = res.data;
        })
    },
    computed: {
        // check array to get only related results
        showFiltered() {
            if(this.selectType === 'Tutti') {
                return this.restaurants;
            }
            return this.restaurants.filter((restaurant) => {
                for (let i = 0; i < restaurant.types.length; i++) {
                    let type = restaurant.types[i];
                    if(type.id === this.selectType){
                        return this.restaurants;
                    }
                }   
            })
        }
    }
}
</script>