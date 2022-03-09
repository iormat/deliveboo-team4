<script>

import { Bar, mixins } from 'vue-chartjs';

const { reactiveProp } = mixins;

export default {
   extends: Bar ,
   mixins: [reactiveProp],
   props: ['chartData', 'user'],
   data: () => ({
		ord2018: 0,
		ord2019: 0,
		ord2020: 0,
		ord2021: 0,
		ord2022: 0,
		
		chartdata: {},
		options: {
			responsive: true,
			maintainAspectRatio: false
		},
  }),

async mounted () {
	await axios.get('/chart/orders/year')
			.then(r=> {
				this.ord2018 = r.data.ord2018.length;
				this.ord2019 = r.data.ord2019.length;
				this.ord2020 = r.data.ord2020.length;
				this.ord2021 = r.data.ord2021.length;
				this.ord2022 = r.data.ord2022.length;
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
					label: 'Numero ordini',
					backgroundColor: 'rgb(0, 47, 255)',
					data: [this.ord2018, this.ord2019, this.ord2020, this.ord2021, this.ord2022]
				}
			]}
		},
	}
}
</script>

