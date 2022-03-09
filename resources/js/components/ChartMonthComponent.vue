<script>

import { Bar, mixins } from 'vue-chartjs';

const { reactiveProp } = mixins;

export default {
   extends: Bar ,
   mixins: [reactiveProp],
   props: ['chartData'],
   data: () => ({
     totGen: 5000, ordGen: 200,
     totFeb: 8340, ordFeb: 235,
     totMar: 4560, ordMar: 225,
     totApr: 3654, ordApr: 215,
     totMag: 4560, ordMag: 225,
     totGiu: 8560, ordGiu: 325,
     totLug: 5560, ordLug: 236,
     totAgo: 0,    ordAgo: 0,
     totSet: 8465, ordSet: 365,
     totOtt: 1256, ordOtt: 199,
     totNov: 6523, ordNov: 284,
     totDic: 4560, ordDic: 225,
    
    chartdata: {},
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  }),
  mounted () {
    // axios.get('/')
    //         .then(r=> {
    //         this.totGen = r.data.totGen,
    //         this.totFeb = r.data.totFeb,
    //         this.totMar = r.data.totMar,
    //         this.totApr = r.data.totApr,
    //         this.totMag = r.data.totMag,
    //         this.totGiu = r.data.totGiu,
    //         this.totLug = r.data.totLug,
    //         this.totAgo = r.data.totAgo,
    //         this.totSet = r.data.totSet,
    //         this.totNov = r.data.totNov,
    //         this.totDic = r.data.totDic
    //         }
    //         )
    //         .catch(e=>console.error(e));

    // axios.get('/')
    //         .then(r=> {
    //         this.ordGen = r.data.ordGen,
    //         this.ordFeb = r.data.ordFeb,
    //         this.ordMar = r.data.ordMar,
    //         this.ordApr = r.data.ordApr,
    //         this.ordMag = r.data.ordMag,
    //         this.ordGiu = r.data.ordGiu,
    //         this.ordLug = r.data.ordLug,
    //         this.ordAgo = r.data.ordAgo,
    //         this.ordSet = r.data.ordSet,
    //         this.ordNov = r.data.ordNov,
    //         this.ordDic = r.data.ordDic
    //         }
    //         )
    //         .catch(e=>console.error(e));
    
    this.fillData();
    this.renderChart(this.chartdata, this.options);
  },
  methods: {
    fillData () {
        this.chartdata = {
            labels: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
            datasets: [
            {
                label: 'Totale incasso',
                backgroundColor: '#f87979',
                //dati del grafico(si possono anche annidare)
                data: [this.totGen, this.totFeb, this.totMar, this.totApr, this.totMag, this.totGiu, this.totLug, this.totAgo, this.totSet, this.totOtt, this.totNov, this.totDic,]
            },
            {
                label: 'Numero ordini',
                backgroundColor: 'rgb(0, 47, 255)',
                data: [this.ordGen, this.ordFeb, this.ordMar, this.ordApr, this.ordMag, this.ordGiu, this.ordLug, this.ordAgo, this.ordSet, this.ordOtt, this.ordNov, this.ordDic,]
            }
        ]}
    },
  }
}
</script>