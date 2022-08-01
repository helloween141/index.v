<template>
  <div v-if="targetComponent">
    <component
        :is="targetComponent"
        :model="modelInterface"
        :values="modelValues"
    />
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
      const moduleName = route.params.module
      const modelName = route.params.model
      const recordId = route.params?.id || ''

      try {
        const interfaceResponse = await axios.get(`/api/vpanel/interface/${moduleName}/${modelName}`)
        if (interfaceResponse.data) {
          const interfaceData = interfaceResponse.data
          modelInterface.value = interfaceData

          const dataResponse = await axios.get(`/api/vpanel/data/${moduleName}/${modelName}/${recordId}`)
          if (dataResponse.data) {
            modelValues.value = recordId ? dataResponse.data : dataResponse.data
          }
          targetComponent.value = recordId ? loadFormComponent(interfaceData.formComponent) : loadEditorComponent(interfaceData.editorComponent)
        }
      } catch (error) {
        console.error(error)
      }
    }, {flush: 'pre', immediate: true, deep: true})

    const loadEditorComponent = (name: string) => {
      return defineAsyncComponent(() => import('../components/editors/' + name + '.vue'))
    }

    const loadFormComponent = (name: string) => {
      return defineAsyncComponent(() => import('../components/forms/' + name + '.vue'))
    }

    return {
      targetComponent,
      modelInterface,
      modelValues,
    }
  }
})
</script>

<style scoped>
</style>
