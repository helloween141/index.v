import axios from "axios";
import {APISettings} from "./config.js"

export const loadInterface = async (moduleName: string, modelName: string) => {
    try {
        const response = await axios.get(APISettings.baseURL + `/interface/${moduleName}/${modelName}`)
        return response.data
    } catch (error) {
        console.error(error)
    }
}

export const loadList = async (moduleName: string, modelName: string) => {
    try {
        const response = await axios.get(APISettings.baseURL + `/list/${moduleName}/${modelName}`)
        return response.data
    } catch (error) {
        console.error(error)
    }
}

export const loadRecord = async (moduleName: string, modelName: string, recordId: string|number) => {
    try {
        const response = await axios.get(APISettings.baseURL + `/record/${moduleName}/${modelName}/${recordId}`)
        return response.data
    } catch (error) {
        console.error(error)
    }
}


