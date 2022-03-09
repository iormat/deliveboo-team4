<header class="container-fluid dash-cont">
    <nav class="dash-nav">
        <div class="container"><h1 class="auth">ciao {{Auth::user() -> name}}</h1>
            <ul class="nav-links">

                <li class="li-text"><a href="#">Home</a></li>
                <li><a href="#"><i class="fas fa-home-lg icons"></i></a></li>
                <li class="li-text"><a href="#">Your Orders</a></li>
                <li><a href="#"><i class="fas fa-truck icons"></i></a></li>
                <li class="li-text"><a href="#">Your Statistics</a></li>
                <li><a href="#"><i class="fas fa-chart-line icons"></i></a></li>
                <li class="li-text"><a href="#">Your Menu</a></li>
                <li><a href="#"><i class="fas fa-utensils icons"></i></a></li>
                
                
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        
        </div>
        
    </nav>
    <div class="logout">
        <h4 class="logout-text"><a href="#">LOGOUT</a></h4>
        <i class="fas fa-sign-out-alt icons"></i>
    </div>
</header>