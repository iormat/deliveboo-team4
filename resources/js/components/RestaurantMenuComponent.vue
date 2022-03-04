<template>
    <section id="restaurants">
        <div class="container">
            <!-- menu list -->
            <ul class="row">
                <li class="col-sm-12 col-md-6 col-lg-4" v-for="dish in menu" :key="dish.id">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3>Nome Piatto&colon; {{dish.dish_name}}</h3>
                            <span>Id&colon; {{dish.id}}</span>
                        </div>
                        <div class="card-body">
                            <p>Descrizione piatto&colon;</p>
                            {{dish.description}}
                        </div>
                        <div class="card-footer">
                            Prezzo piatto&colon;
                            <mark>{{dish.price}} &euro;</mark>
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
            menu: [],
        }
    },
    props: [
        'user'
    ],
    mounted() {

        axios.get(`/api/get/restaurant/menu/${this.user.id}`)
            .then(res => {
                this.menu = res.data;
                console.log(res)
            })
            .catch(err => {
                console.error(err);
            })

        console.log('id utente: ', this.user.id);
    }

    
}
</script>