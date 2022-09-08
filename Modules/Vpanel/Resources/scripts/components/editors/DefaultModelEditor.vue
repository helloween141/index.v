<template>
  <div v-if="incModel">
    <EditorActionPanel
        @on-create="createRecord"
        @on-show-filter="showFilterPanel"
        @on-search="applySearch"
        :model="incModel"
        :isModal="isModal"
    />

    <EditorFilterPanel
        :fields="filterFields"
        @on-filter="applyFilter"
        v-show="showFilter"
    />

    <DefaultEditorTable
        @select-record="selectRecord"
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
    isModal: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const route = useRoute()
    const currentValues = ref(props.incValues)
    const showFilter = ref(false)

    let {moduleName, modelName} = getRouteParameters(route)

    const selectRecord = (recordId) => {
      if (props.isModal) {
        emit('select-record', recordId)
      } else {
        router.push({ name: 'module', params: { id: recordId } })
      }
    }

    const createRecord = () => {
      router.push({ name: 'module', params: { id: 0 } })
    }

    const applySearch = async (searchString) => {
      currentValues.value = await loadList(moduleName, modelName, true,[], searchString)
    }

    const applyFilter = async (filter) => {
      currentValues.value = await loadList(moduleName, modelName, true, filter)
    }

    const showFilterPanel = () => {
      showFilter.value = !showFilter.value
    }

    const filterFields = getFieldsForFilter(props.incModel.fields)

    return {
      selectRecord,
      createRecord,
      showFilterPanel,
      applyFilter,
      applySearch,
      showFilter,
      filterFields,
      currentValues
    }
  }
})
</script>

<style scoped>

</style>
