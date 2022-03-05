<template>
    <section id="cart">
        <div class="container">   
            <div>
                <ul>
                    <li v-for="dish in cart" :key="dish.id">
                        {{dish.dish_name}}
                        {{dish.price}}
                        {{dish.quantity}}
                        <button @click="removeFromCart(dish)"> delete </button>
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
        totalPrice() {
            let total = 0;
            for(let i = 0; i < this.cart.length; i++) {
                total += this.cart[i].price * this.cart[i].quantity;
            }
            return total;
        }
    },

    methods: {
        removeFromCart(dish) {
            console.log(dish.quantity);
            newQuantity= dish.quantity--;
            // if(dish.quantity == 0) {
                this.cart.splice(dish, 1)
            // }
            console.log(dish.quantity)
            this.$emit('removeDish', newQuantity)
        }


    }

    
}
</script>