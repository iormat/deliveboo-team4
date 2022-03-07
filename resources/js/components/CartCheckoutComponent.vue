
<template>
     <div class="container">
        <div>
            <div>
                {{form}}
            </div>
            <ul>
                <li v-for="dish in cart" :key="dish.id">
                    {{dish.dish_name}}
                    {{dish.price}}
                    {{dish.quantity}}
                    <button @click="removeFromCart(dish)" class="btn btn-danger"> delete </button>
                    <button @click="addToCart(dish)" class="btn btn-success"> Add </button>
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
                total: '',
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
            this.form.token = nonce;
            this.form.total = this.total;
            this.buy();
        },
        onError (error) {
            // let message = error.message;
            console.error(error);
        },
        buy() {
            axios.post('/orders/make/payment', this.form)
                .then(res => {
                    sessionStorage.removeItem('cart');
                    console.log('conferma api buy: ', res)
                })
                .catch(err => {
                    console.error('errore api buy: ', err)
                })
        },

        addToCart(element) {
            const parsed = JSON.stringify(this.cart);
            if(!parsed.includes(`"id":${element.id}`)) {
                element.quantity = 1;
                this.cart.push(element)
            } else {
                for(let i=0; i<this.cart.length; i++) {
                    if(element.id === this.cart[i].id) {
                        this.cart[i].quantity++;
                        element.quantity = this.cart[i].quantity;
                        this.cart.splice(i, 1, element);
                    }
                }
            }
            // check cart
            this.cart.length > 0 ? this.shoppingCart = true : this.shoppingCart = false;
 
            this.saveCart();
        },


        removeFromCart(dish) {
            for(let i=0; i<this.cart.length; i++) {
                if(dish.id === this.cart[i].id) {
                    if(dish.quantity > 1) {
                        this.cart[i].quantity --;
                        dish.quantity = this.cart[i].quantity;
                        this.cart.splice(i, 1, dish);
                    }else {
                        this.cart.splice(i, 1);
                    }
                }
            }
            this.saveCart();
        },
        saveCart() {
            const parsed = JSON.stringify(this.cart);
            sessionStorage.setItem('cart', parsed);
        },

    },

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
