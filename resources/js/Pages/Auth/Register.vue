<template>
  <Head title="Register" />
  <div class="flex items-center justify-center p-6 min-h-screen bg-white-800">
    <div class="w-full max-w-md">
      <logo class="block mx-auto w-full max-w-xs fill-white" height="50" />
      <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="login">
        <div class="px-10 py-12">
          <text-input v-model="form.first_name" :error="form.errors.first_name" class="mt-10" label="First Name" type="text" autofocus autocapitalize="off" />
          <text-input v-model="form.last_name" :error="form.errors.last_name" class="mt-10" label="Last Name" type="text" autofocus autocapitalize="off" />
          <text-input v-model="form.email" :error="form.errors.email" class="mt-10" label="Email" type="email" autofocus autocapitalize="off" />
          <select-input v-model="form.mobile_number_prefix" :error="form.errors.mobile_number_prefix" class="mt-10" label="Country Code">
            <option value="(+61)">(+61) Australia</option>
            <option value="(+64)">(+64) New Zealand</option>
          </select-input>
          <text-input v-model="form.mobile_number" :error="form.errors.mobile_number" class="mt-10" label="Mobile Number" type="tel" pattern="[0-9]{10}" autofocus autocapitalize="off" />
          <text-input v-model="form.password" :error="form.errors.password" class="mt-6" label="Password" type="password" />
          <text-input v-model="form.password_confirmation" :error="form.errors.password_confirmation" class="mt-6" label="Confirm Password" type="password" />
        </div>
        <div class="flex px-10 py-4 bg-gray-100 border-t border-gray-100">
          <a href="/login" class="underline text-sm mt-2 text-gray-600 hover:text-gray-900">
              Already registered?
          </a>
          <loading-button :loading="form.processing" class="btn-custom-cfn ml-auto" type="submit">Register</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3'
import Logo from '@/Shared/Logo'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'

export default {
  components: {
    Head,
    LoadingButton,
    SelectInput,
    Logo,
    TextInput,
  },
  data() {
    return {
      form: this.$inertia.form({
        first_name: '',
        last_name: '',
        email: '',
        mobile_number: '',
        mobile_number_prefix: '(+61)',
        password: '',
        password_confirmation: '',
      }),
    }
  },
  methods: {
    login() {
      this.form.post('/register')
    },
  },
}
</script>
