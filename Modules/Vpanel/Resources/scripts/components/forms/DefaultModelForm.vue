<template>
  <div v-if="currentValues" class="relative overflow-x-auto block p-6 w-full bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
    <form @submit.prevent="onSave">
      <span class="block mb-5">{{currentValues}}</span>
      <span>{{incModel}}</span>

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

      <FormTabPanel v-if="tabs"
                    @select-tab="selectTab"
                    :tabs="tabs"
      />
      <div v-else class="w-full border-t dark:border-gray-700 mb-5"></div>

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
import {saveRecord, deleteRecord} from "@/api/actionForm";
import DefaultFieldsTable from "@/components/ui/tables/DefaultFieldsTable.vue";
import {useToast} from "vue-toastification";
import {APIMessage} from "@/api/messages";
import {getRouteParameters, parseModelPath, prepareFormData, setDefaultFieldsValues} from "@/utils/utils";
import FormTabPanel from "@/components/ui/FormTabPanel.vue";
import {loadInterface} from "@/api/actionEditor";

export default defineComponent({
  name: 'ModuleForm',
  components: {FormTabPanel, DefaultFieldsTable, FormActionPanel},
  props: {
    incModel: Object,
    incValues: Object
  },
  emits: ['reload'],
  setup(props, {emit}) {
    const toast = useToast()
    const route = useRoute()
    const {moduleName, modelName, recordId} = getRouteParameters(route)
    let currentValues = ref(setDefaultFieldsValues(props.incModel.fields, props.incValues))
    const tabs = ref([])

    // TODO: Refactoring
    onMounted(async () => {
      const childModels = props.incModel.childModel
      if (childModels) {
        const interfaces = []
        for (const childModel of childModels) {
          const path = parseModelPath(childModel.model)
          const interfaceItem = await loadInterface(path.module, path.model)
          console.log(interfaceItem)
          if (childModel.tab) {
            tabs.value.push({
              name: path.model,
              title: interfaceItem.title
            })
          }
          interfaces.push(interfaceItem)
        }
        if (tabs.value.length > 0) {
          tabs.value.unshift({
            title: 'Основная информация',
            name: '',
            active: true
          })
        }
      }
    })

    const selectTab = (name: string) => {
      const tab = tabs.value.find(tab => tab.name === name)
      if (tab) {

      }
    }

    const onSave = async () => {
      const formData = prepareFormData(currentValues.value)
      const id = await saveRecord(moduleName, modelName, recordId, formData)

      if (id) {
        toast.success(APIMessage.SUCCESS_SAVE)
        if (id === recordId) {
          emit('reload', moduleName, modelName, recordId)
        } else {
          await router.push({name: 'module', params: {'module': moduleName, 'model': modelName, id}})
        }
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

    const setValue = (fieldName: string, fieldValue: any) => {
      currentValues.value[fieldName] = fieldValue
    }

    return {
      onSave,
      onDelete,
      onBack,
      setValue,
      selectTab,
      currentValues,
      tabs
    }
  },
})
</script>

<style scoped>

</style>
