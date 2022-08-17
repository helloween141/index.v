<template>
  <div class="relative overflow-x-auto" v-if="values">
    <form @submit.prevent="onSave">
      <span class="text-white">{{values}}</span>

      <div class="mb-3 flex justify-between items-center flex-wrap">
        <h1 class="dark:text-white text-2xl">
          <span v-if="values.id">
            Редактировать {{ incModel.accusativeRecordTitle }}
          </span>
          <span v-else>
            Создать {{ incModel.accusativeRecordTitle }}
          </span>
        </h1>
        <FormActionPanel
            :model="incModel"
            @on-save="onSave"
            @on-delete="onDelete"
            @on-back="onBack"
        />
      </div>

      <DefaultFieldsTable
          :fields="incModel.fields"
          :values="values"
          @set-value="setValue"
      />

      <div class="mt-3 flex justify-end">
        <FormActionPanel
            :model="incModel"
            @on-save="onSave"
            @on-delete="onDelete"
            @on-back="onBack"
        />
      </div>
    </form>
  </div>
</template>

<script lang="ts">
import FormActionPanel from "@/components/ui/FormActionPanel.vue";
import router from "@/router";
import {defineComponent, onMounted, ref} from "vue";
import {useRoute} from "vue-router";
import {saveRecord, deleteRecord, loadRecord} from "@/api/actionForm";
import DefaultFieldsTable from "@/components/ui/tables/DefaultFieldsTable.vue";
import {useToast} from "vue-toastification";
import {APIMessage} from "@/api/messages";
import {getRouteParameters, prepareFormData} from "@/utils/utils";

export default defineComponent({
  name: 'ModuleForm',
  components: {DefaultFieldsTable, FormActionPanel},
  props: {
    incModel: Object
  },
  setup() {
    const toast = useToast()
    const route = useRoute()
    const values = ref()

    const {moduleName, modelName, recordId} = getRouteParameters(route)

    onMounted(async () => {
      try {
        const response = await loadRecord(moduleName, modelName, recordId)
        values.value = response.data
      } catch (error) {
        toast.error(APIMessage.ERROR_LOAD_DATA)
        console.error(error)
      }
    })

    const onSave = async () => {
      try {
        const formData = prepareFormData(values.value)
        const response = await saveRecord(moduleName, modelName, formData)
        const id = response.data.id
        toast.success(APIMessage.SUCCESS_SAVE)
        await router.push({name: 'module', params: {'module': moduleName, 'model': modelName, id}})
      } catch (error) {
        toast.error(APIMessage.ERROR_SAVE_DATA)
        console.error(error)
      }
    }

    const onDelete = async () => {
      try {
        await deleteRecord(moduleName, modelName, recordId)
        toast.success(APIMessage.SUCCESS_DELETE);
        await router.push({name: 'module', params: {'module': moduleName, 'model': modelName}})
      } catch (error) {
        toast.error(APIMessage.ERROR_DELETE)
        console.error(error)
      }
    }

    const onBack = () => {
      router.push({name: 'module', params: {'module': moduleName, 'model': modelName}})
    }

    const setValue = (fieldName, fieldValue) => {
      values.value[fieldName] = fieldValue
    }

    return {
      onSave,
      onDelete,
      onBack,
      setValue,
      values
    }
  },
})
</script>

<style scoped>

</style>