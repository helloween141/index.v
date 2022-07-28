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

    watch(route, async (to) => {
      try {
        const response = await axios.get(`/api/vpanel/interface`, {
          params: {
            'module': route.params.module,
            'model': route.params.model
          }
        })
        if (response.data) {
          const inteface = response.data.interface;
          loadComponent(inteface.editorComponent)
          modelInterface.value = inteface
          modelValues.value = response.data.list
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
