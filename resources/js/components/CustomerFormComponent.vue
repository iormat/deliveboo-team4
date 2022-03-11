
<template>
     <div class="loginRegister" >
        
         <form
         v-if="showForm"
         method="POST" 
         enctype="multipart/form-data" 
         @submit.prevent="infoCustomer">

            <label for="name">Name
                <input type="text" name="name" min="2" max="60" v-model="name"  required>
            </label>
            <br>
            <label for="surname">Cognome
                <input type="text" name="surname" min="2" max="60" v-model="surname"  required>
            </label>
            <br>
            <label for="email">Email
                <input type="email" name="email" min="2" max="60" v-model="email"  required>
            </label>
            <br>
            <label for="address">Address
                <input type="text" name="address" min="5" max="60" v-model="address"  required>
            </label>
            <br>
            <label for="cap">CAP             
                <input type="text" name="cap" min="5" max="5" v-model="cap"  required>
            </label>
            <br>
            <label for="telephone">Telefono
                <input type="text" name="telephone" max="20" v-model="telephone"  required>
            </label>
            <br>
            <label for="note">
                <textarea name="note" id="" cols="30" rows="5" max="255" v-model="note"></textarea>
            </label>
            <br>
            <input type="submit" value="Procedi al pagamento">
         </form>

    </div>

</template>

<script>
export default {
    props:{
        paymetnConfirmation: Number
    },
    data: function() {
        return {
            // errors: [],

            customerForm: {
                name: "",
                surname: "",
                email: "",
                address: "",
                note: "",
                cap: "",
                telephone: "",
            },

            name: "",
            surname: "",
            email: "",
            address: "",
            note: "",
            cap: "",
            telephone: "",
            showForm: true,
            showPayment: false,


            dishesId: [],
            cart: [],
        }
    },

 mounted() {
    if(sessionStorage.getItem('customerData')) {
        const storageCustomerData = JSON.parse(sessionStorage.getItem('customerData'));
        this.name = storageCustomerData.name;
        this.surname = storageCustomerData.surname;
        this.email = storageCustomerData.email;
        this.address = storageCustomerData.address;
        this.note = storageCustomerData.note;
        this.cap = storageCustomerData.cap;
        this.telephone = storageCustomerData.telephone;
    }

    if (sessionStorage.getItem('cart')) {
        try {
            this.cart = JSON.parse(sessionStorage.getItem('cart'));
        } catch(e) {
            sessionStorage.removeItem('cart');
        }
    }    

    console.log("cart", this.cart);
},

    methods: {
        infoCustomer() {
            this.showForm = false;

            this.customerForm.name = this.name;
            this.customerForm.surname = this.surname;
            this.customerForm.email = this.email;
            this.customerForm.address = this.address;
            this.customerForm.note = this.note;
            this.customerForm.cap = this.cap;
            this.customerForm.telephone = this.telephone;

            const parsed = JSON.stringify(this.customerForm);
            sessionStorage.setItem('customerData', parsed);

            this.cart.forEach(dish => {
                console.log("dish",dish.id);
                this.dishesId.push(dish.id);
            });
            console.log("ids", this.dishesId);

            this.$emit("getDishesId", this.dishesId);
            this.$emit("showForm");
            this.$emit("showPayment");
            this.$emit("getCustomerData", this.customerForm);
        },
    }
        
}
</script>
