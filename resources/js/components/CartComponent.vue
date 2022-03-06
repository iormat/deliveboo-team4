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
            total: 0
        }
    },

    props: [
        'cart'
    ], 

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
        // send dish info to parent
        removeFromCart(dish) {
            this.$emit('removeDish', dish)
        },

        checkout() {
            let totalPrice = {
                total: this.total,
            };
            axios.post('/api/cart/checkout', totalPrice)
                .then(res =>{
                    // window.location.href = "/api/cart/checkout";
                    console.log(res.data)
                })
                .catch(err => {
                    console.error(err)
                })
        }
    },
    mounted() {
        console.log('cart componente figlio: ', this.cart)
    }
}
</script>