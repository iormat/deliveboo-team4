<template>
    <section id="restaurants">
        <div class="container">
            <!-- menu list -->
            <ul class="row">
                <li class="col-sm-12 col-md-6 col-lg-4" v-for="dish in menu" :key="dish.id">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3>Nome Piatto&colon; {{dish.dish_name}}</h3>
                            <span>Id&colon; {{dish.id}}</span>
                        </div>
                        <div class="card-body">
                            <p>Descrizione piatto&colon;</p>
                            {{dish.description}}
                        </div>
                        <div class="card-footer">
                            Prezzo piatto&colon;
                            <mark>{{dish.price}} &euro;</mark>
                            <div>
                                <button class="btn btn-success my-3" @click="addToCart(dish)">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <cart-component
            v-if="shoppingCart"
            :cart="cart"
            @removeDish="removeDish"
            ></cart-component>
            <button class="btn btn-danger" @click="removeItemFromStorage">REMOVE ITEMS</button>
        </div>

    </section>
</template>

<script>
import CartComponent from './CartComponent.vue';
export default {
     components: { 
        'cart-component' : CartComponent
    },
    data: function() {
        return {
            menu: [],
            cart:[],

            shoppingCart: false,
        }
    },

    props: [
        'user'
    ],

    methods: {
        // add dish to cart
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
        // remove dish from cart
        removeDish(dish) {
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
            // check cart
            this.cart.length > 0 ? this.shoppingCart = true : this.shoppingCart = false;

            this.saveCart();
        },

        saveCart() {
            const parsed = JSON.stringify(this.cart);
            sessionStorage.setItem('cart', parsed);
        },

        removeItemFromStorage() {
            sessionStorage.removeItem('cart');
        }

    },
   
    mounted() {
        axios.get(`/api/get/restaurant/menu/${this.user.id}`)
            .then(res => {
                this.menu = res.data;
            })
            .catch(err => {
                console.error(err);
            })
        
        // Getting Cart from LOCALSTORAGE
         if (sessionStorage.getItem('cart')) {
            try {
                this.cart = JSON.parse(sessionStorage.getItem('cart'));
            } catch(e) {
                sessionStorage.removeItem('cart');
            }
        }
        // check cart
        this.cart.length > 0 ? this.shoppingCart = true : this.shoppingCart = false;

    }, 
}
</script>