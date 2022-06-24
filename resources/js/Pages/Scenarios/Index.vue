<template>
  <div>
    <Head title="Scenarios" />
    <h1 class="mb-8 text-3xl font-bold">Scenarios</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
      </search-filter>
      <Link class="btn-custom-cfn ml-72" :href="'/scenarios/draft/'+businessId">
        <span>Add</span>
        <span class="hidden md:inline">&nbsp; Scenario</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Name</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="scenario in scenarios.data" :key="scenario.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/organizations/${scenario.id}/view`">
                {{ scenario.name }}
              </Link>
            </td>
            
          </tr>
          <tr v-if="scenarios.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">No Scenarios data found.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination class="mt-6" :links="scenarios.links" />
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import SearchFilter from '@/Shared/SearchFilter'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    filters: Object,
    scenarios: Object,
    businessId: String
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/scenarios/'+this.businessId+'/list', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
