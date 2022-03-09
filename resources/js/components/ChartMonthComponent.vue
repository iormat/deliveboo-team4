<script>

import { Bar, mixins } from 'vue-chartjs';

const { reactiveProp } = mixins;

export default {
   extends: Bar ,
   mixins: [reactiveProp],
   props: ['chartData', 'user'],
   data: () => ({
		totGen: 0, ordGen: 0,
		totFeb: 0, ordFeb: 0,
		totMar: 0, ordMar: 0,
		totApr: 0, ordApr: 0,
		totMag: 0, ordMag: 0,
		totGiu: 0, ordGiu: 0,
		totLug: 0, ordLug: 0,
		totAgo: 0, ordAgo: 0,
		totSet: 0, ordSet: 0,
		totOtt: 0, ordOtt: 0,
		totNov: 0, ordNov: 0,
		totDic: 0, ordDic: 0,
    
		chartdata: {},
		options: {
			responsive: true,
			maintainAspectRatio: false
		},
		
		dataKeys: {},
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

				this.dataKeys = Object.keys(r.data);

				for(let i=0; i < r.data.ordGen.length; i++) {
					let month = r.data.ordGen[i];
					this.totGen += Number(month.total_price);
				};
				this.totGen = Number(this.totGen.toFixed(2));

				for(let i=0; i < r.data.ordFeb.length; i++) {
					let month = r.data.ordFeb[i];
					this.totFeb += Number(month.total_price);
				};
				this.totFeb = Number(this.totFeb.toFixed(2));

				for(let i=0; i < r.data.ordMar.length; i++) {
					let month = r.data.ordMar[i];
					this.totMar += Number(month.total_price);
				};
				this.totMar = Number(this.totMar.toFixed(2));

				for(let i=0; i < r.data.ordApr.length; i++) {
					let month = r.data.ordApr[i];
					this.totApr += Number(month.total_price);
				};
				this.totApr = Number(this.totApr.toFixed(2));

				for(let i=0; i < r.data.ordMag.length; i++) {
					let month = r.data.ordMag[i];
					this.totMag += Number(month.total_price);
				};
				this.totMag = Number(this.totMag.toFixed(2));
					
				for(let i=0; i < r.data.ordGiu.length; i++) {
					let month = r.data.ordGiu[i];
					this.totGiu += Number(month.total_price);
				};
				this.totGiu = Number(this.totGiu.toFixed(2));

				for(let i=0; i < r.data.ordLug.length; i++) {
					let month = r.data.ordLug[i];
					this.totLug += Number(month.total_price);
				};
				this.totLug = Number(this.totLug.toFixed(2));


				for(let i=0; i < r.data.ordAgo.length; i++) {
					let month = r.data.ordAgo[i];
					this.totAgo += Number(month.total_price);
				};
				this.totAgo = Number(this.totAgo.toFixed(2));


				for(let i=0; i < r.data.ordSet.length; i++) {
					let month = r.data.ordSet[i];
					this.totSet += Number(month.total_price);
				};
				this.totSet = Number(this.totSet.toFixed(2));


				for(let i=0; i < r.data.ordOtt.length; i++) {
					let month = r.data.ordOtt[i];
					this.totOtt += Number(month.total_price);
				};
				this.totOtt = Number(this.totOtt.toFixed(2));


				for(let i=0; i < r.data.ordNov.length; i++) {
					let month = r.data.ordNov[i];
					this.totNov += Number(month.total_price);
				};
        		this.totNov = Number(this.totNov.toFixed(2));

				for(let i=0; i < r.data.ordDic.length; i++) {
					let month = r.data.ordDic[i];
					this.totDic += Number(month.total_price);
				};
        		this.totDic = Number(this.totDic.toFixed(2));
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

		// getTotalPriceForEachMonth(r) {
		// 	let x = 0;

		// 	for(let i=0; i < r.data[this.dataKeys[x]].length; i++) {
		// 		let month = r.data[this.dataKeys[x]];

		// 		let replace = this.dataKeys[x].replace(/ord/, 'tot');

		// 		this[replace] += Number(month.total_price);
		// 		if(x < this.dataKeys.length) {
		// 			x++;
		// 		}
		// 	};
			// this.totMese = Number(this.totMese.toFixed(2));

		// },
	}
}
</script>