<script>

import { Line, mixins } from 'vue-chartjs';

const { reactiveProp } = mixins;

export default {
   extends: Line ,
   mixins: [reactiveProp],
   props: ['chartData', 'user'],
   data: () => ({
		tot2018: 0,
		tot2019: 0,
		tot2020: 0,
		tot2021: 0,
		tot2022: 0,

    
		chartdata: {},
		options: {
			responsive: true,
			maintainAspectRatio: false
		},
  }),

async mounted () {
	await axios.get('/chart/orders/year')
			.then(r=> {
				for(let i=0; i < r.data.ord2018.length; i++) {
					let month = r.data.ord2018[i];
					this.tot2018 += Number(month.total_price);
				};
				this.tot2018 = Number(this.tot2018.toFixed(2));

				for(let i=0; i < r.data.ord2019.length; i++) {
					let month = r.data.ord2019[i];
					this.tot2019 += Number(month.total_price);
				};
				this.tot2019 = Number(this.tot2019.toFixed(2));

				for(let i=0; i < r.data.ord2020.length; i++) {
					let month = r.data.ord2020[i];
					this.tot2020 += Number(month.total_price);
				};
				this.tot2020 = Number(this.tot2020.toFixed(2));

				for(let i=0; i < r.data.ord2021.length; i++) {
					let month = r.data.ord2021[i];
					this.tot2021 += Number(month.total_price);
				};
				this.tot2021 = Number(this.tot2021.toFixed(2));

                for(let i=0; i < r.data.ord2022.length; i++) {
					let month = r.data.ord2022[i];
					this.tot2022 += Number(month.total_price);
				};
				this.tot2022 = Number(this.tot2022.toFixed(2));



			})
			.catch(e=>console.error(e));

    this.fillData();
    this.renderChart(this.chartdata, this.options);
  },
	methods: {
		fillData () {
			this.chartdata = {
				labels: ['2018', '2019', '2020', '2021' ,'2022'],
				datasets: [
				{
					label: 'Totale incasso',
					backgroundColor: '#f87979',
					//dati del grafico(si possono anche annidare)
					data: [this.tot2018, this.tot2019, this.tot2020, this.tot2021, this.tot2022],
				},
			]}
		},
	}
}
</script>

