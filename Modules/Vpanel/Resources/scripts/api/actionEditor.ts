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


