
<template>
     <div class="container" >
        <customer-form-component
            @showForm="showForm"
            @showPayment="showPayment"
            @getCustomerData="getCustomerData"
        >
        </customer-form-component>


         <!-- PAGAMENTO -->
        <div v-if="showP">
            <div v-if="transition === ''" >
                <div>
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
        </div>

        <div v-if="transition != ''">
            {{transition}}
            <button @click="home" class="btn btn-success">HOME</button>
        </div>

    </div>

</template>

<script>
import CustomerFormComponent from "./CustomerFormComponent.vue";

export default {
  components: { 
        'customer-form-component' : CustomerFormComponent
    },
    data: function() {
        return {
            cart: [],
            transition: "",
            authorization: '', 
            form: {
                token: '',
                total: '',
            }, 
            paymetnConfirmation: 1,
            errors: [],

            showF: "",
            showP: false,

            customerData: {},

            a: 1,

            orderInfo: {
                total_price: "",
                payment_confirmation: "",
                date: "",
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
            this.orderInfo.total_price = total; 
            return this.total = total;
        }
    },
    methods: {
        showForm() {
            this.showF = false;
        },

        showPayment() {
            this.showP = true;
        },

        getCustomerData(info) {
            this.customerData = info;
            console.log(this.customerData);
        },

        home(){
            window.location.href = "/";
        },
        onSuccess (payload) {
            let nonce = payload.nonce;
            this.form.token = nonce;
            this.form.total = this.total;
            this.buy();
        },
        onError (error) {
            // let message = error.message;
            this.paymetnConfirmation = 0;
            console.error(error);
        },
        check() {
            console.log(today);

        },

        async buy() {

            let today = new Date();
            let dd = String(today.getDate()).padStart(2, '0');
            let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            let yyyy = today.getFullYear();
            today =  yyyy + '/' +  mm + '/' + dd ;

            this.orderInfo.date = today;

            await axios.post('/orders/make/payment', this.form)
                .then(res => {
                    sessionStorage.removeItem('cart');
                    this.transition = res.data.message;

                    if(this.transition === "Transazione completata") {
                        this.orderInfo.payment_confirmation = 1;
                    } else {
                        this.orderInfo.payment_confirmation = 0;
                    }
                    console.log(this.orderInfo.payment_confirmation);

                    console.log('conferma api buy: ', res)
                })
                .catch(err => {
                    this.transition = err.data.message;
                    console.error('errore api buy: ', err)
                });

            await axios.post('/orders/customerInfo', this.customerData)
                .then(res => {
                    sessionStorage.removeItem('customerData');
                    console.log('customer data: ', res)
                })
                .catch(err => {
                    console.error('errore api customer data: ', err)
                });

             await axios.post('/orders/createOrder', this.orderInfo)
                    .then(res => {
                        console.log("order info SENZA ERRORE", this.orderInfo);
                        console.log('orderInfo: ', res)
                    })
                    .catch(err => {
                        console.error('errore api orderInfo: ', err)
                        console.log("order info ERRORE",this.orderInfo);
                    });

            
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
    },


}
</script>
