<template>
  <div>
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
          <p id="nextYearFactor" class="rounded-full pt-4 h-32 w-32 border-4 border-red-500 m-4 ml-6 text-8xl text-center">{{parseInt(factor)}}</p>
          <p @click.prevent="toggleFactor('increment')" class="cursor-pointer h-12 w-1 text-white text-center bg-custom-cfn ml-6 text-3xl mt-16 pt-0 pl-3 pb-6 pr-7 border-2 rounded-xl">+</p>
        </div>
      </div>
      </div>
    </div>

    {{form.forecast}}

  </div>
</template>

<script>
import { Line } from 'vue-chartjs';
import Chart from 'chart.js/auto';
export default {
  components: {
    Line,
    Chart
  },
  props:{
    props:Object,
    factor: Number
  },
  data() {
    return {
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
      form: this.$inertia.form({
        start:{year: "",income:0, incomeFactor: 0, cogs: 0, expenses: 0, depreciation: 0, interest:0, receivables: 80000, wip: 0, payables: 0, inventory: 0, startGrossProfit: 0, adjustedExpense: 0},
        end:{year: "", income:0, cogs: 0, expenses: 0, depreciation:  0, interest:0, receivables: 0, wip: 0, payables: 0, inventory: 0, growth: 10, startGrossProfit: 0, adjustedExpense: 0},
        forecast:{year: "", income:0, cogs: 0, expenses: 0, depreciation:  0, interest:0, receivables: 0, wip: 0, payables: 0, inventory: 0, growth: 10, startGrossProfit: 0, adjustedExpense: 0},
        businessData: {}
      }),
    }
  },
  mounted(){
    this.computeStartFinancial(this.props.start)
    this.computeEndFinancial(this.props.end)
    this.computeForecastFinancial(this.props.end)
    this.$emit('changeFactor', this.form.forecast.operatingCashflowFactor)
    console.log(this.form.start.operatingProfitFactor)
    this.chartData.datasets = [
      { data: [parseInt(this.form.start.operatingCashflowFactor),parseInt(this.form.end.operatingCashflowFactor),parseInt(this.form.forecast.operatingCashflowFactor)], label: "Operating CNF" , backgroundColor: "#8e5ea2", borderColor: "#8e5ea2"}, 
      { data: [this.form.start.operatingProfitFactor,this.form.end.operatingProfitFactor,this.form.forecast.operatingProfitFactor], label: "Operating Profit" , backgroundColor: "#3cba9f", borderColor: "#3cba9f"}, 
      { data: [0,this.form.forecast.operatingCashflowFactor,this.form.forecast.operatingCashflowFactor], label: "Cashflow Movement" , backgroundColor: "#e8c3b9", borderColor: "#e8c3b9"} 
    ]
  },
  methods:{
    passEvent()
    {
      console.log('clicked')
      this.$emit('changeTitle','Awesome ')
    },
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
      this.form.start.cogs = +costOfGoodsSold
      this.form.start.cogsFactor =
        +costOfGoodsSoldFactorCalc > 0 || isFinite(+costOfGoodsSoldFactorCalc.toFixed(2)) ? +costOfGoodsSoldFactorCalc : 0
      this.form.start.grossProfit = +grossProfit
      this.form.start.grossProfitFactor = +grossProfitFactor > 0 || isFinite(+grossProfitFactor) ? +grossProfitFactor : 0
      this.form.start.receivables = +receivables
      this.form.start.receivablesFactor = +receivablesFactorCalc > 0 || isFinite(+receivablesFactorCalc) ? +receivablesFactorCalc : 0
      this.form.start.payables = +data.payables
      this.form.start.payablesFactor = +payablesFactorCalc > 0 || isFinite(+payablesFactorCalc) ? +payablesFactorCalc : 0
      this.form.start.wip = +inventoryWIP
      this.form.start.wipFactor = +inventoryWIPFactor > 0 || isFinite(+inventoryWIPFactor) ? +inventoryWIPFactor : 0
      this.form.start.workingCapital = +workingCapital
      this.form.start.workingCapitalFactor = +workingCapitalFactor > 0 || isFinite(+workingCapitalFactor) ? +workingCapitalFactor : 0
      this.form.start.workingCashflow = +workingCashflow
      this.form.start.workingCashflowFactor =
        +workingCashflowFactor > 0 || isFinite(+workingCashflowFactor) ? +workingCashflowFactor : 0
      this.form.start.expenses = +adjustedExpenses
      this.form.start.expensesFactor =
        +adjustedExpensesFactorCalc > 0 || isFinite(+adjustedExpensesFactorCalc) ? +adjustedExpensesFactorCalc : 0
      this.form.start.operatingProfit = +operatingProfit
      this.form.start.operatingProfitFactor =
        +operatingProfitFactor > 0 || isFinite(+operatingProfitFactor) ? +operatingProfitFactor : 0
      this.form.start.operatingCashflow = +operatingCashfLow
      this.form.start.operatingCashflowFactor =
        +operatingCashflowFactor > 0 || isFinite(+operatingCashflowFactor) ? +operatingCashflowFactor : 0

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
      const operatingCashfLow = workingCashflow - Math.abs(adjustedExpenses);
      const operatingCashflowFactor = (operatingCashfLow / +data.income) * 100;

      this.form.end.scenarioYear = data.year
        this.form.end.income = +data.income
        this.form.end.incomeFactor = 100
        this.form.end.cogs = +costOfGoodsSold
        this.form.end.cogsFactor =
        +costOfGoodsSoldFactorCalc > 0 || isFinite(+costOfGoodsSoldFactorCalc) ? +costOfGoodsSoldFactorCalc : 0
        this.form.end.grossProfit = +grossProfit
        this.form.end.grossProfitFactor = +grossProfitFactor > 0 || isFinite(+grossProfitFactor) ? +grossProfitFactor : 0
        this.form.end.receivables = +receivables
        this.form.end.receivablesFactor = +receivablesFactorCalc > 0 || isFinite(+receivablesFactorCalc) ? +receivablesFactorCalc : 0
        this.form.end.payables = +data.payables
        this.form.end.payablesFactor = +payablesFactorCalc > 0 || isFinite(+payablesFactorCalc) ? +payablesFactorCalc : 0
        this.form.end.wip = +inventoryWIP
        this.form.end.wipFactor = +inventoryWIPFactor > 0 || isFinite(+inventoryWIPFactor) ? +inventoryWIPFactor : 0
        this.form.end.workingCapital = +workingCapital
        this.form.end.workingCapitalFactor = +workingCapitalFactor > 0 || isFinite(+workingCapitalFactor) ? +workingCapitalFactor : 0
        this.form.end.workingCashflow = +workingCashflow
        this.form.end.workingCashflowFactor =
        +workingCashflowFactor > 0 || isFinite(+workingCashflowFactor) ? +workingCashflowFactor : 0
        this.form.end.expenses = +adjustedExpenses
        this.form.end.expensesFactor =
        +adjustedExpensesFactorCalc > 0 || isFinite(+adjustedExpensesFactorCalc) ? +adjustedExpensesFactorCalc : 0
        this.form.end.operatingProfit = +operatingProfit
        this.form.end.operatingProfitFactor =
        +operatingProfitFactor > 0 || isFinite(+operatingProfitFactor) ? +operatingProfitFactor : 0
        this.form.end.operatingCashflow = +operatingCashfLow
        this.form.end.operatingCashflowFactor =
        +operatingCashflowFactor > 0 || isFinite(+operatingCashflowFactor) ? +operatingCashflowFactor : 0
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
    this.form.forecast.cogs = +costOfGoodsSold
    this.form.forecast.cogsFactor =
    +costOfGoodsSoldFactorCalc > 0 || isFinite(+costOfGoodsSoldFactorCalc) ? +costOfGoodsSoldFactorCalc : 0
    this.form.forecast.grossProfit = +grossProfit
    this.form.forecast.grossProfitFactor = +grossProfitFactor > 0 || isFinite(+grossProfitFactor) ? +grossProfitFactor : 0
    this.form.forecast.receivables = +receivables
    this.form.forecast.receivablesFactor = +receivablesFactorCalc > 0 || isFinite(+receivablesFactorCalc) ? +receivablesFactorCalc : 0
    this.form.forecast.payables = +payables
    this.form.forecast.payablesFactor = +payablesFactorCalc > 0 || isFinite(+payablesFactorCalc) ? +payablesFactorCalc : 0
    this.form.forecast.workingCapital = +workingCapital
    this.form.forecast.workingCapitalFactor = +workingCapitalFactor > 0 || isFinite(+workingCapitalFactor) ? +workingCapitalFactor : 0
    this.form.forecast.workingCashflow = +workingCashflow
    this.form.forecast.workingCashflowFactor =
    +workingCashflowFactor > 0 || isFinite(+workingCashflowFactor) ? +workingCashflowFactor : 0
    this.form.forecast.expenses = +adjustedExpenses
    this.form.forecast.expensesFactor =
    +adjustedExpensesFactorCalc > 0 || isFinite(+adjustedExpensesFactorCalc) ? +adjustedExpensesFactorCalc : 0
    this.form.forecast.operatingProfit = +operatingProfit
    this.form.forecast.operatingProfitFactor =
    +operatingProfitFactor > 0 || isFinite(+operatingProfitFactor) ? +operatingProfitFactor : 0
    this.form.forecast.operatingCashflow = +operatingCashfLow
    this.form.forecast.operatingCashflowFactor =
        +Math.round(parseFloat(operatingCashflowFactor)) > 0 || isFinite(+Math.round(parseFloat(operatingCashflowFactor))) ? +Math.round(parseFloat(operatingCashflowFactor)) : 0
    this.form.forecast.wip = inventoryWIP
    this.form.forecast.wipFactor = inventoryWIPFactor > 0 || isFinite(inventoryWIPFactor) ? inventoryWIPFactor : 0
    },
    toggleFactor(type){
      if(type == 'increment'){
        this.form.forecast.operatingCashflowFactor += 1;
      }else{
        this.form.forecast.operatingCashflowFactor -= 1;
      }
      console.log(parseInt(this.form.forecast.operatingCashflowFactor))
      this.$emit('changeFactor', parseInt(this.form.forecast.operatingCashflowFactor))
      this.$emit('changeFactorFinancial', parseInt(this.form.forecast.operatingCashflowFactor))
    },
  }
}
</script>