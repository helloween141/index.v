import axios from "axios";
import {APISettings} from "./config.js"

export const loadRecord = async (moduleName: string, modelName: string, id: number|string) => {
    try {
        const response = await axios.get(APISettings.baseURL + `/record/${moduleName}/${modelName}/${id}`)
        return response.data
    } catch (error) {
        console.error(error)
    }
}

export const saveRecord = async (moduleName: string, modelName: string, formData: object) => {
    return await axios.post(APISettings.baseURL + `/${moduleName}/${modelName}/save`, formData)
}

export const deleteRecord = async (moduleName: string, modelName: string, id: number|string) => {
    return await axios.get(APISettings.baseURL + `/${moduleName}/${modelName}/delete/${id}`)
}
