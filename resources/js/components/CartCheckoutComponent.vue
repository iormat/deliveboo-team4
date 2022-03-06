
<template>
     <div class="container">
        <div>
            <ul>
                <li v-for="dish in cart" :key="dish.id">
                    {{dish.dish_name}}
                    {{dish.price}}
                    {{dish.quantity}}
                    <!-- <button @click="removeFromCart(dish)" class="btn btn-danger"> delete </button> -->
                </li>
            </ul>
            {{totalPrice}}
        </div>

        <div>
            <button class="btn btn-success">Procedi all'ordine</button>
            {{tokenApi}}
        </div>
        <v-braintree 
            authorization="authorization"
            locale="it_IT"
            @success="onSuccess"
            @error="onError"
        ></v-braintree>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            cart: [],

            tokenApi: 'fddfgfg',
        }
    },
    props: {
        authorization: {
            // required: true,
            // type: String,
        }
    }, 

    computed: {
        // get total price of cart items
        totalPrice() {
            let total = 0;
            for(let i = 0; i < this.cart.length; i++) {
                total += this.cart[i].price * this.cart[i].quantity;
            }
            return this.total = total;
        }
    },
    methods: {
        onSuccess (payload) {
            // let nonce = payload.nonce;
            console.log(payload);
        },
        onError (error) {
            // let message = error.message;
            console.log(error);
        },

    },
    mounted() {
        if (sessionStorage.getItem('cart')) {
            try {
                this.cart = JSON.parse(sessionStorage.getItem('cart'));
            } catch(e) {
                sessionStorage.removeItem('cart');
            }
        }
    },
    async mounted() {
        this.tokenApi = 'caio';
        await axios.get('/order/generate')
            .then(res => {
                console.log('questo è il risultato: ', res)
            })
            .catch(err => {
                console.log(err)
            })
        // tokenApi = response.token;
        // this.loadingPayment = false;
        // return {
        //     tokenApi: tokenApi,
        //     loadingPayment:  false,  
        // }
    }
}
</script>
