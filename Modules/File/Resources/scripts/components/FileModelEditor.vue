<template>
  <div v-if="incModel">
    <EditorActionPanel
        :is-child="isChild"
        :is-modal="isModal"
        :model="incModel"
        @on-create="createRecord"
        @on-search="applySearch"
    />

    <ImageEditorTable
        @select-record="selectRecord"
        @set-page="setPage"
        :model="incModel"
        :values="currentValues"
    />
  </div>
</template>

<script lang="ts">
import {defineComponent, ref} from "vue";
import router from "@/router";
import EditorActionPanel from "@/components/ui/EditorActionPanel.vue";
import {getRouteParameters} from "@/utils/utils";
import {loadList} from "@/api/actionEditor";
import {useRoute} from "vue-router";
import ImageEditorTable from "./ImageEditorTable.vue";

export default defineComponent({
  name: 'FileModelEditor',
  components: {ImageEditorTable, EditorActionPanel},
  emits: ['select-record', 'reload'],
  props: {
    incModel: Object,
    incValues: Object,
    incPathData: Object,
    isModal: Boolean,
    isChild: Boolean
  },
  setup(props, { emit }) {
    const route = useRoute()
    const currentValues = ref(props.incValues)
    const {moduleName, modelName} = getRouteParameters(route)

    const selectRecord = (recordId) => {
      if (props.isModal) {
        const record = (currentValues.value).data.find(item => item.id === recordId)

        emit('select-record', record)
      } else {
        router.push({ name: 'module', params: {
            module: props.incPathData.module,
            model: props.incPathData.model,
            id: recordId
          }
        })
      }
    }

    const createRecord = () => {
      let query = props.incPathData.filter
      router.push({
        name: 'module',
        params: {
          module: props.incPathData.module,
          model: props.incPathData.model,
          id: 0
        },
        query
      })
    }

    const applySearch = async (search) => {
      if (props.isModal) {
        currentValues.value = await loadList(props.incPathData.module, props.incPathData.model, 1, [], search)
      } else {
        currentValues.value = await loadList(moduleName, modelName, 1, [], search)
      }
    }

    const setPage = async (page: number) => {
      if (props.isModal) {
        currentValues.value = await loadList(props.incPathData.module, props.incPathData.model, page, [], '')
      } else {
        await router.push({path: route.fullPath, query: {...route.query, page}})
        emit('reload', moduleName, modelName)
      }
    }

    return {
      selectRecord,
      createRecord,
      applySearch,
      setPage,
      currentValues
    }
  }
})
</script>

<style scoped>

</style>
