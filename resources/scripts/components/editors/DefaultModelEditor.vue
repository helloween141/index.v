<template>
  <div>
    <EditorActionPanel
        @on-create="createRecord"
        :model="incModel"
    />

    <DefaultTable
        @select-record="selectRecord"
        :model="incModel"
        :values="incValues"
    />

  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import DefaultTable from "@/components/ui/tables/DefaultTable.vue";
import router from "@/router";
import EditorActionPanel from "@/components/ui/EditorActionPanel.vue";

export default defineComponent({
  name: 'DefaultModelEditor',
  components: {EditorActionPanel, DefaultTable},
  props: {
    incModel: Object,
    incValues: Object
  },
  setup() {
    const selectRecord = (recordId) => {
      router.push({ name: 'module', params: { id: recordId } })
    }

    const createRecord = () => {
      router.push({ name: 'module', params: { id: 0 } })
    }

    return {
      selectRecord,
      createRecord
    }
  }
})
</script>

<style scoped>

</style>