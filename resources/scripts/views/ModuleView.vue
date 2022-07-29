<template>
  <div v-if="targetComponent">
    <component :is="targetComponent" :model="modelInterface" :values="modelValues"></component>
  </div>
</template>

<script lang="ts">
import {defineAsyncComponent, defineComponent, ref, shallowRef, watch} from "vue";
import axios from "axios";
import {useRoute} from "vue-router";

export default defineComponent({
  name: 'ModuleView',
  setup() {
    const modelInterface = ref([])
    const modelValues = ref([])
    const targetComponent = shallowRef('')
    const route = useRoute()

    // TODO: Refactoring
    watch(route, async (to) => {
      try {
        const interfaceResponse = await axios.get(`/api/vpanel/interface`, {
          params: {
            'module': route.params.module,
            'model': route.params.model
          }
        })
        if (interfaceResponse.data) {
          const interfaceData = interfaceResponse.data
          modelInterface.value = interfaceData;
          loadComponent(interfaceData.editorComponent)

          const listResponse = await axios.get(`/api/vpanel/list`, {
            params: {
              'module': route.params.module,
              'model': route.params.model
            }
          })
          if (listResponse.data) {
            modelValues.value = listResponse.data
          }
        }
      } catch (error) {
        console.error(error)
      }
    }, {flush: 'pre', immediate: true, deep: true})

    const loadComponent = (name: string) => {
      targetComponent.value = defineAsyncComponent(() => import('../components/editors/' + name + '.vue'))
    }

    return {
      targetComponent,
      modelInterface,
      modelValues
    }
  }
})
</script>

<style scoped>
</style>
