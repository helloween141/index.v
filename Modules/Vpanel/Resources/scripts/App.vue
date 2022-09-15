<template>
  <main>
    <div class="flex">
      <Sidebar @on-toggle-theme="onToggleTheme" :menu="menu"/>
      <RouterView
          v-if="!loaderStore.loading"
          class="w-full p-5" />
      <Spinner v-else
          class="w-full p-5" />
    </div>
    <ModalsContainer/>
  </main>
</template>

<script lang="ts">
import {defineComponent, onMounted, ref} from "vue";
import {useThemeStore} from "@/stores/theme";
import axios from "axios";
import Sidebar from "@/components/ui/sidebar/Sidebar.vue";
import {useUserStore} from "@/stores/user";
import {useLoaderStore} from "@/stores/loader";

export default defineComponent({
  components: {Sidebar},
  setup() {
    const themeStore = useThemeStore()
    const userStore = useUserStore()
    const loaderStore = useLoaderStore()

    onMounted(async () => {
      await userStore.getUserData()
    });

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
      loaderStore,
      menu
    }
  }
})
</script>

<style>
</style>
