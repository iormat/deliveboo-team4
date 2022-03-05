<template>
    <section id="cart">
        <div class="container">   
            <div>
                <ul>
                    <li v-for="dish in cart" :key="dish.id">
                        {{dish.dish_name}}
                        {{dish.price}}
                        {{dish.quantity}}
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

    }

    
}
</script>