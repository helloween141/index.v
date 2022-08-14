<template>
  <div v-if="values">
    <div class="mb-3 flex justify-between items-center">
      <h1 class="dark:text-white text-2xl">{{ incModel.title }}</h1>
      <EditorActionPanel
          @on-create="createRecord"
          :model="incModel"
      />
    </div>

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
import {loadRecord} from "@/api/actionForm";
import {useRoute} from "vue-router";
import {loadList} from "@/api/actionEditor";

export default defineComponent({
  name: 'DefaultModelEditor',
  components: {EditorActionPanel, DefaultEditorTable},
  props: {
    incModel: Object
  },
  setup() {
    const route = useRoute()
    const values = ref()

    const moduleName = route.params.module.toString()
    const modelName = route.params.model.toString()

    onMounted(async () => {
      values.value = await loadList(moduleName, modelName)
    })

    const selectRecord = (recordId) => {
      router.push({ name: 'module', params: { id: recordId } })
    }

    const createRecord = () => {
      router.push({ name: 'module', params: { id: 0 } })
    }

    return {
      selectRecord,
      createRecord,
      values
    }
  }
})
</script>

<style scoped>

</style>