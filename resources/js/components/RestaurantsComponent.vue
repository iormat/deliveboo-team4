<template>
    <section id="restaurants-list" >
      <my-header-component-due :user="user"></my-header-component-due>
      <div class="jumbo-restaurants"></div>
      <div class="d-flex justify-content-center mt-5">
        <h1>I nostri ristoranti</h1>
      </div>
       <div class="container flex-row">
        <div v-for="restaurant in restaurants" :key="restaurant.id" class="card" @click="goToRestaurant(restaurant.id)">
            <!-- <div class="business-img"> -->
                <div class="card-body">
                    <div class="img">
                      <img v-if="restaurant.img_rest" :src="'/storage/restaurants/' + restaurant.img_rest" width="100px">
                      <p v-else>image</p>
                    </div>
                    <div class="text">
                      <h3>{{restaurant.business_name}}</h3>
                      <div class="categories">
                      <span class="space"  v-for="typology in restaurant.types" :key="typology.id">
                      {{typology.type_name}} 
                      </span> 
                      </div>       
                      <p>{{restaurant.business_description}}</p>
                    </div>
                </div>    
            <!-- </div>    -->
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