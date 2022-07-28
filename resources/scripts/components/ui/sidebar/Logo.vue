<template>
  <RouterLink :to="{name: 'dashboard'}" class="flex items-center">
    <img src="https://flowbite.com/docs/images/logo.svg" class="mr-3 h-6 sm:h-7" alt="Flowbite Logo" />
    <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">index.v CMS</span>
  </RouterLink>
</template>

<script>
export default {
  name: "Logo"
}
</script>

<style scoped>

</style>