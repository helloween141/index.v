<template>
  <ModuleComponent
      :module="module"
      :model="model"
      :record-id="id"
      :show-action-panel="true"
  />
</template>

<script lang="ts">
import {defineAsyncComponent, defineComponent, ref, shallowRef, watch} from "vue";
import {useRoute} from "vue-router";
import {loadInterface, loadList} from "@/api/actionEditor";
import {getRouteParameters} from "@/utils/utils";
import {loadRecord} from "@/api/actionForm";
import ModuleComponent from "@/components/ModuleComponent.vue";

export default defineComponent({
  name: 'ModuleView',
  components: {ModuleComponent},
  setup() {
    const route = useRoute()
    const module = ref()
    const model = ref()
    const id = ref()

    watch(route, async (to) => {
      const {moduleName, modelName, recordId} = getRouteParameters(route)

      module.value = moduleName
      model.value = modelName
      id.value = recordId

    },{flush: 'pre', immediate: true, deep: true})

    return {
      module,
      model,
      id
    }
  }
})
</script>

<style scoped>
</style>
