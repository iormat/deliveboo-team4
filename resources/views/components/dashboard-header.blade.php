<header class="container-fluid" id="dashboard-header">
    <nav class="dash-nav">
        <div class="container"><h1 class="auth">Ciao {{Auth::user() -> name}}</h1>
            <ul class="nav-links">

                <li class="li-text"><a href="{{route('home')}}">Home</a></li>
                <li><a href="{{route('home')}}">
                    <i class="fas fa-home icons"></i>
                </a></li>

                <li class="li-text"><a href="{{route('orders')}}">I tuoi Ordini</a></li>
                <li><a href="{{route('orders')}}">
                    <i class="fas fa-truck icons"></i>
                </a></li>

                <li class="li-text"><a href="{{route('statistics')}}">Statistiche</a></li>
                <li><a href="{{route('statistics')}}">
                    <i class="fas fa-chart-line icons"></i>
                </a></li>
                <li class="li-text"><a href="{{route('dashboard')}}">Il tuo menu</a></li>
                <li><a href="{{route('dashboard')}}">
                    <i class="fas fa-utensils icons"></i>
                </a></li>                
                
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        
        </div>
        
    </nav>
    <div class="logout">
        <h4 class="logout-text"><a href="{{route('logout')}}">LOGOUT</a></h4>
        <i class="fas fa-sign-out-alt icons"></i>
    </div>
</header>