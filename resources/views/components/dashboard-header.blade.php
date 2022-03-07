<header class="container-fluid">
    <nav>
        <div class="container"><h1 class="auth">ciao {{Auth::user() -> name}}</h1>
            <ul class="nav-links">

                <li><a href="#">Home</a></li>
                <li><a href="#">Your Orders</a></li>
                <li><a href="#">Your Menu</a></li>
                
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        
        </div>
        
    </nav>
    <div class="logout">
        <h4><a href="#">LOGOUT</a></h4>
    </div>
</header>