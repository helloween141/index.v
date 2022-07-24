<template>
  <div>
    <component :is="editorComponent"></component>
  </div>
</template>

<script lang="ts">
import {defineAsyncComponent, defineComponent} from "vue";

export default defineComponent({
  name: 'ModuleView',
  setup() {
    const editorComponent = defineAsyncComponent(() => import(`../components/editors/DefaultModelEditor.vue`))
    return {
      editorComponent
    }
  }
})
</script>

<style scoped>
</style>
