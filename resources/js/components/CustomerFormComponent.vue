
<template>
     <div class="loginRegister" >
         <p class="text-order">Inserisci i dati per procedere al pagamento dell'ordine</p>
        
         <form
         v-if="showForm"
         method="POST" 
         enctype="multipart/form-data" 
         @submit.prevent="infoCustomer" class="customer-form">

            <label for="name">Name</label>
                <input type="text" name="name" min="2" max="60" v-model="name"  required>
            

            <label for="surname">Cognome</label>
                <input type="text" name="surname" min="2" max="60" v-model="surname"  required>
            

            <label for="email">Email</label>
                <input type="email" name="email" min="2" max="60" v-model="email"  required>
            

            <label for="address">Address</label>
                <input type="text" name="address" min="5" max="60" v-model="address"  required>
            

            <label for="cap">CAP</label>             
                <input type="text" name="cap" min="5" max="5" v-model="cap"  required>
            

            <label for="telephone">Telefono</label>
                <input type="text" name="telephone" max="20" v-model="telephone"  required>
            

            <label for="note"></label>
                <textarea name="note" id="" rows="5" max="255" v-model="note" class="text-area" placeholder="Note al ristorante..."></textarea>
            

            <input type="submit" value="Procedi al pagamento" class="blocktonone login-button">
            <input type="submit" value="Paga" class="nonetoblock login-button">
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
