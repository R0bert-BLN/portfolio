<script setup lang="ts">
import type {Education} from "@/types/types.ts";
import {reactive, ref, watch} from "vue";
import DeleteConfirmation from "@/components/admin/DeleteConfirmation.vue";
import UpdateEducationDialog from "@/components/admin/UpdateEducationDialog.vue";

interface Props {
    education: Partial<Education>,
    index: number
}

interface Emits {
    (e: 'delete', id: number): void,
    (e: 'update', payload: Record<string, string>, id: number): void
}

const props = defineProps<Props>()
const emits = defineEmits<Emits>()

const localEducation = reactive<Partial<Education>>({})
const showDialog = ref<boolean>(false)
const showDeleteDialog = ref<boolean>(false)

const handleClose = () => {
    showDialog.value = false;
    showDeleteDialog.value = false
}

const handleDelete = () => {
    handleClose()
    emits('delete', props.education.id)
}

const handleUpdate = (payload: Record<string, string>) => {
    handleClose()
    emits('update', payload, localEducation.id)
}

watch(() => props.education, (newEducation) => {
    Object.assign(localEducation, newEducation);
}, {immediate: true, deep: true})
</script>

<template>
    <v-card width="900" flat color="transparent">
        <div class="flex items-center gap-6 border-b-1 border-[#2475c8] py-2">
            <v-chip color="primary" variant="outlined" class="drag-handle cursor-move">
                <span class="font-semibold text-[20px]">{{ props.index + 1 }}</span>
            </v-chip>

            <div class="flex justify-between w-full">
                <div>
                    <v-card-title>
                        <div>
                            <span class="font-semibold text-[24px] text-[#ced0d1]">{{ education.institution_name }}</span>
                        </div>
                    </v-card-title>

                    <v-card-text>
                        <div class="flex flex-col gap-2 mt-4">
                            <span class="text-[#ced0d1] text-[18px]">{{ education.start_date }} - {{ education.end_date ? education.end_date : 'Present' }}</span>
                            <span class="text-[#ced0d1] text-[18px]">{{ education.specialisation }}</span>
                        </div>
                    </v-card-text>
                </div>

                <v-card-actions>
                    <div class="flex">
                        <v-dialog v-model="showDialog" max-width="700" transition="scale-transition" persistent>
                            <template #activator="{ props: activatorProps }">
                                <v-btn v-bind="activatorProps" color="primary" variant="plain">
                                    <v-icon size="35" icon="mdi-square-edit-outline" color="primary"></v-icon>
                                </v-btn>
                            </template>

                            <template #default>
                                <UpdateEducationDialog :education="localEducation" @close="handleClose" @update="handleUpdate"/>
                            </template>
                        </v-dialog>

                        <v-dialog v-model="showDeleteDialog" max-width="400" transition="scale-transition" persistent>
                            <template #activator="{ props: activatorProps }">
                                <v-btn color="error" variant="plain">
                                    <v-icon v-bind="activatorProps" size="35" icon="mdi-delete" color="error"></v-icon>
                                </v-btn>
                            </template>

                            <template #default>
                                <DeleteConfirmation @close="handleClose" @delete="handleDelete"/>
                            </template>
                        </v-dialog>
                    </div>
                </v-card-actions>
            </div>
        </div>
    </v-card>
</template>

<style scoped>

</style>
