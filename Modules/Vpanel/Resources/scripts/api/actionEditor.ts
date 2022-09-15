import axios from "axios";
import {APISettings} from "./config.js"
import {APIMessage} from "@/api/messages";
import {useToast} from "vue-toastification";

const toast = useToast()

export const loadInterface = async (moduleName: string, modelName: string) => {
    try {
        const response = await axios.get(APISettings.baseURL + `/interface/${moduleName}/${modelName}`)
        return response.data
    } catch (error) {
        toast.error(APIMessage.ERROR_LOAD_INTERFACE)
        console.error(error)
    }
}

export const loadList = async (moduleName: string, modelName: string, withPagination: boolean, filter: any = [], searchString: string = '') => {
    try {
        const response = await axios.get(APISettings.baseURL + `/list/${moduleName}/${modelName}`, {
            params: {
                'filter': JSON.stringify(filter),
                'search': searchString,
                'pagination': withPagination
            }
        })

        return response.data
    } catch (error) {
        toast.error(APIMessage.ERROR_LOAD_INTERFACE)
        console.error(error)
    }
}


