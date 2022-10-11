import axios from "axios";
import {APISettings} from "./config.js"
import {APIMessage} from "@/api/messages";
import {useToast} from "vue-toastification";

const toast = useToast()

export const loadRecord = async (moduleName: string, modelName: string, id: number) => {
    try {
        const response = await axios.get(APISettings.baseURL + `/${moduleName}/${modelName}/record/${id}`)
        return response.data
    } catch (error) {
        toast.error(APIMessage.ERROR_LOAD_DATA)
        console.error(error)
    }
}

export const saveRecord = async (moduleName: string, modelName: string, id: number, formData: object) => {
    try {
        const response = await axios.post(APISettings.baseURL + `/${moduleName}/${modelName}/save/${id}`, formData)
        return response.data.recordId
    } catch (error) {
        toast.error(APIMessage.ERROR_SAVE)
        console.error(error)
    }
}

export const deleteRecord = async (moduleName: string, modelName: string, id: number) => {
    try {
        const response = await axios.get(APISettings.baseURL + `/${moduleName}/${modelName}/delete/${id}`)
        return response.data
    } catch (error) {
        toast.error(APIMessage.ERROR_DELETE)
        console.error(error)
    }
}
