<template>
  <div v-if="incModel">
    <EditorActionPanel
        @on-create="createRecord"
        @on-search="applySearch"
        @on-toggle-filter="toggleFilterPanel"
        :model="incModel"
        :isModal="isModal"
    />

    <EditorFilterPanel
        @on-filter="applyFilter"
        :fields="filterFields"
        v-show="showFilter"
    />

    <DefaultEditorTable
        @select-record="selectRecord"
        @set-page="setPage"
        :model="incModel"
        :values="currentValues"
    />
  </div>
</template>

<script lang="ts">
import {defineComponent, onMounted, ref} from "vue";
import DefaultEditorTable from "@/components/ui/tables/DefaultEditorTable.vue";
import router from "@/router";
import EditorActionPanel from "@/components/ui/EditorActionPanel.vue";
import EditorFilterPanel from "@/components/ui/EditorFilterPanel.vue";
import {getFieldsForFilter, getRouteParameters} from "@/utils/utils";
import {loadList} from "@/api/actionEditor";
import {useRoute} from "vue-router";

export default defineComponent({
  name: 'DefaultModelEditor',
  components: {EditorFilterPanel, EditorActionPanel, DefaultEditorTable},
  emits: ['select-record'],
  props: {
    incModel: Object,
    incValues: Object,
    params: Object,
    modalData: Object
  },
  setup(props, { emit }) {
    const route = useRoute()
    const currentValues = ref(props.incValues)
    const showFilter = ref(!!route.query.f)
    const {moduleName, modelName} = getRouteParameters(route)

    const selectRecord = (recordId) => {
      if (props.modalData) {
        emit('select-record', recordId)
      } else {
        router.push({ name: 'module', params: { id: recordId } })
      }
    }

    const createRecord = () => {
      router.push({ name: 'module', params: { id: 0 } })
    }

    const applySearch = async (search) => {
      if (props.modalData) {
        currentValues.value = await loadList(props.modalData.module, props.modalData.model, 1, [], search)
      } else {
        currentValues.value = await loadList(moduleName, modelName, 1, [], search)
      }
    }

    const applyFilter = async (filter) => {
      if (props.modalData) {
        currentValues.value = await loadList(props.modalData.module, props.modalData.model, 1, filter, '')
      } else {
        (Object.keys(filter).length === 0)
            ? await router.push({path: route.path})
            : await router.push({path: route.path, query: {f: JSON.stringify(filter)} })
      }
    }

    const setPage = async (page: number) => {
      if (props.modalData) {
        currentValues.value = await loadList(props.modalData.module, props.modalData.model, page, [], '')
      } else {
        await router.push({path: route.fullPath, query: {...route.query, page}})
      }
    }

    const toggleFilterPanel = (value) => {
      showFilter.value = value
    }

    const filterFields = getFieldsForFilter(props.incModel.fields)

    return {
      selectRecord,
      createRecord,
      toggleFilterPanel,
      applyFilter,
      applySearch,
      setPage,
      showFilter,
      filterFields,
      currentValues
    }
  }
})
</script>

<style scoped>

</style>
