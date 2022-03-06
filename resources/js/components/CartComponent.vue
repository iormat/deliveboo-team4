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
        </div>
    </section>
</template>

<script>
export default {
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
            return total;
        }
    },

    methods: {
        // send dish info to parent
        removeFromCart(dish) {
            this.$emit('removeDish', dish)
        }
    }
}
</script>