<template>
  <div v-if="currentValues" class="relative overflow-x-auto">
    <form @submit.prevent="onSave">
      <span class="text-white">{{currentValues}}</span>

      <div class="mb-3 flex justify-between items-center flex-wrap">
        <h1 class="dark:text-white text-2xl">
          <span v-if="currentValues.id">
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
          :values="currentValues"
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
import {getRouteParameters, prepareFormData, setDefaultFieldsValues} from "@/utils/utils";
import {loadList} from "@/api/actionEditor";

export default defineComponent({
  name: 'ModuleForm',
  components: {DefaultFieldsTable, FormActionPanel},
  props: {
    incModel: Object,
    incValues: Object
  },
  setup(props) {
    const toast = useToast()
    const route = useRoute()
    const {moduleName, modelName, recordId} = getRouteParameters(route)
    let currentValues = ref(setDefaultFieldsValues(props.incModel.fields, props.incValues))

    const onSave = async () => {
      const formData = prepareFormData(currentValues.value)
      const newId = await saveRecord(moduleName, modelName, formData)
      alert(newId)
      if (newId) {
        toast.success(APIMessage.SUCCESS_SAVE)
        await router.push({name: 'module', params: {'module': moduleName, 'model': modelName, id: newId}})
      }
    }

    const onDelete = async () => {
      await deleteRecord(moduleName, modelName, recordId)
      toast.success(APIMessage.SUCCESS_DELETE);
      await router.push({name: 'module', params: {'module': moduleName, 'model': modelName}})
    }

    const onBack = () => {
      router.push({name: 'module', params: {'module': moduleName, 'model': modelName}})
    }

    const setValue = (fieldName, fieldValue) => {
      currentValues.value[fieldName] = fieldValue
    }

    return {
      onSave,
      onDelete,
      onBack,
      setValue,
      currentValues
    }
  },
})
</script>

<style scoped>

</style>
