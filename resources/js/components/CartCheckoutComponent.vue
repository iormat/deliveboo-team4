
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
            {{authorization.type}}
        </div>
        <v-braintree 
            :authorization="authorization.type"
            locale="it_IT"
            @success="onSuccess"
            @error="onError"
            @load="onLoad"
        ></v-braintree>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            cart: [],

            authorization: {
                required: true,
                type: '',
            }
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
        onLoad() {
            alert('caricando');
        },

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
        const response = await axios.get('/orders/generate')
        this.authorization.type = response.data.token;
        // return {tokenApi: this.authorization.type}
    }
}
</script>
