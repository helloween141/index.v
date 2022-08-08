<template>
  <div>
    <div>
      <h1 class="dark:text-white text-2xl mb-3">{{ incModel.title }}</h1>
      <p class="dark:text-white">
        Кастомный компонент
      </p>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
  name: 'StatisticModelEditor',
  props: {
    incModel: Object,
    incValues: Object
  },
  setup() {
  }
})
</script>

<style scoped>

</style>