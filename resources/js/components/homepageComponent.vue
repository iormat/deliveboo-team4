<template>
    <section id="restaurants">
        <select name="" id="" v-model="selectType">
            <option value="Tutti" selected>Tutti</option>
            <option v-for="type in types" :key="type.id" :value="type.id">{{type.type_name}}</option>
        </select>
        <div class="container">
            <ul class="row">
                <li v-for="restaurant in showFiltered" :key="restaurant.id" class="col-sm-12 col-md-6 col-lg-4">
                    <div @click="goToRestaurant(restaurant.id)">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3>Restaurant&colon; {{restaurant.business_name}}</h3>
                                <span>Id&colon; {{restaurant.id}}</span>
                            </div>
                            <div class="card-body">
                                <p>Restaurant description&colon;</p>
                                {{restaurant.business_description}}
                            </div>
                            <div class="card-footer">
                                Restauran PIVA&colon;
                                <mark>{{restaurant.p_iva}}</mark>
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
        restaurantsArr : []
    }
},
props: {
        restaurants: Array,
    },
    
methods: {
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
            this.types = res.data
        })
    },
    created() {
        this.restaurantsArr = this.restaurants
        console.log(this.restaurantsArr[0].types[0].type_name);
    },
    computed: {
        // check array to get only related results
        showFiltered() {
            if(this.selectType === 'Tutti') {
                return this.restaurantsArr;
            }
            return this.restaurantsArr.filter((item) => {
                for (let i = 0; i < item.types.length; i++) {
                    let type = item.types[i]
                    if(type.id === this.selectType){
                        return this.restaurantsArr;
                    }
                }   
            })
        }
    }
}
</script>

<style>

</style>
