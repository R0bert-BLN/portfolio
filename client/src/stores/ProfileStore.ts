import { defineStore } from 'pinia'
import { reactive } from 'vue'
import type { Profile } from '@/types/types.ts'
import axios from '@/plugins/axios.ts'

export const useProfileStore = defineStore('ProfileStore', () => {
    const profile = reactive<Partial<Profile>>({})

    const getProfile = async (): Promise<void> => {
        try {
            const response = await axios.get('/api/profile')
            Object.assign(profile, response.data)
        } catch (error) {
            throw error
        }
    }

    const editProfile = async (form: FormData): Promise<void> => {
        try {
            const response = await axios.post('/api/admin/profile', form)
            Object.assign(profile, response.data)
        } catch (error) {
            throw error
        }
    }

    return {
        profile,
        getProfile,
        editProfile,
    }
})
