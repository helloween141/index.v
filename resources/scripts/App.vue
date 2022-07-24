<template>
  <main>
    <div class="flex">
      <Sidebar @on-toggle-theme="onToggleTheme" :menu="menu"/>
      <RouterView class="w-full p-5" />
    </div>
    <ModalsContainer/>
  </main>
</template>

<script lang="ts">
import {defineComponent, onMounted, ref} from "vue";
import AuthView from "@/views/LoginView.vue";
import {useThemeStore} from "@/stores/theme";
import axios from "axios";
import Sidebar from "@/components/ui/Sidebar.vue";

export default defineComponent({
  components: {Sidebar, AuthView},
  setup() {
    const themeStore = useThemeStore()

    const onToggleTheme = () => {
      themeStore.switchTheme()
      applyTheme()
    }

    const applyTheme = () => {
      if (themeStore.isDark) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    }
    applyTheme()

    const menu = ref([])
    onMounted(async () => {
      try {
        axios.get('/api/vpanel/menu').then(response => {
          menu.value = response.data
        })
      } catch (error) {
        console.error(error)
      }
    })

    return {
      onToggleTheme,
      themeStore,
      menu
    }
  }
})
</script>

<style>
</style>
