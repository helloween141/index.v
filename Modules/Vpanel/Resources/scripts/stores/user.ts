import {defineStore} from 'pinia'
import axios from "axios";
import {APISettings} from "@/api/config";

export interface User {
    id: number | 0,
    name: string | '',
    email: string | ''
}

export interface UserState {
    auth: boolean | false,
    user: User
}

export const useUserStore = defineStore({
    id: 'userStore',
    state: (): UserState => <UserState>({
        auth: false,
        user: {}
    }),
    actions: {
        async getUserData() {
            try {
                const userInfo = await axios.get(APISettings.baseURL + `/user/get-info`)
                this.auth = true
                this.user = userInfo.data
            } catch (error) {
                this.auth = false
                this.user = {}
                console.error(error)
            }
        }
    }
})
