import {defineStore} from "pinia";
import {ref} from "vue";
import type {Education} from "@/types/types.ts";
import axios from "@/plugins/axios.ts";

export const useEducationStore = defineStore('EducationStore', () => {
    const educations = ref<Array<Partial<Education>>>([]);

    const getAllEducations = async (): Promise<void> => {
        try {
            const response = await axios.get<Array<Partial<Education>>>('/api/education');
            educations.value = response.data
        } catch (error) {
            throw error
        }
    }

    const createEducation = async (payload: Record<string, string>): Promise<void> => {
        try {
            const response = await axios.post<Partial<Education>>('/api/admin/education', payload)
            educations.value.push(response.data)
        } catch (error) {
            throw error
        }
    }

    const deleteEducation = async (id: number): Promise<void> => {
        try {
            await axios.delete(`/api/admin/education/${id}`)
            educations.value = educations.value.filter((education) => education.id !== id)
        } catch (error) {
            throw error
        }
    }

    const updateEducation = async (payload: Record<string, string>, id: number): Promise<void> => {
        try {
            const response = await axios.patch<Partial<Education>>(`/api/admin/education/${id}`, payload)
            educations.value = educations.value.map((education) => {
                if (education.id === id) {
                    return response.data
                }

                return education
            })
        } catch (error) {
            throw error
        }
    }

    return {
        educations,
        getAllEducations,
        createEducation,
        deleteEducation,
        updateEducation
    }
})
