<template>
  <div>
    <EditorActionPanel :model="model" />

    <DefaultTable
        @select-record="selectRecord"
        :model="model"
        :values="values"
    />

  </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";
import Pagination from "@/components/ui/Pagination.vue";
import DefaultTable from "@/components/ui/tables/DefaultTable.vue";
import router from "@/router";
import EditorActionPanel from "@/components/ui/EditorActionPanel.vue";

export default defineComponent({
  name: 'DefaultModelEditor',
  components: {EditorActionPanel, DefaultTable},
  props: {
    model: Object,
    values: Object
  },
  setup() {
    const selectRecord = (recordId) => {
      router.push({ name: 'module', params: { id: recordId } })
    }

    return {
      selectRecord
    }
  }
})
</script>

<style scoped>

</style>