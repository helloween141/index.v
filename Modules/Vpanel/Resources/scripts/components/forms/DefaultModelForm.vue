<template>
  <div class="relative overflow-x-auto">
    <span class="text-white">{{values}}</span>

    <form @submit.prevent="onSave">
      <div class="mb-3 flex justify-between items-center flex-wrap">
        <h1 class="dark:text-white text-2xl">
          <span v-if="values.id">
            Редактировать {{ model.accusativeRecordTitle }}
          </span>
          <span v-else>
            Создать {{ model.accusativeRecordTitle }}
          </span>
        </h1>
        <FormActionPanel
            :model="model"
            @on-save="onSave"
            @on-delete="onDelete"
            @on-back="onBack"
        />
      </div>

      <DefaultFieldsTable
          :fields="model.fields"
          :values="values"
          @set-value="setValue"
      />

      <div class="mt-3 flex justify-end">
        <FormActionPanel
            :model="model"
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
import {defineComponent, ref} from "vue";
import {useRoute} from "vue-router";
import {saveRecord, deleteRecord} from "@/api/actionForm";
import DefaultFieldsTable from "@/components/ui/tables/DefaultFieldsTable.vue";
import axios from "axios";
import {APISettings} from "@/api/config";
import {useToast} from "vue-toastification";

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
    const model = ref(props.incModel || {})
    const values = ref(props.incValues || {})

    const moduleName = route.params.module.toString()
    const modelName = route.params.model.toString()
    const recordId = parseInt((route.params?.id).toString()) || 0

    const prepareFormData = () => {
      const data = new FormData()
      Object.keys(values.value).forEach(key => {
        let item = values.value[key]
        if (item) {
          if (typeof item === 'object' && item.id) {
            data.append(key, item.id)
          } else {
            data.append(key, item)
          }
        }
      })
      return data
    }

    const onSave = async () => {
      try {
        const formData = prepareFormData()
        const response = await saveRecord(moduleName, modelName, formData)
        const id = response.data.id
        if (id) {
          toast.success('Данные сохранены!')
          await router.push({name: 'module', params: {'module': moduleName, 'model': modelName, id}})
        } else {
          toast.error('Ошибка сохранения!');
        }
      } catch (error) {
        console.error(error)
      }
    }

    const onDelete = async () => {
      try {
        const response = await deleteRecord(moduleName, modelName, recordId)
        if (response.data.success) {
          toast.success('Запись удалена!');
          await router.push({name: 'module', params: {'module': moduleName, 'model': modelName}})
        } else {
          toast.error('Ошибка удаления записи!');
        }
      } catch (error) {
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
      model,
      values
    }
  },
})
</script>

<style scoped>

</style>