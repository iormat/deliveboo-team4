
<template>
  <div>
      <h2>I tuoi ordini</h2>
        <ul class="m-3 px-2">
            <li v-for="order in orders" :key="order.id">
                id ordine: {{order.id}} {{order.order_id}} - {{order.date}} - {{order.confirmed}}
                <button @click="confirmed(order.id)" class="btn btn-success">conferma</button>
            </li>
        </ul>

  </div>
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