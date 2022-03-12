<template>
    <section id="restaurants-list">
      <my-header-component-due></my-header-component-due>
       <div class="container flex-row">
        <div v-for="restaurant in restaurants" :key="restaurant.id" class="card" @click="goToRestaurant(restaurant.id)">
            <div class="business-img">
                <img src="https://picsum.photos/300/300" alt="">
            </div>
            <div class="card-body">
                <h3>{{restaurant.business_name}}</h3>
                <p>{{restaurant.business_description}}</p>
            </div>        
        </div>
       </div>
    </section>
</template>

<script>
export default {
  data: function () {
    return {
      restaurants: {},
    };
  },
    mounted() {
        //  get all dishes
        axios.get('/api/allRestaurants/')
            .then(r=>{
              console.log(r.data);
              this.restaurants = r.data
              })
            .catch(e=>console.error(e));
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
    }
}
</script>