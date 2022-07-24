<template>
  <div class="flex flex-col h-screen justify-center">
    <div class="flex items-center justify-center mb-10">
      <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">index.v CMS</span>
    </div>

    <div v-if="error" class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
      <span class="font-medium">{{ error }}</span>
    </div>
    <form class="shadow-md rounded px-8 pt-6 pb-8  dark:bg-gray-800" @submit.prevent="handleSubmit">
      <div class="mb-5">
        <h1 class="text-2xl dark:text-white">Вход</h1>
      </div>

      <div class="mb-6">
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email</label>
        <input v-model="email" type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
      </div>
      <div class="mb-6">
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Пароль</label>
        <input v-model="password" type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
      </div>
      <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Войти</button>
    </form>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import axios from "axios";
import router from "@/router";

export default defineComponent({
  name: 'LoginView',
  data() {
    return {
      email: '',
      password: '',
      error: ''
    }
  },
  methods: {
    async handleSubmit() {
      try {
        await axios.get('/sanctum/csrf-cookie');
        const response = await axios.post('/api/login', {
          email: this.email,
          password: this.password
        })
        if (response.data.success) {
          this.error = ''
          await router.push({name: 'dashboard'})
        } else {
          this.error = response.data.message
        }
      } catch (error) {
        console.error(error)
      }
    }
  }
})
</script>

<style scoped>

</style>
