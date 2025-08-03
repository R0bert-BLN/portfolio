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
            console.log(profile)
        } catch (error) {
            throw error
        }
    }

    return {
        profile,
        getProfile,
    }
})
