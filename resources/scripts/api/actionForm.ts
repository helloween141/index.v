import axios from "axios";
import {APISettings} from "./config.js"
import router from "@/router";
import {useToast} from "vue-toastification";
const toast = useToast()

export const saveRecord = async (moduleName: string, modelName: string, formData: object) => {
    try {
        const response = await axios.post(APISettings.baseURL + `/${moduleName}/${modelName}/save`, formData)
        const id = response.data?.id
        if (id) {
            toast.success('Данные сохранены!')
            await router.push({ name: 'module', params: { 'module': moduleName, 'model': modelName, 'id': id } })
        } else {
            toast.error('Ошибка сохранения данных!')
        }
    } catch (error) {
        console.error(error)
    }
}

export const deleteRecord = async (moduleName: string, modelName: string, id: number|string) => {
    try {
        const response = await axios.get(APISettings.baseURL + `/${moduleName}/${modelName}/delete/${id}`)
        const success = response.data?.success

        if (success) {
            toast.success('Запись удалена!');
            await router.push({name: 'module', params: {'module': moduleName, 'model': modelName}})
        } else {
            toast.error('Ошибка удаления записи!');
        }
    } catch (error) {
        console.error(error)
    }
}
