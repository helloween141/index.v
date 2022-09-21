<template>
  <div v-if="currentValues" class="relative overflow-x-auto block p-6 w-full bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
    <form>
      <!--<span class="block mb-5">{{currentValues}}</span>
      <span>{{incModel}}</span>-->

      <div class="mb-3 flex justify-between flex-wrap">
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

      <FormTabPanel v-if="currentValues.id && tabs"
                    :tabs="tabs"
                    @select-tab="selectTab"
      />
      <div v-else class="w-full border-t dark:border-gray-700 mb-5"></div>

      <ModuleComponent v-if="currentTab"
          :module="currentTab.module"
          :model="currentTab.model"
          :show-action-panel="false"
      />
      <DefaultFieldsTable
          v-else
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
import {getModelTabs, getRouteParameters, prepareFormData, setDefaultFieldsValues} from "@/utils/utils";
import FormTabPanel from "@/components/ui/FormTabPanel.vue";
import ModuleView from "@/views/ModuleView.vue";
import ModuleComponent from "@/components/ModuleComponent.vue";

export default defineComponent({
  name: 'ModuleForm',
  components: {ModuleComponent, ModuleView, FormTabPanel, DefaultFieldsTable, FormActionPanel},
  props: {
    incModel: Object,
    incValues: Object
  },
  emits: ['reload'],
  setup(props, {emit}) {
    const toast = useToast()
    const route = useRoute()
    const currentValues = ref(setDefaultFieldsValues(props.incModel.fields, props.incValues))
    const tabs = ref([])
    const currentTab = ref(null)
    const {moduleName, modelName, recordId} = getRouteParameters(route)

    onMounted(async () => {
      const childModels = props.incModel?.childModel || []
      tabs.value = getModelTabs(childModels)
    })

    // TODO: Refactoring
    const selectTab = (selectedTab: any) => {
      currentTab.value = selectedTab.model ? selectedTab : null

      tabs.value.forEach((tab, index) => {
        tabs.value[index].active = tab.model === selectedTab.model
      })
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
      tabs,
      currentTab
    }
  },
})
</script>

<style scoped>

</style>
