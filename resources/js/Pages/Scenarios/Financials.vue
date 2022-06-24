<template>
	<div>

		<ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row ml-2">
	        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center cursor-pointer">
	          <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal" v-on:click="toggleTabs(1)" v-bind:class="{'text-stone-600 bg-white': openTab !== 1, 'text-white bg-teal-600': openTab === 1}">
	            Factor
	          </a>
	        </li>
	        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center cursor-pointer">
	          <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal" v-on:click="toggleTabs(2)" v-bind:class="{'text-stone-600 bg-white': openTab !== 2, 'text-white bg-teal-600': openTab === 2}">
	            Financials
	          </a>
	        </li>
	        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center cursor-pointer">
	          <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal" v-on:click="toggleTabs(3)" v-bind:class="{'text-stone-600 bg-white': openTab !== 3, 'text-white bg-teal-600': openTab === 3}">
	            Charts
	          </a>
	        </li>
	    </ul>
		<div class="">

        <div class="px-4 py-5 flex-auto">
          <div class="tab-content tab-space">
	            <div v-bind:class="{'hidden': openTab !== 1, 'block': openTab === 1}">
	                <div class=" bg-custom-cfn text-white pb-6 pt-4">
						<p class="text-3xl text-center pb-4">CASHFLOWNAV FACTOR</p>
						<div class="grid grid-cols-4 gap-4">
							<div></div>
							<div id="factorLastYear" class="w-32 ml-20 border-4 custom-border-teal p-5 rounded-none">
								<p class="text-l text-center">Last Year</p>
								<p class="text-3xl text-center">{{parseInt(form.start.operatingCashflowFactor)}}</p>
							</div>
							<div id="factorLastYear" class="w-32 ml-4 border-4 custom-border-teal p-5 rounded-none">
								<p class="text-l text-center">Next Year</p>
								<p class="text-3xl text-center">{{parseInt(form.end.operatingCashflowFactor)}}</p>
							</div>
							<div></div>
						</div>
					</div>
					<div class="mt-32">
						<p class="text-2xl text-center">Next Year</p>
						<div class="grid grid-cols-3 gap-3">
							<div>
							</div>
							<div class="">
								<div class="grid grid-cols-3 gap-3">
								<p @click.prevent="toggleFactor('decrement')" class="cursor-pointer h-12 w-1 text-white text-center bg-custom-cfn text-3xl mt-16 pt-0 pl-4 pb-6 pr-7 border-2 rounded-xl">-</p>
								<p id="nextYearFactor" class="rounded-full pt-4 h-32 w-32 border-4 border-red-500 m-4 ml-6 text-8xl text-center">{{parseInt(this.form.forecast.operatingCashflowFactor)}}</p>
								<p @click.prevent="toggleFactor('increment')" class="cursor-pointer h-12 w-1 text-white text-center bg-custom-cfn ml-6 text-3xl mt-16 pt-0 pl-3 pb-6 pr-7 border-2 rounded-xl">+</p>
							</div>
						</div>
						</div>
					</div>
	            </div>
            <div v-bind:class="{'hidden': openTab !== 2, 'block': openTab === 2}">
              <p>
                <div class=" bg-custom-cfn text-white pt-4">
					<div class="grid grid-cols-7 gap-7">
						<p class="text-1xl text-left pl-2 pb-8">Profit & Loss</p>

						<div class="w-32 -mt-8 text-center ml-7">
							<div class="h-18 bg-teal-600 hero pt-1 text-xs font-bold">
								<p>Actial<br/>{{props.start.year}}<br/>$</p>
							</div>
						</div>	

						<div class="w-32 -mt-8 text-center ml-7">
							<div class="h-18 bg-teal-600 hero pt-1 text-xs font-bold">
								<p>Actial<br/>{{props.start.year}}<br/>CNF</p>
							</div>
						</div>	

						<div class="w-32 -mt-8 text-center ml-7">
							<div class="h-18 bg-teal-600 hero pt-1 text-xs font-bold">
								<p>Actial<br/>{{props.end.year}}<br/>$</p>
							</div>
						</div>	

						<div class="w-32 -mt-8 text-center ml-7">
							<div class="h-18 bg-teal-600 hero pt-1 text-xs font-bold">
								<p>Actial<br/>{{props.end.year}}<br/>CNF</p>
							</div>
						</div>	

						<div class="w-32 -mt-8 text-center ml-7">
							<div class="h-18 bg-teal-600 hero pt-1 text-xs font-bold">
								<p>Budget<br/>{{(parseInt(props.end.year) + 1)}}<br/>$</p>
							</div>
						</div>

						<div class="w-32 -mt-8 text-center ml-7">
							<div class="h-18 bg-teal-600 hero pt-1 text-xs font-bold">
								<p>Budget<br/>{{(parseInt(props.end.year) + 1)}}<br/>CNF</p>
							</div>
						</div>	
					</div>
				</div>
				<div class="grid grid-cols-7 ">
					<p class="text-xl text-left pl-1 pt-2 pb-4 pt-6">Income</p>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.start.income" class="p-4 w-full lg:w-full" placeholder="Income" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.start.incomeFactor" class="p-4 w-full lg:w-full" placeholder="Income" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.end.income" class="p-4 w-full lg:w-full" placeholder="Income" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.end.incomeFactor" class="p-4 w-full lg:w-full" placeholder="Income" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.forecast.income" class="p-4 w-full lg:w-full" placeholder="Income" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.forecast.incomeFactor" class="p-4 w-full lg:w-full" placeholder="Income" readonly /> 
					</div>
				</div>

				<div class="grid grid-cols-7 ">
					<p class="text-xl text-left pl-1 pt-2 pb-4 pt-6">Cost of Goods Sold</p>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.start.cogs" class="p-4 w-full lg:w-full" placeholder="COGS" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.start.cogsFactor" class="p-4 w-full lg:w-full" placeholder="COGS" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.end.cogs" class="p-4 w-full lg:w-full" placeholder="COGS" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.end.cogsFactor" class="p-4 w-full lg:w-full" placeholder="COGS" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.forecast.cogs" class="p-4 w-full lg:w-full" placeholder="COGS" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.forecast.cogsFactor" class="p-4 w-full lg:w-full" placeholder="COGS" readonly /> 
					</div>
				</div>

				<div class="grid grid-cols-7 ">
					<p class="text-xl text-left pl-1 pt-2 pb-4 pt-6">Gross Profit</p>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.start.grossProfit" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.start.grossProfitFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.end.grossProfit" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.end.grossProfitFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.forecast.grossProfit" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.forecast.grossProfitFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>
				</div>

				<div class="grid grid-cols-7 ">
					<p class="text-xl text-left pl-1 pt-2 pb-4 pt-6">Adjusted Expenses</p>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.start.expenses" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.start.expensesFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.end.expenses" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.end.expensesFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.forecast.expenses" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.forecast.expensesFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>
				</div>

				<div class="grid grid-cols-7 ">
					<p class="text-xl text-left pl-1 pt-2 pb-4 pt-6">Operating Profit</p>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.start.operatingProfit" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.start.operatingProfitFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.end.operatingProfit" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.end.operatingProfitFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.forecast.operatingProfit" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.forecast.operatingProfitFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>
				</div>

				<div class=" bg-custom-cfn text-white pt-8">
					<div class="grid grid-cols-4 gap-4">
						<p class="text-1xl text-left pl-2 pb-8">Balance Sheet</p>

					</div>
				</div>

				<div class="grid grid-cols-7 ">
					<p class="text-xl text-left pl-1 pt-2 pb-4 pt-6">Receivables</p>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.start.receivables" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.start.receivablesFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.end.receivables" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.end.receivablesFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.forecast.receivables" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.forecast.receivablesFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>
				</div>

				<div class="grid grid-cols-7 ">
					<p class="text-xl text-left pl-1 pt-2 pb-4 pt-6">Inventory/WIP</p>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.start.wip" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.start.wipFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.end.wip" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.end.wipFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.forecast.wip" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.forecast.wipFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>
				</div>

				<div class="grid grid-cols-7 ">
					<p class="text-xl text-left pl-1 pt-2 pb-4 pt-6">Payables</p>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.start.payables" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.start.payablesFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.end.payables" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.end.payablesFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.forecast.payables" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.forecast.payablesFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>
				</div>

				<div class="grid grid-cols-7 ">
					<p class="text-xl text-left pl-1 pt-2 pb-4 pt-6">Working Capital</p>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.start.workingCapital" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.start.workingCapitalFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.end.workingCapital" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.end.workingCapitalFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.forecast.workingCapital" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>

					<div class="bg-teal-200">
						<num-input type="number" v-model="form.forecast.workingCapitalFactor" class="p-4 w-full lg:w-full" placeholder="" readonly /> 
					</div>
				</div>

				<div class=" bg-custom-cfn text-white pt-8">
					<div class="grid grid-cols-4 gap-4">
						<p class="text-1xl text-left pl-2 pb-8">CASHFLOWNAV</p>

					</div>
				</div>

				<div class="grid grid-cols-7 border-b-2 border-teal-600">
					<p class="text-xl text-left pl-1 pt-2 pb-4 pt-6">Working CFN</p>

					<p class="bg-teal-200 ">&nbsp;</p>

					<p class="bg-teal-200 text-2xl text-center pt-4">{{form.start.workingCashflowFactor}}</p>

					<p class="bg-teal-200 ">&nbsp;</p>

					<p class="bg-teal-200 text-2xl text-center pt-4">{{form.end.workingCashflowFactor}}</p>

					<p class="bg-teal-200 ">&nbsp;</p>

					<p class="bg-teal-200 text-2xl text-center pt-4">{{form.forecast.workingCashflowFactor}}</p>
				</div>

				<div class="grid grid-cols-7 border-b-2 border-teal-600">
					<p class="text-xl text-left pl-1 pt-2 pb-4 pt-6">Operating CFN</p>

					<p class="bg-teal-200 ">&nbsp;</p>

					<p class="bg-teal-200 text-2xl text-center pt-4">{{form.start.operatingCashflowFactor}}</p>

					<p class="bg-teal-200 ">&nbsp;</p>

					<p class="bg-teal-200 text-2xl text-center pt-4">{{form.end.operatingCashflowFactor}}</p>

					<p class="bg-teal-200 ">&nbsp;</p>

					<p class="bg-teal-200 text-2xl text-center pt-4">{{form.forecast.operatingCashflowFactor}}</p>
				</div>

				<div class="grid grid-cols-7 border-b-2 border-teal-600">
					<p class="text-xl text-left pl-1 pt-2 pb-4 pt-6">Cashflow Movement</p>

					<p class="bg-teal-200">&nbsp;</p>
					<p class="bg-teal-200">&nbsp;</p>
					<p class="bg-teal-200 text-2xl text-center pt-4">{{form.end.operatingCashflow}}</p>
					<p class="bg-teal-200">&nbsp;</p>
					<p class="bg-teal-200 text-2xl text-center pt-4">{{form.forecast.operatingCashflow}}</p>
					<p class="bg-teal-200">&nbsp;</p>
				</div>

				<div class="mt-6">
					<p class="text-2xl text-center">Next Year</p>
					<div class="grid grid-cols-3 gap-3">
						<div>
						</div>
						<div class="">
							<div class="grid grid-cols-3 gap-3">
							<p @click.prevent="toggleFactor('decrement')" class="cursor-pointer h-12 w-1 text-white text-center bg-custom-cfn text-3xl mt-16 pt-0 pl-4 pb-6 pr-7 border-2 rounded-xl">-</p>
							<p id="nextYearFactor" class="rounded-full pt-4 h-32 w-32 border-4 border-red-500 m-4 ml-6 text-8xl text-center">{{parseInt(this.form.forecast.operatingCashflowFactor)}}</p>
							<p @click.prevent="toggleFactor('increment')" class="cursor-pointer h-12 w-1 text-white text-center bg-custom-cfn ml-6 text-3xl mt-16 pt-0 pl-3 pb-6 pr-7 border-2 rounded-xl">+</p>
						</div>
					</div>
					</div>
				</div>
              </p>
            </div>
            <div v-bind:class="{'hidden': openTab !== 3, 'block': openTab === 3}">
               <div class="ml-44 w-4/6">
			    <Line 
			          :chart-options="chartOptions" :chart-data="chartData" 
			          :width="60"
			          :height="60" />
			        </div>
			        <div class="mt-8">
			      <p class="text-2xl text-center pr-12">Next Year</p>
			      <div class="grid grid-cols-3 gap-3">
			        <div>
			        </div>
			        <div class="">
			          <div class="grid grid-cols-3 gap-3">
			          <p @click.prevent="toggleFactor('decrement')" class="cursor-pointer h-12 w-1 text-white text-center bg-custom-cfn text-3xl mt-16 pt-0 pl-4 pb-6 pr-7 border-2 rounded-xl">-</p>
			          <p id="nextYearFactor" class="rounded-full pt-4 h-32 w-32 border-4 border-red-500 m-4 ml-6 text-8xl text-center">{{parseInt(this.form.forecast.operatingCashflowFactor)}}</p>
			          <p @click.prevent="toggleFactor('increment')" class="cursor-pointer h-12 w-1 text-white text-center bg-custom-cfn ml-6 text-3xl mt-16 pt-0 pl-3 pb-6 pr-7 border-2 rounded-xl">+</p>
			        </div>
			      </div>
			      </div>
			    </div>
            </div>
          </div>
        </div>
      </div> 

		
	</div>
</template>

<script type="text/javascript">
	import { Line } from 'vue-chartjs';
	import Chart from 'chart.js/auto';
	import { Head, Link } from '@inertiajs/inertia-vue3'
	import TextInput from '@/Shared/TextInput'
	import NumInput from '@/Shared/NumInput'
	export default {
		components: {
		    Line,
		    Chart,
		    Head,
		    Link,
		    TextInput, 
		    NumInput
		},
		props:{
			props:Object,
			factor: Number
		},
		data() {
    		return {
      			openTab: 2,
			     form: this.$inertia.form({
			        start:{year: "",income:0, incomeFactor: 0, cogs: 0, expenses: 0, depreciation: 0, interest:0, receivables: 0, wip: 0, payables: 0, inventory: 0, startGrossProfit: 0, adjustedExpense: 0},
			        end:{year: "", income:0, cogs: 0, expenses: 0, depreciation:  0, interest:0, receivables: 0, wip: 0, payables: 0, inventory: 0, growth: 10, startGrossProfit: 0, adjustedExpense: 0},
			        forecast:{year: "", income:0, cogs: 0, expenses: 0, depreciation:  0, interest:0, receivables: 0, wip: 0, payables: 0, inventory: 0, growth: 10, startGrossProfit: 0, adjustedExpense: 0},
			        businessData: {}
			    }),
			    operatingCashflowFactor: 0,
			    chartData: {
			        labels: [ '2021', '2022', '2023' ],
			        datasets: [ 
			          { data: [0,0,0], label: "Operating CNF" , backgroundColor: "#8e5ea2", borderColor: "#8e5ea2"}, 
			          { data: [0,0,0], label: "Operating Profit" , backgroundColor: "#3cba9f", borderColor: "#3cba9f"}, 
			          { data: [0,0,0], label: "Cashflow Movement" , backgroundColor: "#e8c3b9", borderColor: "#e8c3b9"} 
			        ]
			      },
			      chartOptions: {
			              responsive: true,
			              maintainAspectRatio: false
			      },
    		}
    	},
    	mounted(){
    		let vm = this
    		this.computeStartFinancial(this.props.start)
    		this.computeEndFinancial(this.props.end)
    		this.computeForecastFinancial(this.props.end)
    		this.operatingCashflowFactor = this.form.forecast.operatingCashflowFactor

    		this.chartData.datasets = [
		      { data: [parseInt(this.form.start.operatingCashflowFactor),parseInt(this.form.end.operatingCashflowFactor),parseInt(this.form.forecast.operatingCashflowFactor)], label: "Operating CNF" , backgroundColor: "#8e5ea2", borderColor: "#8e5ea2"}, 
		      { data: [this.form.start.operatingProfitFactor,this.form.end.operatingProfitFactor,this.form.forecast.operatingProfitFactor], label: "Operating Profit" , backgroundColor: "#3cba9f", borderColor: "#3cba9f"}, 
		      { data: [0,this.form.forecast.operatingCashflowFactor,this.form.forecast.operatingCashflowFactor], label: "Cashflow Movement" , backgroundColor: "#e8c3b9", borderColor: "#e8c3b9"} 
		    ]
    	},
    	methods:{
    		computeStartFinancial(data){
			    const adjustedExpenses = -Math.abs(
			      Math.abs(+data.expenses) + -Math.abs(+data.depreciation) + -Math.abs(+data.interest)
			    );
			    const adjustedExpensesFactorCalc = -Math.abs((adjustedExpenses / +data.income) * 100);
			    const costOfGoodsSold = -Math.abs(+data.cogs);
			    const costOfGoodsSoldFactorCalc = -Math.abs((costOfGoodsSold / +data.income) * 100);
			    const receivables = -Math.abs(+data.receivables);
			    const receivablesFactorCalc = -Math.abs((receivables / +data.income) * 100);
			    const grossProfit = +data.income + costOfGoodsSold;
			    const grossProfitFactor = (+grossProfit / +data.income) * 100;
			    const payablesFactorCalc = (+data.payables / +data.income) * 100;
			    // Combine Inventory and WIP
			    const inventory = -Math.abs(+data.inventory);
			    const inventoryFactorCalc = -Math.abs((inventory / +data.income) * 100);
			    const wip = -Math.abs(+data.wip);
			    const wipFactor = -Math.abs((wip / +data.income) * 100);
			    const inventoryWIP = -Math.abs(wip + inventory);
			    const inventoryWIPFactor = -Math.abs(wipFactor + inventoryFactorCalc);
			    const workingCapital = -Math.abs(receivables) - Math.abs(inventory) - Math.abs(wip) + +data.payables;
			    const workingCapitalFactor = (workingCapital / +data.income) * 100;
			    const workingCashflow = grossProfit + workingCapital;
			    const workingCashflowFactor = (workingCashflow / +data.income) * 100;
			    const operatingProfit = grossProfit - Math.abs(adjustedExpenses);
			    const operatingProfitFactor = (operatingProfit / +data.income) * 100;
			    const operatingCashfLow = workingCashflow - Math.abs(adjustedExpenses);
			    const operatingCashflowFactor = (operatingCashfLow / +data.income) * 100;

		      this.form.start.scenarioYear = data.year
		      this.form.start.income = +data.income
		      this.form.start.incomeFactor = 100
		      this.form.start.cogs = +costOfGoodsSold.toFixed(2)
		      this.form.start.cogsFactor =
		        +costOfGoodsSoldFactorCalc.toFixed(2) > 0 || isFinite(+costOfGoodsSoldFactorCalc.toFixed(2)) ? +costOfGoodsSoldFactorCalc.toFixed(2) : 0
		      this.form.start.grossProfit = +grossProfit.toFixed(2)
		      this.form.start.grossProfitFactor = +grossProfitFactor.toFixed(2) > 0 || isFinite(+grossProfitFactor.toFixed(2)) ? +grossProfitFactor.toFixed(2) : 0
		      this.form.start.receivables = +receivables.toFixed(2)
		      this.form.start.receivablesFactor = +receivablesFactorCalc.toFixed(2) > 0 || isFinite(+receivablesFactorCalc.toFixed(2)) ? +receivablesFactorCalc.toFixed(2) : 0
		      this.form.start.payables = +data.payables.toFixed(2)
		      this.form.start.payablesFactor = +payablesFactorCalc.toFixed(2) > 0 || isFinite(+payablesFactorCalc.toFixed(2)) ? +payablesFactorCalc.toFixed(2) : 0
		      this.form.start.wip = +inventoryWIP.toFixed(2)
		      this.form.start.wipFactor = +inventoryWIPFactor.toFixed(2) > 0 || isFinite(+inventoryWIPFactor.toFixed(2)) ? +inventoryWIPFactor.toFixed(2) : 0
		      this.form.start.workingCapital = +workingCapital.toFixed(2)
		      this.form.start.workingCapitalFactor = +workingCapitalFactor.toFixed(2) > 0 || isFinite(+workingCapitalFactor.toFixed(2)) ? +workingCapitalFactor.toFixed(2) : 0
		      this.form.start.workingCashflow = +workingCashflow.toFixed(2)
		      this.form.start.workingCashflowFactor =
		        +workingCashflowFactor.toFixed(2) > 0 || isFinite(+workingCashflowFactor.toFixed(2)) ? +workingCashflowFactor.toFixed(2) : 0
		      this.form.start.expenses = +adjustedExpenses.toFixed(2)
		      this.form.start.expensesFactor =
		        +adjustedExpensesFactorCalc.toFixed(2) > 0 || isFinite(+adjustedExpensesFactorCalc.toFixed(2)) ? +adjustedExpensesFactorCalc.toFixed(2) : 0
		      this.form.start.operatingProfit = +operatingProfit.toFixed(2)
		      this.form.start.operatingProfitFactor =
		        +operatingProfitFactor.toFixed(2) > 0 || isFinite(+operatingProfitFactor.toFixed(2)) ? +operatingProfitFactor.toFixed(2) : 0
		      this.form.start.operatingCashflow = +operatingCashfLow.toFixed(2)
		      this.form.start.operatingCashflowFactor =
		        +operatingCashflowFactor.toFixed(2) > 0 || isFinite(+operatingCashflowFactor.toFixed(2)) ? +operatingCashflowFactor.toFixed(2) : 0
	
    		},
    		computeEndFinancial(data){
			    const adjustedExpenses = -Math.abs(
			      Math.abs(+data.expenses) + -Math.abs(+data.depreciation) + -Math.abs(+data.interest)
			    );
			    const adjustedExpensesFactorCalc = -Math.abs((adjustedExpenses / +data.income) * 100);
			    const costOfGoodsSold = -Math.abs(+data.cogs);
			    const costOfGoodsSoldFactorCalc = -Math.abs((costOfGoodsSold / +data.income) * 100);
			    const receivables = -Math.abs(+data.receivables);
			    const receivablesFactorCalc = -Math.abs((receivables / +data.income) * 100);
			    const grossProfit = +data.income + costOfGoodsSold;
			    const grossProfitFactor = (+grossProfit / +data.income) * 100;
			    const payablesFactorCalc = (+data.payables / +data.income) * 100;
			    // Combine Inventory and WIP
			    const inventory = -Math.abs(+data.inventory);
			    const inventoryFactorCalc = -Math.abs((inventory / +data.income) * 100);
			    const wip = -Math.abs(+data.wip);
			    const wipFactor = -Math.abs((wip / +data.income) * 100);
			    const inventoryWIP = -Math.abs(wip + inventory);
			    const inventoryWIPFactor = -Math.abs(wipFactor + inventoryFactorCalc);
			    const workingCapital = -Math.abs(receivables) - Math.abs(inventory) - Math.abs(wip) + +data.payables;
			    const workingCapitalFactor = (workingCapital / +data.income) * 100;
			    const workingCashflow = grossProfit + workingCapital;
			    const workingCashflowFactor = (workingCashflow / +data.income) * 100;
			    const operatingProfit = grossProfit - Math.abs(adjustedExpenses);
			    const operatingProfitFactor = (operatingProfit / +data.income) * 100;
			    const operatingCashfLow = (workingCashflow - Math.abs(adjustedExpenses));
			    const operatingCashflowFactor = (operatingCashfLow / +data.income) * 100;
			    console.log(adjustedExpenses)
			    console.log(workingCashflow)
			    console.log(operatingCashfLow)
	    		this.form.end.scenarioYear = data.year
		      	this.form.end.income = +data.income
		      	this.form.end.incomeFactor = 100
		      	this.form.end.cogs = +costOfGoodsSold.toFixed(2)
		      	this.form.end.cogsFactor =
		        +costOfGoodsSoldFactorCalc.toFixed(2) > 0 || isFinite(+costOfGoodsSoldFactorCalc.toFixed(2)) ? +costOfGoodsSoldFactorCalc.toFixed(2) : 0
		      	this.form.end.grossProfit = +grossProfit.toFixed(2)
		      	this.form.end.grossProfitFactor = +grossProfitFactor.toFixed(2) > 0 || isFinite(+grossProfitFactor.toFixed(2)) ? +grossProfitFactor.toFixed(2) : 0
		      	this.form.end.receivables = +receivables.toFixed(2)
		      	this.form.end.receivablesFactor = +receivablesFactorCalc.toFixed(2) > 0 || isFinite(+receivablesFactorCalc.toFixed(2)) ? +receivablesFactorCalc.toFixed(2) : 0
		        this.form.end.payables = +data.payables.toFixed(2)
		        this.form.end.payablesFactor = +payablesFactorCalc.toFixed(2) > 0 || isFinite(+payablesFactorCalc.toFixed(2)) ? +payablesFactorCalc.toFixed(2) : 0
		        this.form.end.wip = +inventoryWIP.toFixed(2)
		        this.form.end.wipFactor = +inventoryWIPFactor.toFixed(2) > 0 || isFinite(+inventoryWIPFactor.toFixed(2)) ? +inventoryWIPFactor.toFixed(2) : 0
		        this.form.end.workingCapital = +workingCapital.toFixed(2)
		        this.form.end.workingCapitalFactor = +workingCapitalFactor > 0 || isFinite(+workingCapitalFactor.toFixed(2)) ? +workingCapitalFactor.toFixed(2) : 0
		        this.form.end.workingCashflow = +workingCashflow.toFixed(2)
		        this.form.end.workingCashflowFactor =
		        +workingCashflowFactor > 0 || isFinite(+workingCashflowFactor.toFixed(2)) ? +workingCashflowFactor.toFixed(2) : 0
		        this.form.end.expenses = +adjustedExpenses.toFixed(2)
		        this.form.end.expensesFactor =
		        +adjustedExpensesFactorCalc > 0 || isFinite(+adjustedExpensesFactorCalc.toFixed(2)) ? +adjustedExpensesFactorCalc.toFixed(2) : 0
		        this.form.end.operatingProfit = +operatingProfit.toFixed(2)
		        this.form.end.operatingProfitFactor =
		        +operatingProfitFactor > 0 || isFinite(+operatingProfitFactor.toFixed(2)) ? +operatingProfitFactor.toFixed(2) : 0
		        this.form.end.operatingCashflow = +operatingCashfLow.toFixed(2)
		        this.form.end.operatingCashflowFactor =
		        +operatingCashflowFactor > 0 || isFinite(+operatingCashflowFactor.toFixed(2)) ? +operatingCashflowFactor.toFixed(2) : 0
			},
    		computeForecastFinancial(data){
    			const growth = 1 + +data.growth / 100;
			    const interest = +data.interest * growth;
			    const depreciation = +data.depreciation * growth;
			    const income = +data.income * growth;
			    const incomeFactor = 100;
			    const expenses = +data.expenses * growth;
			    const adjustedExpenses = -Math.abs(Math.abs(expenses) - Math.abs(+depreciation) - Math.abs(+interest));
			    const adjustedExpensesFactorCalc = -Math.abs((adjustedExpenses / income) * 100);
			    const costOfGoodsSold = -Math.abs(+data.cogs * growth);
			    const costOfGoodsSoldFactorCalc = -Math.abs((costOfGoodsSold / income) * 100);
			    const receivables = -Math.abs(+data.receivables * growth);
			    const receivablesFactorCalc = -Math.abs((receivables / income) * 100);
			    const grossProfit = income + -Math.abs(costOfGoodsSold);
			    const grossProfitFactor = (grossProfit / income) * 100;
			    const inventory = -Math.abs(+data.inventory * growth);
			    const inventoryFactorCalc = -Math.abs((inventory / income) * 100);
			    const wip = -Math.abs(+data.wip * growth);
			    const wipFactor = -Math.abs((wip / income) * 100);
			    const payables = +data.payables * growth;
			    const payablesFactorCalc = (payables / income) * 100;
			    const workingCapital = -Math.abs(receivables) - Math.abs(inventory) - Math.abs(wip) + payables;
			    const workingCapitalFactor = (workingCapital / income) * 100;
			    const workingCashflow = grossProfit + workingCapital;
			    const workingCashflowFactor = (workingCashflow / income) * 100;
			    const operatingProfit = grossProfit - Math.abs(adjustedExpenses);
			    const operatingProfitFactor = (operatingProfit / income) * 100;
			    const operatingCashfLow = workingCashflow - Math.abs(adjustedExpenses);
			    const operatingCashflowFactor = (operatingCashfLow / income) * 100;
			    // Combine Inventory and WIP
			    const inventoryWIP = -Math.abs(wip + inventory);
			    const inventoryWIPFactor = -Math.abs(wipFactor + inventoryFactorCalc);
			    this.form.forecast.scenarioYear = (+data.year + 1).toString()
				this.form.forecast.income = +income
				this.form.forecast.incomeFactor = +incomeFactor
				this.form.forecast.cogs = +costOfGoodsSold.toFixed(2)
				this.form.forecast.cogsFactor =
				+costOfGoodsSoldFactorCalc.toFixed(2) > 0 || isFinite(+costOfGoodsSoldFactorCalc.toFixed(2)) ? +costOfGoodsSoldFactorCalc.toFixed(2) : 0
				this.form.forecast.grossProfit = +grossProfit.toFixed(2)
				this.form.forecast.grossProfitFactor = +grossProfitFactor.toFixed(2) > 0 || isFinite(+grossProfitFactor.toFixed(2)) ? +grossProfitFactor.toFixed(2) : 0
				this.form.forecast.receivables = +receivables.toFixed(2)
				this.form.forecast.receivablesFactor = +receivablesFactorCalc.toFixed(2) > 0 || isFinite(+receivablesFactorCalc.toFixed(2)) ? +receivablesFactorCalc.toFixed(2) : 0
				this.form.forecast.payables = +payables.toFixed(2)
				this.form.forecast.payablesFactor = +payablesFactorCalc.toFixed(2) > 0 || isFinite(+payablesFactorCalc.toFixed(2)) ? +payablesFactorCalc.toFixed(2) : 0
				this.form.forecast.workingCapital = +workingCapital.toFixed(2)
				this.form.forecast.workingCapitalFactor = +workingCapitalFactor.toFixed(2) > 0 || isFinite(+workingCapitalFactor.toFixed(2)) ? +workingCapitalFactor.toFixed(2) : 0
				this.form.forecast.workingCashflow = +workingCashflow.toFixed(2)
				this.form.forecast.workingCashflowFactor =
				+workingCashflowFactor.toFixed(2) > 0 || isFinite(+workingCashflowFactor.toFixed(2)) ? +workingCashflowFactor.toFixed(2) : 0
				this.form.forecast.expenses = +adjustedExpenses.toFixed(2)
				this.form.forecast.expensesFactor =
				+adjustedExpensesFactorCalc.toFixed(2) > 0 || isFinite(+adjustedExpensesFactorCalc.toFixed(2)) ? +adjustedExpensesFactorCalc.toFixed(2) : 0
				this.form.forecast.operatingProfit = +operatingProfit.toFixed(2)
				this.form.forecast.operatingProfitFactor =
				+operatingProfitFactor.toFixed(2) > 0 || isFinite(+operatingProfitFactor.toFixed(2)) ? +operatingProfitFactor.toFixed(2) : 0
				this.form.forecast.operatingCashflow = +operatingCashfLow.toFixed(2)
				this.form.forecast.operatingCashflowFactor =
				+Math.round(parseFloat(operatingCashflowFactor)) > 0 || isFinite(+Math.round(parseFloat(operatingCashflowFactor))) ? +Math.round(parseFloat(operatingCashflowFactor)) : 0
				this.form.forecast.wip = inventoryWIP.toFixed(2)
				this.form.forecast.wipFactor = inventoryWIPFactor.toFixed(2) > 0 || isFinite(inventoryWIPFactor.toFixed(2)) ? inventoryWIPFactor.toFixed(2) : 0
    		},
    		toggleFactor(type){
    			if(type == 'increment'){
    				this.form.forecast.operatingCashflowFactor += 1;
    			}else{
    				this.form.forecast.operatingCashflowFactor -= 1;
    			}

    			this.chartData.datasets = [
			      { data: [parseInt(this.form.start.operatingCashflowFactor),parseInt(this.form.end.operatingCashflowFactor),parseInt(this.form.forecast.operatingCashflowFactor)], label: "Operating CNF" , backgroundColor: "#8e5ea2", borderColor: "#8e5ea2"}, 
			      { data: [this.form.start.operatingProfitFactor,this.form.end.operatingProfitFactor,this.form.forecast.operatingProfitFactor], label: "Operating Profit" , backgroundColor: "#3cba9f", borderColor: "#3cba9f"}, 
			      { data: [0,this.form.forecast.operatingCashflowFactor,this.form.forecast.operatingCashflowFactor], label: "Cashflow Movement" , backgroundColor: "#e8c3b9", borderColor: "#e8c3b9"} 
			    ]

    			this.computeFactorMovement(parseInt(this.form.forecast.operatingCashflowFactor))


    		},
    		computeFactorMovement(factorMovement){
    			const income = +this.form.start.income;
	          const incomeFactor = 100;
	          const factorTotal =
	            (+this.form.start.cogs +
	            +this.form.start.receivablesFactor +
	            +this.form.start.wipFactor +
	            +this.form.start.payablesFactor +
	            +this.form.start.expensesFactor);

	          const costOfGoodsSoldFactor =
	            +this.form.start.costOfGoodsSoldFactor + (+this.form.start.cogsFactor / factorTotal) * factorMovement;
	          const costOfGoodsSold = (costOfGoodsSoldFactor * +this.form.start.income) / 100;
	          const receivablesFactor = +this.form.start.receivablesFactor + (+this.form.start.receivablesFactor / factorTotal) * factorMovement;
	          const receivables = (receivablesFactor * +this.form.start.income) / 100;
	          const wipFactor = +this.form.start.wipFactor + (+this.form.start.wipFactor / factorTotal) * factorMovement;
	          const inventoryWIP = (wipFactor * +this.form.start.income) / 100;
	          const payablesFactor = +this.form.start.payablesFactor + (+this.form.start.payablesFactor / factorTotal) * factorMovement;
	          const payables = (payablesFactor * +this.form.start.income) / 100;
	          const expensesFactor = +this.form.start.expensesFactor + (+this.form.start.expensesFactor / factorTotal) * factorMovement;
	          const expenses = (expensesFactor * +this.form.start.income) / 100;
	          const grossProfit = +this.form.start.income + costOfGoodsSold;
	          const grossProfitFactor = (+grossProfit / +this.form.start.income) * 100;
	          const workingCapital = receivables + inventoryWIP + payables;
	          const workingCapitalFactor = (workingCapital / +this.form.start.income) * 100;
	          const workingCashflow = grossProfit + workingCapital;
	          const workingCashflowFactor = (workingCashflow / +this.form.start.income) * 100;
	          const operatingProfit = grossProfit + expenses;
	          const operatingProfitFactor = (operatingProfit / +this.form.start.income) * 100;
	          const operatingCashflow = workingCashflow + expenses;
	          const operatingCashflowFactor = (operatingCashflow / +this.form.start.income) * 100;

			    this.form.start.income = Math.round(income)
				this.form.start.incomeFactor = incomeFactor
				this.form.start.expenses = expensesFactor > 0 || isFinite(expensesFactor) ? Math.round(expenses) : 0
				this.form.start.expensesFactor = expensesFactor > 0 || isFinite(expensesFactor) ? expensesFactor : 0
				this.form.start.cogs = costOfGoodsSoldFactor > 0 || isFinite(costOfGoodsSoldFactor) ? Math.round(costOfGoodsSold) : 0
				this.form.start.cogsFactor = costOfGoodsSoldFactor > 0 || isFinite(costOfGoodsSoldFactor) ? costOfGoodsSoldFactor : 0
				this.form.start.receivables = receivablesFactor > 0 || isFinite(receivablesFactor) ? Math.round(receivables) : 0
				this.form.start.receivablesFactor = receivablesFactor > 0 || isFinite(receivablesFactor) ? receivablesFactor : 0
				this.form.start.grossProfit = grossProfitFactor > 0 || isFinite(grossProfitFactor) ? Math.round(grossProfit) : 0
				this.form.start.grossProfitFactor = grossProfitFactor > 0 || isFinite(grossProfitFactor) ? grossProfitFactor : 0
				this.form.start.inventoryWIP = wipFactor > 0 || isFinite(wipFactor) ? Math.round(inventoryWIP) : 0
				this.form.start.wipFactor = wipFactor > 0 || isFinite(wipFactor) ? wipFactor : 0
				this.form.start.payables = payablesFactor > 0 || isFinite(payablesFactor) ? Math.round(payables) : 0
				this.form.start.payablesFactor = payablesFactor > 0 || isFinite(payablesFactor) ? payablesFactor : 0
				this.form.start.workingCapital = workingCapitalFactor > 0 || isFinite(workingCapitalFactor) ? Math.round(workingCapital) : 0
				this.form.start.workingCapitalFactor = workingCapitalFactor > 0 || isFinite(workingCapitalFactor) ? workingCapitalFactor : 0
				this.form.start.workingCashflow = workingCashflowFactor > 0 || isFinite(workingCashflowFactor) ? Math.round(workingCashflow) : 0
				this.form.start.workingCashflowFactor = workingCashflowFactor > 0 || isFinite(workingCashflowFactor) ? workingCashflowFactor : 0
				this.form.start.operatingProfit = operatingProfitFactor > 0 || isFinite(operatingProfitFactor) ? Math.round(operatingProfit) : 0
				this.form.start.operatingProfitFactor = operatingProfitFactor.toFixed(2) > 0 || isFinite(operatingProfitFactor) ? operatingProfitFactor : 0
				this.form.start.operatingCashflow =
				  operatingCashflowFactor.toFixed(2) > 0 || isFinite(operatingCashflowFactor.toFixed(2)) ? Math.round(operatingCashflow.toFixed(2)) : 0
				this.form.start.operatingCashflowFactor =
				  operatingCashflowFactor.toFixed(2) > 0 || isFinite(operatingCashflowFactor)
				    ? Number(operatingCashflowFactor.toFixed(2))
				    : 0
    		},
		    toggleTabs: function(tabNumber){
		      this.openTab = tabNumber
		    },
    	}
	}
</script>

<style type="text/css">
	#nextYearFactor{
		position: relative !important;right: 51px !important;
	}

	.custom-border-teal{
		border-color: rgb(13 148 136);
	}
	.hero {
	    position:relative;
	    height:50px !important;
	    width:8.4rem !important;
	}

	.hero:after {
	    content:'';
	    position: absolute;
	    top: 100%;
	    left: 50%;
	    margin-left: -70px;
	    width: 0;
	    height: 0;
	    border-top: solid 25px #14b8a6;
	    border-left: solid 67px transparent;
	    border-right: solid 67px transparent;
	}
</style>