<template>
  <div v-if="currentValues" class="relative overflow-x-auto block p-6 w-full bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
    <form>
      <span class="block mb-5">{{currentValues}}</span>

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

      <section>
        <DefaultFieldsTable
            :fields="incModel.fields"
            :values="currentValues"
            @set-value="setValue"
        />

        <div class="mt-3">
          <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Роли</h3>
          <ul class="w-48 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <li v-for="role in allRoles" class="w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600">
              <div class="flex items-center pl-3">
                <input :id="role.name"
                       type="checkbox"
                       :value="role.name"
                       v-model="checkedRoles"
                       :checked="checkedRoles[role.name]"
                       @change="onCheckRole($event)"
                       class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                />
                <label :for="role.name"
                       class="py-3 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300">
                  {{role.name}}
                </label>
              </div>
            </li>
          </ul>
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
import {getRouteParameters, prepareFormData, setDefaultFieldsValues} from "@/utils/utils";
import FormTabPanel from "@/components/ui/FormTabPanel.vue";
import ModuleView from "@/views/ModuleView.vue";
import ModuleComponent from "@/components/ModuleComponent.vue";
import {loadList} from "@/api/actionEditor";

export default defineComponent({
  name: 'UserModelForm',
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
    const currentValues = ref(
        setDefaultFieldsValues(props.incModel.fields, props.incValues)
    )
    const checkedRoles = ref(
        currentValues.value['role'] ? JSON.parse(currentValues.value['role']) : []
    )
    const allRoles = ref()

    onMounted( async () => {
      allRoles.value = await loadList('Vpanel', 'Role')
      currentValues.value = {...currentValues.value, ...route.query}
    })

    const onSave = async () => {
      const formData = prepareFormData(currentValues.value)

      const id = await saveRecord(
          moduleName,
          modelName,
          !props.incModel.single ? recordId : 1,
          formData
      )

      if (id) {
        toast.success(APIMessage.SUCCESS_SAVE)
        if (id === recordId) {
          emit('reload', moduleName, modelName, recordId)
        } else if (!props.incModel.single) {
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

    const onCheckRole = () => {
      currentValues.value = {...currentValues.value, 'role': JSON.stringify(checkedRoles.value)}
    }

    return {
      onSave,
      onDelete,
      onBack,
      onCheckRole,
      setValue,
      currentValues,
      allRoles,
      checkedRoles
    }
  },
})
</script>

<style scoped>

</style>
