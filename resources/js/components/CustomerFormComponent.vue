
<template>
     <div class="container" >
        
         <form
         v-if="showForm"
         method="POST" 
         enctype="multipart/form-data" 
         @submit.prevent="infoCustomer">
            
            <!-- <p v-if="errors.length">
                <b>Please correct the following error(s):</b>
                <ul>
                <li v-for="error in errors" :key="error">{{ error }}</li>
                </ul>
            </p> -->
            <!-- name, surname, address, note, cap, telephone -->

            <label for="name">Name
                <input type="text" name="name" min="2" max="60" v-model="name"  required>
            </label>
            <br>
            <label for="surname">Cognome
                <input type="text" name="surname" min="2" max="60" v-model="surname"  required>
            </label>
            <br>
            <label for="address">Address
                <input type="text" name="address" min="5" max="60" v-model="address"  required>
            </label>
            <br>
            <label for="note">
                <textarea name="note" id="" cols="30" rows="10" max="255" v-model="note"  required></textarea>
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
            <input type="submit" value="Procedi al pagamento">
         </form>

    </div>

</template>

<script>
export default {
    data: function() {
        return {
            // errors: [],

            customerForm: {
                name: "",
                surname: "",
                address: "",
                note: "",
                cap: "",
                telephone: "",
            },

            name: "",
            surname: "",
            address: "",
            note: "",
            cap: "",
            telephone: "",
            showForm: true,
            showPayment: false,
        }
    },

 mounted() {
    const storageCustomerData = JSON.parse(sessionStorage.getItem('customerData'));
    this.name = storageCustomerData.name;
    this.surname = storageCustomerData.surname;
    this.address = storageCustomerData.address;
    this.note = storageCustomerData.note;
    this.cap = storageCustomerData.cap;
    this.telephone = storageCustomerData.telephone;
},

    methods: {
        infoCustomer() {
            this.showForm = false;

            this.customerForm.name = this.name;
            this.customerForm.surname = this.surname;
            this.customerForm.address = this.address;
            this.customerForm.note = this.note;
            this.customerForm.cap = this.cap;
            this.customerForm.telephone = this.telephone;

            const parsed = JSON.stringify(this.customerForm);
            sessionStorage.setItem('customerData', parsed);

            this.$emit("showForm");
            this.$emit("showPayment");
            this.$emit("getCustomerData", this.customerForm);
        },
    }
        
}
</script>
