<template>
  <div>
    <Head :title="form.name" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/businesses">Businesses</Link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.company_name }}
    </h1>
    <!-- <trashed-message v-if="business.deleted_at" class="mb-6" @restore="restore"> This business has been deleted. </trashed-message> -->
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.company_name" :error="form.errors.company_name" class="pb-8 pr-6 w-full lg:w-1/2" label="Business Name" />
          <text-input v-model="form.mobile_number" :error="form.errors.mobile_number" class="pb-8 pr-6 w-full lg:w-1/2" label="Phone Number" />
          <text-input v-model="form.address" :error="form.errors.address" class="pb-8 pr-6 w-full lg:w-1/2" label="Address" />

          <select-input v-model="form.no_of_employees" :error="form.errors.no_of_employees" class="pb-8 pr-6 w-full lg:w-1/2" label="Number of Employees">
            <option :value="null" />
            <option value="1-9">1-9</option>
            <option value="10-49">10-49</option>
            <option value="50-99">50-99</option>
            <option value="100-499">100-499</option>
            <option value="500+">500+</option>
          </select-input>

          <select-input v-model="form.currency" :error="form.errors.currency" class="pb-8 pr-6 w-full lg:w-1/2" label="Default Currency">
            <option>AUD - Australian Dollar</option>
            <option>EUR - Euro</option>
            <option>USD - US Dollar</option>
            <option>NZD - New Zealand Dollar</option>
            <option>GBP - Sterling Pound</option>
            <option>MXN - Mexican Peso</option>
            <option>CAD - Canadian Dollar</option>
            <option>OTHER</option>
          </select-input>

          <select-input v-model="form.anzic_division" :error="form.errors.anzic_division" class="pb-8 pr-6 w-full lg:w-1/2" label="ANZSIC Code">
            <option value="agriculture_forestry_fishing">Agriculture, forestry and fishing</option> 
            <option value="mining" >Mining</option> 
            <option value="manufacturing" >Manufacturing</option> 
            <option value="electricity_gas_water_waste_services" >Electricity, gas, water and waste services</option> 
            <option value="construction" >Construction</option> 
            <option value="wholesale_trade" >Wholesale trade</option> 
            <option value="retail_trade" >Retail trade</option> 
            <option value="accommodation_food_services" >Accommodation and food services</option> 
            <option value="transport_postal_warehousing" >Transport, postal and warehousing</option> 
            <option value="information_media_telecommunications" >Information media and telecommunications</option> 
            <option value="financial_insurance_services" >Financial and insurance services</option> 
            <option value="rental_hiring_real_estate_services" >Rental hiring and real estate services</option> 
            <option value="professional_scientific_technical_services" >Professional, scientific and technical services</option> 
            <option value="administrative_support_services" >Administrative and support services</option> 
            <option value="public_administration_safety" >Public administration and safety</option> 
            <option value="education_training" >Education and training</option> 
            <option value="health_care_social_assistance" >Health care and social assistance</option> 
            <option value="arts_recreation_services" >Arts and recreation services</option> 
            <option value="other_services">Other services</option> 
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" v-if="form.anzic_division == 'agriculture_forestry_fishing'" label="ANZSIC Sub Division">
              <option>Agriculture</option>
              <option>Aquaculture</option>
              <option>Forestry and Logging</option>
              <option>Fishing, Hunting and Trapping</option>
              <option>Agriculture, Forestry, and Fishing Support Services</option>
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" label="ANZSIC Sub Division" v-if="form.anzic_division == 'mining'">
              <option>Coal Mining</option>
              <option>Oil and Gas Extraction</option>
              <option>Metal Ore Mining</option>
              <option>Non-Metallic Minteral Mining and Quarrying</option>
              <option>Exploration and Other Mining Support Services</option>
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" label="ANZSIC Sub Division" v-if="form.anzic_division == 'manufacturing'">
              <option>Food Product Manufacturing</option>
              <option>Beverage and Tobacco Product Manufacturing</option>
              <option>Textile, Leather, Clothing, and Footwear Manufacturing</option>
              <option>Wool Product Manufacturing</option>
              <option>Pulp, Paper, and Converted Paper Product Manufacturing</option>
              <option>Printing (including the Reproduction of Recorded Media)</option>
              <option>Basic Chemical and Chemical Product Manufacturing</option>
              <option>Polymer Product and Rubber Product Manufacturing</option>
              <option>Non-Metallic Mineral Product Manufacturing</option>
              <option>Primary Metal and Metal Product Manufacturing</option>
              <option>Fabricated Metal Product Manufacturing</option>
              <option>Transport Equipment Manufacturing</option>
              <option>Machinery and Equipment Manufacturing</option>
              <option>Furniture and Other Manufacturing</option>
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" label="ANZSIC Sub Division" v-if="form.anzic_division == 'electricity_gas_water_waste_services'">
              <option>Electrical Supply</option>
              <option>Gas Supply</option>
              <option>Water Supply, Sewerage, and Drainage Services</option>
              <option>Waste Collection, Treatment, and Disposal Services</option>
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" label="ANZSIC Sub Division" v-if="form.anzic_division == 'construction'">
              <option>Building Construction</option>
              <option>Heavy and Civil Engineering Construction></option>
              <option>Construction Services</option>
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" label="ANZSIC Sub Division" v-if="form.anzic_division == 'wholesale_trade'">
              <option>Basic Material Wholesaling</option>
              <option>Machinery and Equipment Wholsaling</option>
              <option>Motor Vehicle and Motor Vehicle Parts Wholesaling</option>
              <option>Grocery, Liquoe, and Tobacco Product Wholesaling</option>
              <option>Other Goods Wholesaling</option>
              <option>Commission-Based Wholesaling</option>
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" label="ANZSIC Sub Division" v-if="form.anzic_division == 'retail_trade'">
              <option>Motor Vehicle and Motor Vehicle Parts Retailing</option>
              <option>Fuel Retailing</option>
              <option>Food Retailing</option>
              <option>Other Store-Based Retailing</option>
              <option>Food and Beverage Services</option>
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" label="ANZSIC Sub Division" v-if="form.anzic_division == 'accommodation_food_services'">
              <option>Accommodation</option>
              <option>Food and Beverage Services</option>
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" label="ANZSIC Sub Division" v-if="form.anzic_division == 'transport_postal_warehousing'">
              <option>Road Transport</option>
              <option>Rail Transport</option>
              <option>Water Transport</option>
              <option>Air and Space Transport</option>
              <option>Other Transport</option>
              <option>Postal and Courier Pick-up and Delivery Services</option>
              <option>Transport Support Services</option>
              <option>Warehousing and Storage Services</option>
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" label="ANZSIC Sub Division" v-if="form.anzic_division == 'information_media_telecommunications'">
              <option>Publishing (except Internet and Music Publishing)</option>
              <option>Motion Picture and Sound Recording Activities</option>
              <option>Broadcasting (except Internet)</option>
              <option>Internet Publishing and Broadcasting</option>
              <option>Telecommunications Services</option>
              <option>Internet Service Providers, Web Search Portals, and Data Processing Services</option>
              <option>Library and Other Information Services</option>
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" label="ANZSIC Sub Division" v-if="form.anzic_division == 'financial_insurance_services'">
              <option>Finance</option>
              <option>Insurance and Superannuation Funds</option>
              <option>Auxiliary Finance and Insurance Services</option>
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" label="ANZSIC Sub Division" v-if="form.anzic_division == 'rental_hiring_real_estate_services'">
              <option>Rental and Hiring Services (except Real Estate)</option>
              <option>Property Operators and Real Estate Services</option>
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" label="ANZSIC Sub Division" v-if="form.anzic_division == 'professional_scientific_technical_services'">
              <option>Professional, Scientific, and Technical Services (Except Computer System Design and Related Systems)</option>
              <option>Computer System Design and Related Systems</option>
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" label="ANZSIC Sub Division" v-if="form.anzic_division == 'administrative_support_services'">
              <option>Administrative Services</option>
              <option>Building Cleaning, Pest Control, and Other Support Services</option>
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" label="ANZSIC Sub Division" v-if="form.anzic_division == 'public_administration_safety'">
              <option>Public Administration</option>
              <option>Defence</option>
              <option>Public Order, Safety, and Regulator Services</option>
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" label="ANZSIC Sub Division" v-if="form.anzic_division == 'education_training'">
              <option>Preschool and School Education</option>
              <option>Tertiary Education</option>
              <option>Adult, Community, and Other Education</option>
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" label="ANZSIC Sub Division" v-if="form.anzic_division == 'health_care_social_assistance'">
              <option>Hospitals</option>
              <option>Medical and Other Health Care Services</option>
              <option>Residential Care Services</option>
              <option>Social Assistance Services</option>
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" label="ANZSIC Sub Division" v-if="form.anzic_division == 'arts_recreation_services'">
              <option>Heritage Activities</option>
              <option>Creative and Performing Arts Activities</option>
              <option>Sports and Recreation Activities</option>
              <option>Gambling Activities</option>
          </select-input>

          <select-input class="pb-8 pr-6 w-full lg:w-1/2" v-model="form.anzic_subdivision" name="anzic_subdivision" label="ANZSIC Sub Division" v-if="form.anzic_division == 'other_services'">
              <option>Repair and Maintenance</option>
              <option>Personal and Other Services</option>
              <option>Private Households Employing Staff and Undifferentiated Goods - and Service-Producing Activities of Households for Own Use</option>
          </select-input>
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!business.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Business</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Business</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  components: {
    Head,
    Icon,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    business: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        company_name: this.business.company_name,
        email: this.business.email,
        mobile_number: this.business.mobile_number,
        address: this.business.address,
        anzic_division: this.business.anzic_division,
        anzic_subdivision: this.business.anzic_subdivision,
        no_of_employees: this.business.no_of_employees,
        currency : this.business.currency,
        deleted_at: this.business.deleted_at,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/businesses/${this.business.id}`)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this organization?')) {
        this.$inertia.delete(`/organizations/${this.organization.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this organization?')) {
        this.$inertia.put(`/organizations/${this.organization.id}/restore`)
      }
    },
  },
}
</script>
