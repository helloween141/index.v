import axios from "axios";
import {APISettings} from "./config.js"
import {useToast} from "vue-toastification";
const toast = useToast()

export const loadInterface = async (moduleName: string, modelName: string) => {
    try {
        const response = await axios.get(APISettings.baseURL + `/interface/${moduleName}/${modelName}`)
        return response.data
    } catch (error) {
        toast.error('Ошибка загрузки интерфейса!')
        console.error(error)
    }
}

export const loadList = async (moduleName: string, modelName: string) => {
    try {
        const response = await axios.get(APISettings.baseURL + `/list/${moduleName}/${modelName}`)
        return response.data
    } catch (error) {
        toast.error('Ошибка загрузки данных!')
        console.error(error)
    }
}


