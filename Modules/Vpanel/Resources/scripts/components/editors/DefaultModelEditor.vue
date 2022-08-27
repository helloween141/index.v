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

    <div v-if="incValues">
      <DefaultEditorTable
          @select-record="selectRecord"
          :model="incModel"
          :values="incValues"
      />
    </div>

  </div>
</template>

<script lang="ts">
import {defineComponent, ref} from "vue";
import DefaultEditorTable from "@/components/ui/tables/DefaultEditorTable.vue";
import router from "@/router";
import EditorActionPanel from "@/components/ui/EditorActionPanel.vue";
import EditorFilterPanel from "@/components/ui/EditorFilterPanel.vue";
import {getFieldsForFilter} from "@/utils/utils";

export default defineComponent({
  name: 'DefaultModelEditor',
  components: {EditorFilterPanel, EditorActionPanel, DefaultEditorTable},
  props: {
    incModel: Object,
    incValues: Object
  },
  setup(props) {
    const showFilter = ref(false)

    const selectRecord = (recordId) => {
      router.push({ name: 'module', params: { id: recordId } })
    }

    const createRecord = () => {
      router.push({ name: 'module', params: { id: 0 } })
    }

    const applyFilter = () => {
      alert('Get list')
      // TODO: getList
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
      filterFields
    }
  }
})
</script>

<style scoped>

</style>