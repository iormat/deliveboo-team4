
<template>
  <section id="order-page">
      <h2>I tuoi ordini</h2>
        <ol reversed class="m-3 px-2">
            <li v-for="order in orders" :key="order.id" class="lst">
                <div class="orders-list" :class="order.confirmed == 1 ? 'itemGray' : ''">
                    data: {{order.created_at}} <br>
                    cliente: {{order.customer.name}} {{order.customer.surname}} <br>
                    indirizzo: {{order.customer.address}}<br>
                    {{order.customer.address}} <br>
                    totale: {{order.total_price}}
                    {{order.id}}
                    <details>
                        <summary>Dettagli ordine:</summary>
                        <ul>
                            <li v-for="dish in order.dishes" :key="dish.id">
                                {{dish.dish_name}} - {{dish.pivot.amount}}
                            </li>
                        </ul>
                    </details>
                </div>
                <button v-if="order.confirmed === 0" @click="confirmed(order.id)" class="btn btn-outline-success button">conferma</button>
            </li>
        </ol>

  </section>
</template>

<script>
export default {
    data: function(){
        return{
            orders: [],
        }
    },
    mounted(){
        axios.get('/orders/list')
            .then(r => {
                this.orders = r.data;
                console.log(r.data);
                });
    },
    methods:{
        confirmed(id){
            for (let i = 0; i < this.orders.length; i++) {
                const order = this.orders[i];                
                if(order.id === id) {
                    // order.confirmed = 1;
                    axios.post('/orders/confirm', order.id)
                        .then(r =>{
                            console.log(r.data);
                            order.confirmed = 1;
                        })
                }
            }
        }
    }
}
</script>