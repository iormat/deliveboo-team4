<template>
    <section id="banner">
        <div class="container">  
            <h2>Lavora con Deliveboo </h2>                    
            <div class="row">
                <div class="container-rider col-sm-12 col-md-6 ">
                    <div class="ristoranti">
                        <div class="overlay">
                            <div class="details d-flex flex-column">
                                <h3>Ristoranti</h3>
                                <p>Diventa partner di Deliveboo e raggiungi sempre più clienti. Ci occupiamo noi della consegna, così che la tua unica preoccupazione sia continuare a preparare il miglior cibo.</p>
                                <div @click="loginRegister" class="my-button">Diventa nostro parnter</div>
                            </div>   
                        </div>
                    </div>
                </div>
                <div class="container-lavora col-sm-12 col-md-6">
                    <div class="lavora-con-noi">
                        <div class="overlay">
                            <div class="details d-flex flex-column">
                                <h3>Lavora con noi</h3>
                                <p>La nostra missione è trasformare il modo in cui le persone mangiano. È un obiettivo ambizioso, come noi, e ci servono persone che ci aiutino a raggiungerlo..</p>
                                <div @click="goHome" class="my-button">Scopri di più</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>

export default {
     methods: {
       
        loginRegister() {
            window.location.href = '/login';
        },

        goHome() {
            window.location.href = '/';
        }
        
    }
}
</script>
