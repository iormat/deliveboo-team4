
<template>
  <section id="order-page">
      <h2>I tuoi ordini</h2>
        <ol reversed class="m-3 px-2">
            <li v-for="order, i in orders" :key="i" class="lst">
                    <div>
                        data: {{order.created_at}} <br>
                        nome: {{order.name}} surname: {{order.success}} <br>
                        indirizzo: <br>
                        {{order.address}}
                        confermato: {{order.confirmed}}
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