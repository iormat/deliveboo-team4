
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
            {{totalPrice}} &euro;
        </div>

        <div class="container container-xl">
            <v-braintree
                v-if="authorization != ''" 
                :authorization="authorization"
                locale="it_IT"
                btnText="Procedi al checkout"
                @success="onSuccess"
                @error="onError"
            ></v-braintree>

        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            cart: [],

            authorization: '',

            form: {
                token: '',
                dish: '',
            },
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
            let nonce = payload.nonce;
            console.log(nonce);
        },
        onError (error) {
            // let message = error.message;
            console.error(error);
        },
    },
    // mounted() {
    //     if (sessionStorage.getItem('cart')) {
    //         try {
    //             this.cart = JSON.parse(sessionStorage.getItem('cart'));
    //         } catch(e) {
    //             sessionStorage.removeItem('cart');
    //         }
    //     }
    // },
    async mounted() {
        if (sessionStorage.getItem('cart')) {
            try {
                this.cart = JSON.parse(sessionStorage.getItem('cart'));
            } catch(e) {
                sessionStorage.removeItem('cart');
            }
        }
        const response = await axios.get('/orders/generate')
        this.authorization = response.data.token;
        // return {tokenApi: this.authorization.type}

    }
}
</script>
