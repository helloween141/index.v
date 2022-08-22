<template>
  <div v-if="incModel">
    <div class="mb-3 flex justify-between items-center">
      <h1 class="dark:text-white text-2xl">{{ incModel.title }}</h1>
      <EditorActionPanel
          @on-create="createRecord"
          :model="incModel"
      />
    </div>

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
import {defineComponent, onMounted, ref} from "vue";
import DefaultEditorTable from "@/components/ui/tables/DefaultEditorTable.vue";
import router from "@/router";
import EditorActionPanel from "@/components/ui/EditorActionPanel.vue";

export default defineComponent({
  name: 'DefaultModelEditor',
  components: {EditorActionPanel, DefaultEditorTable},
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