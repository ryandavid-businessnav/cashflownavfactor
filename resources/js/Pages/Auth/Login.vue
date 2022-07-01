<template>
  <Head title="Login" />
  <div class="flex items-center justify-center p-6 min-h-screen bg-white-800">
    <div class="w-full max-w-xl">
      <logo class="block mx-auto w-full max-w-xs fill-white" height="50" />
      <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="login">
        <div class="px-10 py-12">
          <h1 class="text-center text-3xl font-bold">Welcome Back!</h1>
          <div class="mt-6 mx-auto w-24 border-b-2" />
          <text-input v-model="form.email" :error="form.errors.email" class="mt-10" label="Email" type="email" autofocus autocapitalize="off" />
          <text-input v-model="form.password" :error="form.errors.password" class="mt-6" label="Password" type="password" />
          <label class="flex items-center mt-6 select-none" for="remember">
            <input id="remember" v-model="form.remember" class="mr-1" type="checkbox" />
            <span class="text-sm">Remember Me</span>
          </label>
        </div>
        <div class="flex px-10 py-4 bg-gray-100 border-t border-gray-100">
          <a href="/forgot-password" class="underline text-sm text-gray-600 hover:text-gray-900">
              Forgot your password?
          </a>

          <div class="sso-wrapper w-64 ml-4">
              <a href="/manage/xero">
                  <button type="button" class="btn-custom-cfn ml-auto mr-4">
                    <div class="grid grid-cols-4 gap-4">
                      <img src="data:image/svg+xml,%3Csvg viewBox='0 0 45 46' xmlns='http://www.w3.org/2000/svg'%3E %3Ctitle%3EXero%3C/title%3E %3Cpath fill='%2313B5EA' d='M22.457 45.49c12.402 0 22.456-10.072 22.456-22.495C44.913 10.57 34.86.5 22.457.5 10.054.5 0 10.57 0 22.995 0 35.418 10.054 45.49 22.457 45.49' /%3E %3Cpath fill='%23FFFFFF' d='M10.75 22.935l3.832-3.85a.688.688 0 0 0-.977-.965l-3.83 3.833-3.845-3.84a.687.687 0 0 0-.966.979l3.832 3.837-3.83 3.84a.688.688 0 1 0 .964.981l3.84-3.842 3.825 3.827a.685.685 0 0 0 1.184-.473.68.68 0 0 0-.2-.485l-3.83-3.846m22.782.003c0 .69.56 1.25 1.25 1.25a1.25 1.25 0 0 0-.001-2.5c-.687 0-1.246.56-1.246 1.25m-2.368 0c0-1.995 1.62-3.62 3.614-3.62 1.99 0 3.613 1.625 3.613 3.62s-1.622 3.62-3.613 3.62a3.62 3.62 0 0 1-3.614-3.62m-1.422 0c0 2.78 2.26 5.044 5.036 5.044s5.036-2.262 5.036-5.043c0-2.78-2.26-5.044-5.036-5.044a5.046 5.046 0 0 0-5.036 5.044m-.357-4.958h-.21c-.635 0-1.247.2-1.758.595a.696.696 0 0 0-.674-.54.68.68 0 0 0-.68.684l.002 8.495a.687.687 0 0 0 1.372-.002v-5.224c0-1.74.16-2.444 1.648-2.63.14-.017.288-.014.29-.014.406-.015.696-.296.696-.675a.69.69 0 0 0-.69-.688m-13.182 4.127c0-.02.002-.04.003-.058a3.637 3.637 0 0 1 7.065.055H16.2zm8.473-.13c-.296-1.403-1.063-2.556-2.23-3.296a5.064 5.064 0 0 0-5.61.15 5.098 5.098 0 0 0-1.973 5.357 5.08 5.08 0 0 0 4.274 3.767c.608.074 1.2.04 1.81-.12a4.965 4.965 0 0 0 1.506-.644c.487-.313.894-.727 1.29-1.222.006-.01.014-.017.022-.027.274-.34.223-.826-.077-1.056-.254-.195-.68-.274-1.014.156-.072.104-.153.21-.24.315-.267.295-.598.58-.994.802-.506.27-1.08.423-1.69.427-1.998-.023-3.066-1.42-3.447-2.416a3.716 3.716 0 0 1-.153-.58l-.01-.105h7.17c.982-.022 1.51-.717 1.364-1.51z' /%3E %3C/svg%3E" alt="Xero logo" aria-role="presentation" class="xero-sso-logo w-1">
                      <span class="pt-2 ">
                        Sign in with Xero
                      </span>
                    </div>
                  </button>
              </a>
          </div>
          <loading-button :loading="form.processing" class="btn-custom-cfn ml-auto" type="submit">Login</loading-button>
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

export default {
  components: {
    Head,
    LoadingButton,
    Logo,
    TextInput,
  },
  data() {
    return {
      form: this.$inertia.form({
        email: '',
        password: '',
        remember: false,
      }),
    }
  },
  methods: {
    login() {
      this.form.post('/login')
    },
  },
}
</script>
