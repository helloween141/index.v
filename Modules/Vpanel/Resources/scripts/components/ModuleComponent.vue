<template>
  <div v-if="targetComponent">
    <component
        :is="targetComponent"
        :inc-model="modelInterface"
        :inc-values="modelValues"
        :inc-path-data="pathData"
        :is-child="isChild"
        @reload="loadModule"
    />
  </div>
</template>

<script lang="ts">
import {defineAsyncComponent, defineComponent, ref, shallowRef, watch} from "vue";
import {useRoute} from "vue-router";
import {loadInterface, loadList} from "@/api/actionEditor";
import {loadRecord} from "@/api/actionForm";

export default defineComponent({
  name: 'ModuleComponent',
  props: {
    module: String,
    model: String,
    recordId: Number,
    isChild: Boolean,
    defaultFilter: {
      type: Object,
      default: null
    }
  },
  setup(props) {
    const route = useRoute()
    const modelInterface = ref()
    const modelValues = ref()
    const targetComponent = shallowRef()
    const pathData = ref()

    const loadModule = async (moduleName, modelName, recordId) => {
      if (moduleName && modelName) {
        modelInterface.value = await loadInterface(moduleName, modelName)

        if (modelInterface.value?.single) {
          recordId = 1
        }

        if (recordId >= 0) {
          modelValues.value = await loadRecord(moduleName, modelName, recordId)
          const formComponent = modelInterface.value['formComponent']
          targetComponent.value = formComponent ? loadCustomComponent(formComponent, moduleName, 'forms') : loadFormComponent()
        } else {
          let filter = props.defaultFilter
          let page = 1

          if (route.query.f) {
            filter = JSON.parse((route.query.f).toString())
          }

          if (route.query.page) {
            page = parseInt(route.query.page.toString())
          }

          modelValues.value = await loadList(moduleName, modelName, page, filter)
          const editorComponent = modelInterface.value['editorComponent']
          targetComponent.value = editorComponent ? loadCustomComponent(editorComponent, moduleName, 'editors') : loadEditorComponent()
        }
      }
    }

    const loadCustomComponent = (component: string, moduleName: string, type: string) => {
      return defineAsyncComponent(() => import(
          /* @vite-ignore */
          '/Modules/' + moduleName + '/Resources/scripts/components/' + type + '/' + component + '.vue')
      )
    }

    const loadEditorComponent = () => {
      return defineAsyncComponent(() => import(
          /* @vite-ignore */
          '../components/editors/DefaultModelEditor.vue')
      )
    }

    const loadFormComponent = () => {
      return defineAsyncComponent(() => import(
          /* @vite-ignore */
          '../components/forms/DefaultModelForm.vue')
      )
    }

    watch(props, async (to) => {
      pathData.value = {
        module: props.module,
        model: props.model,
        filter: props.defaultFilter
      }
      await loadModule(props.module, props.model, props.recordId)
    }, {
      flush: 'pre',
      immediate: true,
      deep: true
    })

    return {
      targetComponent,
      modelInterface,
      modelValues,
      pathData,
      loadModule
    }
  }
})
</script>

<style scoped>
</style>
