<template>
    <header>
        <div class="header-nav">
            <h1>DeliverBoo</h1>
            <input type="checkbox" id="nav-toggle" class="nav-toggle">
            <nav class="nav-nav">
                <ul class="ul-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Contact us</a></li>
                    <li><a href="#">Restaurant</a></li>
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
        <div id="home-jumbo">
            <img src="/storage/assets/pexels-ray-piedra-1565982.jpg" alt="header jumbo">
        </div>
    </header>
</template>

<script>
export default {
    props: {
        user: String,
    },
    methods: {
        userLogout() {
            axios.get('/logout')
                .then(res => {
                    window.location.href = '/';
                });
        },
        loginRegister() {
            window.location.href = '/login';
        }
    }
}
</script>