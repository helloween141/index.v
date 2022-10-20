<template>
  <div>
    <div class="block p-6 w-full bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
      <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Мой профиль</h5>
      <form v-if="modelInterface && currentValues">
        {{ currentValues }}

        <DefaultFieldsTable
          :fields="modelInterface.fields"
          :values="currentValues"
          @set-value="setValue"
        />

        <div class="flex justify-end">
          <button type="submit" @click.prevent="onSave"
                  class="mt-5 bg-green-500 float-right hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
          <span class="text-white">
            Сохранить
          </span>
          </button>
        </div>

      </form>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, onMounted, ref} from "vue";
import {loadInterface} from "@/api/actionEditor";
import DefaultFieldsTable from "@/components/ui/tables/DefaultFieldsTable.vue";
import {useUserStore} from "@/stores/user";
import axios from "axios";
import {APISettings} from "@/api/config";
import {useToast} from "vue-toastification";
import {APIMessage} from "@/api/messages";
import router from "@/router";
import {prepareFormData} from "@/utils/utils";

export default defineComponent({
  components: {DefaultFieldsTable},
  setup() {
    const toast = useToast()
    const userStore = useUserStore()
    const currentValues = ref(null)
    const modelInterface = ref(null)

    onMounted(async () => {
      modelInterface.value = await loadInterface('Vpanel', 'User')
      currentValues.value = {...currentValues.value, ...userStore.user }
    })

    const setValue = (fieldName: string, fieldValue: any) => {
      currentValues.value[fieldName] = fieldValue
    }

    const onSave = async () => {
      try {
        const formData = prepareFormData(currentValues.value)
        await axios.post(APISettings.baseURL + `/user/update`, formData)
        router.go(0)
      } catch (error) {
        toast.error(APIMessage.ERROR_SAVE)
        console.error(error)
      }
    }

    return {
      currentValues,
      modelInterface,
      setValue,
      onSave
    }

  }
})
</script>
