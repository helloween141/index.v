<template>
  <div v-if="incModel">
    <EditorActionPanel
        @on-create="createRecord"
        @on-show-filter="showFilterPanel"
        @on-search="applyFilter"
        :model="incModel"
    />

    <EditorFilterPanel
        :fields="filterFields"
        @on-filter="applyFilter"
        v-show="showFilter"
    />

    <DefaultEditorTable
        @select-record="selectRecord"
        :model="incModel"
        :values="values"
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
  props: {
    incModel: Object,
    customModuleName: String,
    customModelName: String
  },

  setup(props) {
    const route = useRoute()
    const values = ref({})
    const showFilter = ref(false)
    let {moduleName, modelName} = getRouteParameters(route)

    if (props.customModuleName) {
      moduleName = props.customModuleName
    }

    if (props.customModelName) {
      modelName = props.customModelName
    }

    onMounted(async () => {
      values.value = await loadList(moduleName, modelName, [])
    })

    const selectRecord = (recordId) => {
      router.push({ name: 'module', params: { id: recordId } })
    }

    const createRecord = () => {
      router.push({ name: 'module', params: { id: 0 } })
    }

    const applyFilter = async (filter) => {
      values.value = await loadList(moduleName, modelName, filter)
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
      showFilter,
      filterFields,
      values
    }
  }
})
</script>

<style scoped>

</style>
