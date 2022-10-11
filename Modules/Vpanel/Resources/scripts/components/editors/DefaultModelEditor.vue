<template>
  <div v-if="incModel">
    <EditorActionPanel
        :is-child="isChild"
        :is-modal="!!isModal"
        :model="incModel"
        @on-create="createRecord"
        @on-search="applySearch"
        @on-toggle-filter="toggleFilterPanel"
    />

    <EditorFilterPanel
        v-show="showFilterPanel"
        :fields="filterFields"
        @on-filter="applyFilter"
    />

    <DefaultEditorTable
        @select-record="selectRecord"
        @set-page="setPage"
        @change-sort="changeSort"
        :model="incModel"
        :values="currentValues"
    />
  </div>
</template>

<script lang="ts">
import {defineComponent, ref} from "vue";
import DefaultEditorTable from "@/components/ui/tables/DefaultEditorTable.vue";
import router from "@/router";
import EditorActionPanel from "@/components/ui/EditorActionPanel.vue";
import EditorFilterPanel from "@/components/ui/EditorFilterPanel.vue";
import {getFieldsForFilter, getRouteParameters} from "@/utils/utils";
import {loadList, sortList} from "@/api/actionEditor";
import {useRoute} from "vue-router";

export default defineComponent({
  name: 'DefaultModelEditor',
  components: {EditorFilterPanel, EditorActionPanel, DefaultEditorTable},
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
    const showFilterPanel = ref(!!route.query.f)
    const {moduleName, modelName} = getRouteParameters(route)

    const selectRecord = (recordId) => {
      if (props.isModal) {
        emit('select-record', recordId)
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

    const applyFilter = async (filter) => {
      if (props.isModal) {
        currentValues.value = await loadList(props.incPathData.module, props.incPathData.model, 1, filter, '')
      } else {
        (Object.keys(filter).length === 0)
            ? await router.push({path: route.path})
            : await router.push({path: route.path, query: {f: JSON.stringify(filter)} })
        emit('reload', moduleName, modelName)
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

    const changeSort = async(sortData) => {
      await sortList(props.incPathData.module, props.incPathData.model, sortData)
    }

    const toggleFilterPanel = (value) => {
      showFilterPanel.value = value
    }

    const filterFields = getFieldsForFilter(props.incModel.fields)

    return {
      selectRecord,
      createRecord,
      toggleFilterPanel,
      applyFilter,
      applySearch,
      setPage,
      changeSort,
      showFilterPanel,
      filterFields,
      currentValues
    }
  }
})
</script>

<style scoped>

</style>
