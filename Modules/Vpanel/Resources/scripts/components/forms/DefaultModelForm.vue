<template>
  <div v-if="currentValues" class="relative overflow-x-auto block p-6 w-full bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
    <form>
      <span class="block mb-5">{{currentValues}}</span>
      <!--<span>{{incModel}}</span>-->

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

      <div class="w-full border-t dark:border-gray-700"></div>

      <section v-if="tabs.length > 0 && currentValues.id > 0">
        <FormTabPanel
            :tabs="tabs"
            @select-tab="selectTab"
        />
        <ModuleComponent
            v-if="modelTab"
            :module="modelTab.module"
            :model="modelTab.model"
            :default-filter="modelTab.filter"
            :is-child="true"
        />
        <DefaultFieldsTable
            v-else
            :fields="incModel.fields"
            :values="currentValues"
            @set-value="setValue"
        />
      </section>

      <section v-else>
        <DefaultFieldsTable
            :fields="incModel.fields"
            :values="currentValues"
            @set-value="setValue"
        />
        <div v-if="currentValues.id > 0">
          <div v-for="additionalModel in additionalModels" class="mt-5">
            <ModuleComponent
                :module="additionalModel.module"
                :model="additionalModel.model"
                :default-filter="additionalModel.filter"
                :is-child="true"
            />
          </div>
        </div>
      </section>

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
import {getAdditionalModels, getModelTabs, getRouteParameters, prepareFormData, setDefaultFieldsValues} from "@/utils/utils";
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
    const {moduleName, modelName, recordId} = getRouteParameters(route)
    const currentValues = ref(setDefaultFieldsValues(props.incModel.fields, props.incValues))
    const additionalModels = ref(getAdditionalModels(props.incModel.childModel, currentValues.value.id))
    const tabs = ref(getModelTabs(props.incModel.childModel, currentValues.value.id))
    const modelTab = ref()

    onMounted( () => {
      setActiveTab(route.query.tab || '')

      currentValues.value = {...currentValues.value, ...route.query}
    })

    const selectTab = (selectedTab: any) => {
      setActiveTab(selectedTab.model)

      if (selectedTab.model) {
        router.push({
          path: route.path,
          query: {
            tab: selectedTab.model
          }
        })
      } else {
        router.replace({query: {}})
      }
    }

    const setActiveTab = (activeTab) => {
      tabs.value.forEach((tab, index) => {
        if (tab.model === activeTab) {
          tabs.value[index].active = true
          modelTab.value = tab.model ? tab : null
        } else {
          tabs.value[index].active = false
        }
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
      router.back()
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
      modelTab,
      additionalModels
    }
  },
})
</script>

<style scoped>

</style>
