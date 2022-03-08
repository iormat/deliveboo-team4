<template>
  <section id="restaurants">
        <div class="container">
            <ul class="row">
                    <li v-for="restaurant in restaurants" :key="restaurant.id" class="col-sm-12 col-md-6 col-lg-4">
                        <!-- <a href="{{route('restaurant', $restaurant.id)}}"> -->
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
                        <!-- </a> -->
                    </li>
            </ul>
        </div>
    </section>
</template>

<script>
export default {

data: function() {
    return {
    }
},
props: {
        restaurants: Array,
    }
}
</script>

<style>

</style>
