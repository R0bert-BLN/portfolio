import { defineStore } from 'pinia'
import { ref } from 'vue'
import type { Work } from '@/types/types.ts'
import axios from '@/plugins/axios.ts'

export const useWorkStore = defineStore('WorkStore', () => {
    const works = ref<Array<Partial<Work>>>([])

    const getAllWorks = async (): Promise<void> => {
        try {
            const response = await axios.get<Array<Partial<Work>>>('/api/work-experience')
            works.value = response.data
        } catch (error) {
            throw error
        }
    }

    const createWork = async (payload: Record<string, string>): Promise<void> => {
        try {
            const response = await axios.post<Partial<Work>>('/api/admin/work-experience', payload)
            works.value.push(response.data)
        } catch (error) {
            throw error
        }
    }

    const deleteWork = async (id: number): Promise<void> => {
        try {
            await axios.delete(`/api/admin/work-experience/${id}`)
            works.value = works.value.filter((work) => work.id !== id)
        } catch (error) {
            throw error
        }
    }

    const updateWork = async (payload: Record<string, string>, id: number): Promise<void> => {
        try {
            const response = await axios.patch<Partial<Work>>(
                `/api/admin/work-experience/${id}`,
                payload,
            )
            works.value = works.value.map((work) => {
                if (work.id === id) {
                    return response.data
                }

                return work
            })
        } catch (error) {
            throw error
        }
    }

    const updateDisplayOrder = async (payload: Array): Promise<void> => {
        try {
            await axios.patch('/api/admin/work-experience/update-order', payload)
            await getAllWorks()
        } catch (error) {
            throw error
        }
    }

    return {
        works,
        getAllWorks,
        createWork,
        deleteWork,
        updateWork,
        updateDisplayOrder,
    }
})
