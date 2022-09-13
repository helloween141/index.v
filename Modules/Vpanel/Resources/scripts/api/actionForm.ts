import axios from "axios";
import {APISettings} from "./config.js"
import {APIMessage} from "@/api/messages";
import {useToast} from "vue-toastification";

const toast = useToast()

export const loadRecord = async (moduleName: string, modelName: string, id: number | string) => {
    try {
        const response = await axios.get(APISettings.baseURL + `/record/${moduleName}/${modelName}/${id}`)
        return response.data
    } catch (error) {
        toast.error(APIMessage.ERROR_LOAD_DATA)
        console.error(error)
    }
}

export const saveRecord = async (moduleName: string, modelName: string, formData: object) => {
    try {
        const response = await axios.post(APISettings.baseURL + `/${moduleName}/${modelName}/save`, formData)
        return response.data.recordId
    } catch (error) {
        toast.error(APIMessage.ERROR_SAVE_DATA)
        console.error(error)
    }
}

export const deleteRecord = async (moduleName: string, modelName: string, id: number | string) => {
    try {
        const response = await axios.get(APISettings.baseURL + `/${moduleName}/${modelName}/delete/${id}`)
        return response.data
    } catch (error) {
        toast.error(APIMessage.ERROR_DELETE)
        console.error(error)
    }
}
