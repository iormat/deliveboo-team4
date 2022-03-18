<template>
    <header>
        <div class="header-nav">
            <img src="/storage/assets/deliveboo-logo.png" alt="page main logo">
            <input type="checkbox" id="nav-toggle" class="nav-toggle">
            <nav class="nav-nav">
                <ul class="ul-links">
                    <li>
                        <span @click="goHome">Home</span>
                    </li>

                    <li @click="goRestaurants">
                        <span>Ristoranti</span> 
                    </li>

                    <li v-if="user">
                        <span @click="userDashboard">Dashboard</span>
                    </li>

                    <li v-if="user">
                        <span @click="userLogout">Logout</span>
                    </li>

                    <li v-else>
                        <span @click="loginRegister">Registrati/Login</span>
                    </li>
                </ul>
            </nav>
            <label for="nav-toggle" class="nav-toggle-label">
                <span></span>
            </label>    
        </div>
    </header>
</template>

<script>
export default {
    props: {
        user: String,
    },
    methods: {
        // redirect to all restaurants
        goRestaurants(){
            window.location.href = '/api/restaurants';
        },
        // redirect to user dashboard
        userDashboard(){
            window.location.href = '/dashboard';
        },
        // user logout
        userLogout() {
            axios.get('/logout')
                .then(res => {
                    window.location.href = '/';
                });
        },
        // redirect to login/registration
        loginRegister() {
            window.location.href = '/login';
        },
        // redirect to homepage
        goHome() {
            window.location.href = '/';
        }
    }
}
</script>