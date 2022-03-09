<script>

import { Bar, mixins } from 'vue-chartjs';

const { reactiveProp } = mixins;

export default {
   extends: Bar ,
   mixins: [reactiveProp],
   props: ['chartData', 'user'],
   data: () => ({
		ordGen: 0,
		ordFeb: 0,
		ordMar: 0,
		ordApr: 0,
		ordMag: 0,
		ordGiu: 0,
		ordLug: 0,
		ordAgo: 0,
		ordSet: 0,
		ordOtt: 0,
		ordNov: 0,
		ordDic: 0,
    
		chartdata: {},
		options: {
			responsive: true,
			maintainAspectRatio: false
		},
	
  }),

async mounted () {
	await axios.get('/chart/orders')
			.then(r=> {
				this.ordGen = r.data.ordGen.length;
				this.ordFeb = r.data.ordFeb.length;
				this.ordMar = r.data.ordMar.length;
				this.ordApr = r.data.ordApr.length;
				this.ordMag = r.data.ordMag.length;
				this.ordGiu = r.data.ordGiu.length;
				this.ordLug = r.data.ordLug.length;
				this.ordAgo = r.data.ordAgo.length;
				this.ordSet = r.data.ordSet.length;
				this.ordOtt = r.data.ordOtt.length;
				this.ordNov = r.data.ordNov.length;
				this.ordDic = r.data.ordDic.length; 			
			})
			.catch(e=>console.error(e));

    this.fillData();
    this.renderChart(this.chartdata, this.options);
  },
	methods: {
		fillData () {
			this.chartdata = {
				labels: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
				datasets: [
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