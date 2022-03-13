<template>
    <section id="ristoranti">
        <div class="container-details">
            
            <div class="jambo-details">
                <div class="overlay"></div>
                    <h1>nome ristorante</h1>
                    <img src="https://cdn.create.vista.com/api/media/medium/218509368/stock-photo-salad-grated-pumpkin-scrambled-eggs?token=" alt="" >  
            </div>

            <div class="restourant-container row">
                <div class="menu-container col-sm-12 col-md-9 col-lg-9">
                    <ul class="cards-container">
                        <li class="col-sm-12" v-for="dish in menu" :key="dish.id">
                            <h3>{{dish.dish_name}}</h3>
                            <div class="card_body row">
                                <p class="col-sm-12 col-md-8 col-lg-8 description-dish">
                                    <span v-if="dish.description">Descrizione piatto&colon; {{dish.description}}</span>
                                </p>
                                <div class="imgdish col-md-4 col-lg-4">
                                    <!-- <img src="https://picsum.photos/300/300" alt=""> -->
                                    <img v-if="dish.dishes_img" :src="'/storage/dishes/' + dish.dishes_img" width="100px">
                                    <p v-else>image</p>
                                </div>
                            </div>
                            <div class="card_footer">
                                Prezzo piatto&colon;
                                    <mark>{{dish.price}} &euro;</mark>
                                    <div @click="addToCart(dish)" class="add-to-cart" >
                                        <i class="fas fa-plus"></i> <span>Aggiungi al carrello</span>
                                    </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="chart-container-1 col-sm-12 col-md-3 col-lg-3">

                    <div class="chart-container">
                        <cart-component
                        v-if="shoppingCart"
                        :cart="cart"
                        @removeDish="removeDish"
                        ></cart-component>
                        <!-- <button class="btn btn-danger" @click="removeItemFromStorage">REMOVE ITEMS</button> -->
                    </div>
                </div>

            </div>
            
            <!-- <div class="d-flex flexing">
                <div class="container row p-5 cont-card">
                    <ul class="row">
                        <li class="col-sm-12" v-for="dish in menu" :key="dish.id">
                            <div class="card mb-3 details-card">
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
                </div>
                 <div class="chart-container">
                        <cart-component
                        v-if="shoppingCart"
                        :cart="cart"
                        @removeDish="removeDish"
                        ></cart-component>
                        <button class="btn btn-danger" @click="removeItemFromStorage">REMOVE ITEMS</button>
                    </div>
            </div> -->
            
            <!-- menu list -->
            
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

            if(parsed.includes(`"user_id":${element.user_id}`) || parsed === "[]") {
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
            } else {
                alert('Nel carrello sono presenti piatti di altri ristoranti!')
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
            this.cart = [];
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