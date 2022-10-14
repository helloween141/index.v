<template>
  <aside class="w-96 bg-white min-h-screen border-r dark:border-gray-700 dark:border-primary-darker dark:bg-gray-900 md:block" aria-label="Sidebar">
    <div class="overflow-y-auto h-full py-4 px-3 bg-gray-50 rounded dark:bg-gray-800">
      <div class="flex justify-between items-center">
        <Logo />
        <ThemeToggleButton @on-click="onToggle"/>
      </div>

      <div class="pt-4 mt-4 pb-4 mb-4 border-b border-t border-gray-200 dark:border-gray-700">
        <ul v-if="menu.length > 0">
          <li v-for="(item, key) in menu" :key="key">
            <div v-if="item.list">
              <button @click="onCollapse(key)" type="button" class="flex items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                <i :class="[item.icon, 'text-gray-500 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white dark:text-gray-400']"></i>
                <span class="flex-1 ml-3 text-left whitespace-nowrap" data-sidebar-toggle-item>{{ item.title }}</span>
                <i class="fa-solid fa-chevron-down"></i>
              </button>
              <ul :id="`dropdown-${key}`" class="hidden">
                <li v-for="(subItem, key) in item.list" :key="key">
                  <RouterLink :to="{ name: 'module', params: { module: item.module, model: subItem.model }}"
                              class="flex items-center p-2 pl-11 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                  >
                    <i v-if="subItem.icon" :class="[subItem.icon, 'text-gray-500 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white dark:text-gray-400']"></i>
                    <span>{{ subItem.title }}</span>
                  </RouterLink>
                </li>
              </ul>
            </div>
            <div v-else>
              <RouterLink :to="{ name: 'module', params: { module: item.module, model: item.model }}"
                          class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group"
              >
                <i :class="[item.icon, 'text-gray-500 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white dark:text-gray-400']"></i>
                <span class="ml-4">{{ item.title }}</span>
              </RouterLink>
            </div>
          </li>
        </ul>
      </div>

      <div>
        <ul>
          <li>
            <RouterLink to="/" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
              <img class="w-6 h-6 rounded-full"
                   src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS6X6SlR7kCahU2erUQtNwHMTGyznLddopKDA&usqp=CAU"
              >
              <span class="ml-4">{{ userStore.user.name }}</span>
            </RouterLink>
          </li>
            <a href="/admin/logout/" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
              <i class="fa-solid fa-sign-out text-gray-500 transition duration-75 group-hover:text-gray-900 dark:group-hover:text-white dark:text-gray-400"></i>
              <span class="ml-3">Выйти</span>
            </a>
        </ul>
      </div>

    </div>
  </aside>
</template>

<script lang="ts">
import {defineComponent} from "vue"
import {useUserStore} from "@/stores/user";
import ThemeToggleButton from "@/components/ui/sidebar/ThemeToggleButton.vue";
import Logo from "@/components/ui/sidebar/Logo.vue";

export default defineComponent({
  name: 'Sidebar',
  components: {Logo, ThemeToggleButton},
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

    return {
      userStore,
      onCollapse,
      onToggle
    }
  },
})
</script>

<style scoped>
</style>
