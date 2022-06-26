<template>
  <div>
    <Head title="Add Scenario" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" :href="'/scenarios/'+businessId+'/list'">Scenarios</Link>
      <span class="text-indigo-400 font-medium">/</span> Add Scenario - {{businessData.company_name}}
    </h1>
    <div class="max-w-4xl bg-white rounded-md shadow overflow-hidden">
      <div v-if="calculated == false">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <select-input v-model="form.start.year" :error="form.errors.year" class="pb-8 pr-6 w-full lg:w-1/2" label="Select Start Year">
            <option :value="null" />
            <option v-for="year in years" :value="year">{{ year }}</option>
          </select-input>

          <select-input v-model="form.end.year" :error="form.errors.year" class="pb-8 pr-6 w-full lg:w-1/2" label="Select Next Year">
            <option :value="null" />
            <option v-for="year in years" :value="year">{{ year }}</option>
          </select-input>

          <num-input type="number" v-model="form.start.income" :error="form.errors.income" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Income" label="Business Income" /> 

          <num-input type="number" v-model="form.end.income" :error="form.errors.income" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Income" label="Business Income" /> 

          <num-input type="number" v-model="form.start.cogs" :error="form.errors.cogs" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Cost of Goods Sold" label="Cost of Goods Sold" /> 

          <num-input type="number" v-model="form.end.cogs" :error="form.errors.cogs" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Cost of Goods Sold" label="Cost of Goods Sold" /> 

          <num-input type="number" v-model="form.start.expenses" :error="form.errors.expenses" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Expenses" label="Expenses" /> 

          <num-input type="number" v-model="form.end.expenses" :error="form.errors.expenses" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Expenses" label="Expenses" /> 

          <num-input type="number" v-model="form.start.depreciation" :error="form.errors.depreciation" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Depreciation Expenses" label="" /> 

          <num-input type="number" v-model="form.end.depreciation" :error="form.errors.depreciation" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Depreciation Expenses" label="" /> 

          <num-input type="number" v-model="form.start.interest" :error="form.errors.interest" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Interest" label="Interest" /> 

          <num-input type="number" v-model="form.end.interest" :error="form.errors.interest" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Interest" label="Interest" /> 

          <num-input type="number" v-model="form.start.receivables" :error="form.errors.receivables" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Receivables" label="Receivables" /> 

          <num-input type="number" v-model="form.end.receivables" :error="form.errors.receivables" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Receivables" label="Receivables" /> 

          <num-input type="number" v-model="form.start.inventory" :error="form.errors.inventory" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Inventory" label="Inventory" /> 

          <num-input type="number" v-model="form.end.inventory" :error="form.errors.inventory" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Inventory" label="Inventory" /> 

          <num-input type="number" v-model="form.start.wip" :error="form.errors.wip" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Work in progress" label="Work in Progress"/> 

          <num-input type="number" v-model="form.end.wip" :error="form.errors.wip" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Work in progress" label="Work in Progress"/> 

          <num-input type="number" v-model="form.start.payables" :error="form.errors.payables" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Payables" label="Payables" /> 

          <num-input type="number" v-model="form.end.payables" :error="form.errors.payables" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Payables" label="Payables" /> 

         <!--  <num-input type="number" v-model="form.end.payables" :error="form.errors.payables" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Payables" label="What do you owe your suppliers" />  -->
         <div class="pb-8 pr-6 w-full lg:w-1/2"></div>
          <num-input type="number" v-model="form.end.growth" :error="form.errors.growth" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Growth %" label="Growth %" /> 
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-custom-cfn mr-5" type="button" @click.prevent="calculate">Calculate</loading-button>
          <loading-button :loading="form.processing" class="btn-custom-cfn mr-5" v-if="calculated == true" type="button" @click.prevent="clear">Clear</loading-button>
          <loading-button :loading="form.processing" v-if="calculated == true" class="btn-custom-cfn" type="submit">Add Scenario</loading-button>
        </div>
      </div>
      <div v-else>
        <div class="flex flex-wrap -mb-8 -mr-6 p-8 content-center bg-custom-cfn text-white">
          <h1 class="text-1xl font-bold">Profit & Loss</h1>
        </div>
        <div class="flex flex-wrap -mb-8 -mr-6 p-8 pt-16">
          <!-- <select-input v-model="form.start.year" :error="form.errors.year" class="pb-8 pr-6 w-full lg:w-1/2" label="Select Start Year">
            <option :value="null" />
            <option v-for="year in years" :value="year">{{ year }}</option>
          </select-input> -->
          <text-input v-model="form.start.year" :error="form.errors.year" class="pb-8 pr-6 w-full lg:w-1/2" placeholderIncome readonly /> 

          <text-input v-model="form.end.year" :error="form.errors.year" class="pb-8 pr-6 w-full lg:w-1/2" placeholderIncome readonly /> 

          <num-input type="number" v-model="form.start.income" :error="form.errors.income" class="pb-8 pr-6 w-full lg:w-1/2" placeholderIncome label="Income" /> 

          <num-input type="number" v-model="form.end.income" :error="form.errors.income" class="pb-8 pr-6 w-full lg:w-1/2" placeholderIncome label="Income" /> 

           <num-input type="number" v-model="form.start.cogs" :error="form.errors.cogs" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Cost of Goods Sold" label="Cost of Goods Sold" /> 

          <num-input type="number" v-model="form.end.cogs" :error="form.errors.cogs" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Cost of Goods Sold" label="Cost of Goods Sold" /> 

          <num-input type="number" v-model="form.start.grossProfit" :error="form.errors.grossProfit" class="pb-8 pr-6 w-full lg:w-1/2" placeholderIncome label="Gross Profit" readonly /> 

          <num-input type="number" v-model="form.end.grossProfit" :error="form.errors.grossProfit" class="pb-8 pr-6 w-full lg:w-1/2" placeholderIncome label="Gross Profit" readonly /> 

          <num-input type="number" v-model="form.start.expenses" :error="form.errors.expenses" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Expenses" label="Expenses" /> 

          <num-input type="number" v-model="form.end.expenses" :error="form.errors.expenses" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Expenses" label="Expenses" /> 

          <num-input type="number" v-model="form.start.depreciation" :error="form.errors.depreciation" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Depreciation Expenses" label="Depreciation" /> 

          <num-input type="number" v-model="form.end.depreciation" :error="form.errors.depreciation" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Depreciation Expenses" label="Depreciation" /> 

          <num-input type="number" v-model="form.start.interest" :error="form.errors.interest" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Interest" label="Interest" /> 

          <num-input type="number" v-model="form.end.interest" :error="form.errors.interest" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Interest" label="Interest" /> 

          <num-input type="number" v-model="form.start.adjustedExpense" :error="form.errors.adjustedExpense" class="pb-8 pr-6 w-full lg:w-1/2" placeholderIncome label="Adjusted Expenses" readonly /> 

          <num-input type="number" v-model="form.end.adjustedExpense" :error="form.errors.adjustedExpense" class="pb-8 pr-6 w-full lg:w-1/2" placeholderIncome label="Adjusted Expenses" readonly /> 

          <num-input type="number" v-model="form.start.operatingProfit" :error="form.errors.operatingProfit" class="pb-8 pr-6 w-full lg:w-1/2" placeholderIncome label="Operating Profit" readonly /> 

          <num-input type="number" v-model="form.end.operatingProfit" :error="form.errors.operatingProfit" class="pb-8 pr-6 w-full lg:w-1/2" placeholderIncome label="Operating Profit" readonly /> 
        </div>

        <div class="flex flex-wrap -mb-8 -mr-6 p-8 content-center bg-custom-cfn text-white">
          <h1 class="text-1xl font-bold">Balance Sheet</h1>
        </div>

        <div class="flex flex-wrap -mb-8 -mr-6 p-8 pt-16">

          <num-input type="number" v-model="form.start.receivables" :error="form.errors.receivables" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Receivables" label="Receivables" /> 

          <num-input type="number" v-model="form.end.receivables" :error="form.errors.receivables" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Receivables" label="Receivables" /> 

          <num-input type="number" v-model="form.start.inventory" :error="form.errors.inventory" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Inventory" label="Inventory" /> 

          <num-input type="number" v-model="form.end.inventory" :error="form.errors.inventory" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Inventory" label="Inventory" /> 

          <num-input type="number" v-model="form.start.wip" :error="form.errors.wip" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Work in progress" label="Work in Progress" /> 

          <num-input type="number" v-model="form.end.wip" :error="form.errors.wip" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Work in progress" label="Work in Progress" /> 

          <num-input type="number" v-model="form.start.payables" :error="form.errors.payables" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Payables" label="Payables" /> 

          <num-input type="number" v-model="form.end.payables" :error="form.errors.payables" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Payables" label="Payables" /> 

          <num-input type="number" v-model="form.start.workingCapital" :error="form.errors.workingCapital" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Working Capital" label="Working Capital" readonly/> 

          <num-input type="number" v-model="form.end.workingCapital" :error="form.errors.workingCapital" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Working Capital" label="Working Capital" readonly/> 

         <div class="pb-8 pr-6 w-full lg:w-1/2"></div>
          <num-input type="number" v-model="form.end.growth" :error="form.errors.growth" class="pb-8 pr-6 w-full lg:w-1/2" placeholder="Growth %" label="Growth %" /> 

        </div>


        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-custom-cfn mr-5" type="button" @click.prevent="back">Back</loading-button>
          <loading-button :loading="form.processing" class="btn-custom-cfn mr-5" v-if="calculated == true" type="button" @click.prevent="clear">Clear</loading-button>
          <loading-button :loading="form.processing" v-if="calculated == true" class="btn-custom-cfn" type="button" @click.prevent="proceed">Proceed</loading-button>
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

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    NumInput,
    FormWizard,
    TabContent
  },
  props:{
    businessId: String,
    businessData: Object
  },
  layout: Layout,
  remember: 'form',
  data() {
    return {
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
      calculated: false
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
