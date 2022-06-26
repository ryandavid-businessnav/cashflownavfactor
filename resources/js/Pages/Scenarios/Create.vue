<template>
  <div>
    <Head title="Add Scenario" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" :href="'/scenarios/'+businessId+'/list'">Scenarios</Link>
      <span class="text-indigo-400 font-medium">/</span> Add Scenario - {{businessData.company_name}}
    </h1>
    <div class="max-w-8xl bg-white rounded-md shadow overflow-hidden">
      <div class="flex flex-wrap">
    <div class="w-full">
      
      <Financials :props="data"/>
      <!-- <div class="">
        <div class="px-4 py-5 flex-auto">
          <div class="tab-content tab-space">
            <div v-bind:class="{'hidden': openTab !== 1, 'block': openTab === 1}">
                <Factor @changeFactor="changeFactor($event)" :props="data" :factor="operatingCashflowFactor"/>
            </div>
            <div v-bind:class="{'hidden': openTab !== 2, 'block': openTab === 2}">
              <p>
                <Financials :props="data" @changeFactorFinancial="changeFactorFinancial($event)" :factor="operatingCashflowFactor" />
              </p>
            </div>
            <div v-bind:class="{'hidden': openTab !== 3, 'block': openTab === 3}">
              <Chart :props="data" @changeFactorFinancial="changeFactorFinancial($event)" :factor="operatingCashflowFactor"/>
            </div>
          </div>
        </div>
      </div> -->
    </div>
  </div>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import NumInput from '@/Shared/NumInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import throttle from 'lodash/throttle'
import Factor from './Factor.vue';
import Financials from './Financials.vue';
import Chart from './Chart.vue';

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    NumInput,
    FormWizard,
    TabContent,
    Factor,
    Financials,
    Chart
  },
  props:{
    businessId: Number,
    businessData: Object,
    data: Object
  },
  layout: Layout,
  remember: 'form',
  data() {
    return {
      openTab: 1,
      // form: this.$inertia.form({
      //   start:{year: "2022",income:500000, cogs:200000, expenses:175000, depreciation: 0, interest:0, receivables: 80000, wip: 0, payables: 20000, inventory: 100000, startGrossProfit: 0, adjustedExpense: 0},
      //   end:{year: "2023", income:550000, cogs:222000.00, expenses:192500, depreciation: 121000.00, interest:0, receivables: 88000, wip: 0, payables: 22000, inventory: 110000, growth: 10, startGrossProfit: 0, adjustedExpense: 0},
      //   businessData: {}
      // }),
      form: this.$inertia.form({
        start:{year: "2022",income:0, cogs:0, expenses:0, depreciation: 0, interest:0, receivables: 0, wip: 0, payables: 0, inventory: 0, startGrossProfit: 0, adjustedExpense: 0},
        end:{year: "2023", income:0, cogs:0, expenses:0, depreciation: 0, interest:0, receivables: 0, wip: 0, payables: 0, inventory: 0, growth: 0, startGrossProfit: 0, adjustedExpense: 0},
        businessData: {}
      }),
      calculated: false,
      operatingCashflowFactor: 0
      //yearVar:2022
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        //this.$inertia.get('/businesses', pickBy(this.form), { preserveState: true })
        this.form.start.workingCapital = -Math.abs(+this.form.start.receivables) + -Math.abs(+this.form.start.inventory) + -Math.abs(+this.form.start.wip) + Math.abs(+this.form.start.payables);

        this.form.start.grossProfit = (+this.form.start.income + -Math.abs(+this.form.start.cogs));
        this.form.start.adjustedExpense = Math.abs(this.form.start.expenses) + -Math.abs(this.form.start.interest) + -Math.abs(this.form.start.depreciation);
        this.form.start.operatingProfit = this.form.start.grossProfit - Math.abs(this.form.start.adjustedExpense);

        this.form.end.workingCapital = -Math.abs(+this.form.end.receivables) + -Math.abs(+this.form.end.inventory) + -Math.abs(+this.form.end.wip) + Math.abs(+this.form.end.payables);

        this.form.end.grossProfit = +this.form.end.income + -Math.abs(+this.form.end.cogs);
        this.form.end.adjustedExpense = Math.abs(this.form.end.expenses) + -Math.abs(this.form.end.interest) + -Math.abs(this.form.end.depreciation);
        this.form.end.operatingProfit = this.form.end.grossProfit - Math.abs(this.form.end.adjustedExpense);

      }, 150),
    },
  },
  computed : {
    years () {
      const year = new Date().getFullYear()
      return Array.from({length: year - 1900}, (value, index) => 2022 + index)
    }
  },
  methods: {
    changeFactor(factor)
    {
      console.log(parseInt(factor))
      this.operatingCashflowFactor = factor
    },
    changeFactorFinancial(factor)
    {
      console.log(parseInt(factor))
      this.operatingCashflowFactor = factor
    },
    toggleTabs: function(tabNumber){
      this.openTab = tabNumber
    },
    back(){
      this.calculated = false
    },
    calculate(){
      this.calculated = true
      this.form.start.workingCapital = -Math.abs(+this.form.start.receivables) + -Math.abs(+this.form.start.inventory) + -Math.abs(+this.form.start.wip) + Math.abs(+this.form.start.payables);

      this.form.start.grossProfit = (+this.form.start.income + -Math.abs(+this.form.start.cogs));
      this.form.start.adjustedExpense = Math.abs(this.form.start.expenses) + -Math.abs(this.form.start.interest) + -Math.abs(this.form.start.depreciation);
      this.form.start.operatingProfit = this.form.start.grossProfit - Math.abs(this.form.start.adjustedExpense);

      this.form.end.workingCapital = -Math.abs(+this.form.end.receivables) + -Math.abs(+this.form.end.inventory) + -Math.abs(+this.form.end.wip) + Math.abs(+this.form.end.payables);

      this.form.end.grossProfit = +this.form.end.income + -Math.abs(+this.form.end.cogs);
      this.form.end.adjustedExpense = Math.abs(this.form.end.expenses) + -Math.abs(this.form.end.interest) + -Math.abs(this.form.end.depreciation);
      this.form.end.operatingProfit = this.form.end.grossProfit - Math.abs(this.form.end.adjustedExpense);
    },
    clear(){
      this.calculated = false
      this.form.start = {}
      this.form.end = {}
    },
    proceed() {
      this.form.businessData = this.businessData
      this.form.post('/scenarios/'+this.businessData.id,this.form)
    },
  },
}
</script>

<style type="text/css">
  .active{
    display: inline-block; 
    padding: 1rem; 
    background-color: #F3F4F6; 
    color: #111827; 
    width: 100%; 
    border-top-left-radius: 0.5rem;
    border-bottom-left-radius: 0.5rem; 
  }

  .inactive{
    display: inline-block; 
    padding: 1rem; 
    background-color: #ffffff; 
    width: 100%; 
  }

  .inactive:hover{
    background-color: #F9FAFB; 
    color: #374151; 
  }
</style>
