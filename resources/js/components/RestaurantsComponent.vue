<template>
    <section id="restaurants-list">
      <my-header-component-due :user="user"></my-header-component-due>
       <div class="container flex-row">
        <div v-for="restaurant in restaurants" :key="restaurant.id" class="card" @click="goToRestaurant(restaurant.id)">
            <div class="business-img">
                <img src="https://picsum.photos/300/300" alt="">
                <div class="title-category">
                  <h3>{{restaurant.business_name}}</h3>
                  <div v-for="type, i in restaurant.types" :key="i">
                    {{type.type_name}}
                  </div>
                </div>
            </div>
            <div class="card-body">
                <p>{{restaurant.business_description}}</p>
            </div>        
        </div>
       </div>
    </section>
</template>

<script>
export default {
  props: {
        user: String,
    },
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