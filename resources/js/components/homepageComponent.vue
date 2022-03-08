<template>
    <section id="restaurants">
        <select name="" id="" v-model="selectCategory">
            <option value="Tutti" selected>Tutti</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">{{category.category_name}}</option>
        </select>
        <div class="container">
            <ul class="row">
                <li v-for="restaurant in restaurants" :key="restaurant.id" class="col-sm-12 col-md-6 col-lg-4">
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
        categories : [],
        selectCategory : ''
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
        axios.get('/api/categories')
        .then(res => {
            this.categories = res.data
        })
    },
    computed: {
        // check array to get only related results
        showFiltered() {
            if(this.selectCategory ) {
                return this.discsArr;
            }
            return this.discsArr.filter((item) => {
                if(item.genre === this.selectedGenre){
                    return this.discsArr
                }
            })
        }
    }
}
</script>

<style>

</style>
