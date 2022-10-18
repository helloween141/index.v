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

        <button type="submit" @click.prevent="onSave"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-3">
          <span class="text-white">
            Сохранить
          </span>
        </button>
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

export default defineComponent({
  components: {DefaultFieldsTable},
  setup() {
    const userStore = useUserStore()
    const currentValues = ref()
    const modelInterface = ref()


    onMounted(async () => {
      modelInterface.value = await loadInterface('Vpanel', 'User')
      currentValues.value = userStore.user
    })

    const setValue = (fieldName: string, fieldValue: any) => {
      currentValues.value[fieldName] = fieldValue
    }

    const onSave = async () => {
      try {
        console.log(APISettings.baseURL + `/user/update`)
        const response = await axios.post(APISettings.baseURL + `/user/update`, {
          'name': currentValues.value.name,
          'login': currentValues.value.login,
          'email': currentValues.value.email,
          'new_password': currentValues.value.new_password,
        })

        //return response.data.recordId
      } catch (error) {
        //useToast().error(APIMessage.ERROR_SAVE)
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
