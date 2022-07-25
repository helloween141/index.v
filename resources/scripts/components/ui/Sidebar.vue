<template>
  <aside class="w-96 h-screen bg-white border-r dark:border-gray-700 dark:border-primary-darker dark:bg-gray-900 md:block" aria-label="Sidebar">
    <div class="overflow-y-auto h-screen py-4 px-3 bg-gray-50 rounded dark:bg-gray-800">
      <div class="flex justify-between items-center mb-5">
        <a href="/admin/" class="flex items-center">
          <img src="https://flowbite.com/docs/images/logo.svg" class="mr-3 h-6 sm:h-7" alt="Flowbite Logo" />
          <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">index.v CMS</span>
        </a>
        <ThemeToggleButton @on-click="onToggle"/>
      </div>
      <ul class="space-y-2" v-if="menu.length > 0">
        <li v-for="(item, key) in menu" :key="key">
          <div v-if="item.list">
            <button @click="onCollapse(key)" type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
              <i :class="[item.icon, 'text-gray-500 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white dark:text-gray-400']"></i>
              <span class="flex-1 ml-3 text-left whitespace-nowrap" data-sidebar-toggle-item>{{ item.title }}</span>
              <svg data-sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
            <ul :id="`dropdown-${key}`" class="hidden py-2 space-y-2">
              <li v-for="subItem in item.list">
                <RouterLink to="/admin/blog/news/" class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                  <i v-if="subItem.icon" :class="[subItem.icon, 'text-gray-500 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white dark:text-gray-400']"></i>
                  <span>{{ subItem.title }}</span>
                </RouterLink>
              </li>
            </ul>
          </div>
          <div v-else>
            <RouterLink to="/admin/blog/news/" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
              <i :class="[item.icon, 'text-gray-500 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white dark:text-gray-400']"></i>
              <span class="ml-4">{{ item.title }}</span>
            </RouterLink>
          </div>
        </li>
      </ul>
      <ul class="pt-4 mt-4 space-y-2 border-t border-gray-200 dark:border-gray-700">
        <li>
          <RouterLink to="/" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
            <img class="w-8 h-8 rounded-full"
                 src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS6X6SlR7kCahU2erUQtNwHMTGyznLddopKDA&usqp=CAU"
                 alt="user photo">
            <span class="ml-4">{{ userStore.user.name }}</span>
          </RouterLink>
        </li>
          <a href="/admin/logout/" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
            <i class="fa-solid fa-sign-out text-gray-500 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white dark:text-gray-400"></i>
            <span class="ml-4">Выйти</span>
          </a>
      </ul>
    </div>
  </aside>
</template>

<script lang="ts">
import {defineComponent} from "vue"
import {useUserStore} from "@/stores/user";
import axios from "axios";
import ThemeToggleButton from "@/components/ui/ThemeToggleButton.vue";
import router from "@/router";

export default defineComponent({
  name: 'Sidebar',
  components: {ThemeToggleButton},
  props: {
    menu: Array
  },
  setup(props, {emit}) {
    const userStore = useUserStore()

    const onCollapse = (key) => {
      document.getElementById('dropdown-' + key).classList.toggle('hidden')
    }

    const onToggle = () => {
      emit('on-toggle-theme')
    }

    const logout = async () => {
      try {
        await axios.post('/api/logout')
        userStore.$reset()
        await router.push({name: 'login'})
      } catch (error) {
        console.error(error)
      }
    }

    return {
      userStore,
      onCollapse,
      onToggle,
      logout
    }
  },
})
</script>

<style scoped>
</style>
