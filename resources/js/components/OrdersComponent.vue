
<template>
  <section id="order-page">
      <h2>I tuoi ordini</h2>
      <div class="container">
        <ol>
            <li v-for="order in orders" :key="order.id" class="mycard mb-3 m-0">
                <div class="container-card col-sm-10">
                    <div class="card-body" :class="order.confirmed == 1 ? 'itemGray' : ''">
                        <div class="order-info">
                            <span> Data: {{format(order.created_at)}}</span>
                            <h3> Cliente: {{order.customer.name}} {{order.customer.surname}}</h3>
                            <p> Totale Ordine: {{order.total_price}} &euro;</p>
                        </div>
                        <!-- order details -->
                        <details>
                            <summary>Dettagli ordine:</summary>
                            <ul>
                                <li v-for="dish in order.dishes" :key="dish.id">
                                    <p>
                                        <strong>{{dish.dish_name}}</strong> - Quantit&agrave;&colon; {{dish.pivot.amount}}
                                    </p>
                                </li>
                                <!-- client details -->
                                <li>
                                    <details>
                                        <summary>
                                            Dettagli cliente:
                                        </summary>
                                        <p><strong>Email&colon;</strong> {{order.customer.email}}</p>
                                        <p><strong>Indirizzo&colon;</strong> {{order.customer.address}}</p>
                                        <p><strong>Cap&colon;</strong> {{order.customer.cap}}</p>
                                        <p><strong>Telefono&colon;</strong> {{order.customer.telephone}}</p>
                                    </details>
                                </li>
                            </ul>
                        </details>
                    </div>
                    <div class="mod-container col-sm-2">
                        <div class="modifiers" v-if="order.confirmed === 0" @click="confirmed(order.id)">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                </div>
            </li>
        </ol>
      </div>
  </section>
</template>

<script>
import { format, formatDistance, formatRelative, subDays } from 'date-fns'

// format(new Date(2014, 1, 11), 'MM/dd/yyyy')
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
        },
        format(date){
            return format(new Date(date), "dd/MM/yyyy  HH:MM")
        }
    }
}
</script>