<template>
    <section id="cart">
        <div class="container">   
            <div>
                <ul>
                    <li v-for="dish in cart" :key="dish.id">
                        {{dish.dish_name}}
                        {{dish.price}}
                        {{dish.quantity}}
                        <button @click="removeFromCart(dish)" class="btn btn-danger"> delete </button>
                    </li>
                </ul>
                {{totalPrice}}
            </div>
            <div>
                <button @click="checkout" class="btn btn-success">Procedi all'ordine</button>
            </div>

        </div>
    </section>
</template>

<script>
export default {
    data: function() {
        return {
            total: 0,
        }
    },
    props: {
        cart: Array
    },
    computed: {
        // get total price of cart items
        totalPrice() {
            let total = 0;
            for(let i = 0; i < this.cart.length; i++) {
                total += this.cart[i].price * this.cart[i].quantity;
            }
            return this.total = total.toFixed(2);
        }
    },

    methods: {
        onSuccess (payload) {
            let nonce = payload.nonce;
            console.log('successo ',nonce);
        // Do something great with the nonce...
        },
        onError (error) {
            let message = error.message;
            console.log('errore: ', error);
        // Whoops, an error has occured while trying to get the nonce
        },
        // send dish info to parent
        removeFromCart(dish) {
            this.$emit('removeDish', dish)
        },

        checkout() {
            window.location.href = "/api/cart/checkout";
        }
    },
}
</script>