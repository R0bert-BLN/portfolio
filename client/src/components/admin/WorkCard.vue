<script setup lang="ts">
import type { Work, WorkRequest } from '@/types/types.ts'
import { computed, reactive, ref, watch } from 'vue'
import DeleteConfirmation from '@/components/admin/DeleteConfirmation.vue'
import { format, parseISO } from 'date-fns'
import WorkUpdateDialog from '@/components/admin/WorkUpdateDialog.vue'
import { useMediaQuery } from '@vueuse/core'

interface Props {
    work: Partial<Work>
    index: number
}

interface Emits {
    (e: 'delete', id: number): void
    (e: 'update', payload: WorkRequest, id: number): void
}

const props = defineProps<Props>()
const emits = defineEmits<Emits>()

const work = reactive<Partial<Work>>({})
const showDialog = ref<boolean>(false)
const showDeleteDialog = ref<boolean>(false)
const isExpanded = ref<boolean>(false)

const isLargeScreen = useMediaQuery('(min-width: 1000px)')
const changeWidth = useMediaQuery('(min-width: 1350px)')
const isSmallScreen = useMediaQuery('(max-width: 600px)')

const maxLength = computed(() => {
    return isLargeScreen.value ? 100 : 50
})

const toggleExpand = () => {
    isExpanded.value = !isExpanded.value
}

const needToExpand = computed(() => {
    return work.job_description.length > maxLength.value
})

const visibleText = computed(() => {
    return needToExpand.value
        ? work.job_description.substring(0, maxLength.value)
        : work.job_description
})

const hiddenText = computed(() => {
    return needToExpand.value ? work.job_description.substring(maxLength.value) : ''
})

const period = computed(() => {
    if (!work.start_date) {
        return ''
    }

    const startDate = format(parseISO(work.start_date), 'MMMM yyyy')

    if (!work.end_date) {
        return `${startDate} - Present`
    }

    const endDate = format(parseISO(work.end_date), 'MMMM yyyy')

    return `${startDate} - ${endDate}`
})

const handleClose = () => {
    showDialog.value = false
    showDeleteDialog.value = false
}

const handleDelete = () => {
    handleClose()
    emits('delete', work.id)
}

const handleUpdate = (payload: WorkRequest) => {
    handleClose()
    emits('update', payload, work.id)
}

watch(
    () => props.work,
    (newWork) => {
        Object.assign(work, newWork)
    },
    { immediate: true, deep: true },
)
</script>

<template>
    <div
        class="mx-auto"
        :class="{ 'w-4/6': changeWidth, 'w-full': !changeWidth, 'px-4': !isLargeScreen }"
    >
        <v-card flat color="transparent">
            <div
                class="flex items-center gap-6 border-b-1 border-[#2475c8] py-2"
                :class="{ 'flex-col mb-16': isSmallScreen }"
            >
                <v-chip color="primary" variant="outlined" class="drag-handle cursor-move">
                    <span class="font-semibold text-[20px]">{{ props.index + 1 }}</span>
                </v-chip>

                <div
                    class="flex justify-between w-full"
                    :class="{ 'flex-col items-center text-center': isSmallScreen }"
                >
                    <div>
                        <v-card-title>
                            <div>
                                <span class="font-semibold text-[24px] text-[#ced0d1]">{{
                                    work.job_title
                                }}</span>
                            </div>
                        </v-card-title>

                        <v-card-text>
                            <div class="flex flex-col mt-1" :class="{ 'mr-8': !isSmallScreen }">
                                <span class="text-[#ced0d1] text-[18px]">{{ work.company }}</span>
                                <span class="text-[#ced0d1] text-[18px]">{{ period }}</span>

                                <p class="text-[#ced0d1] text-[16px] mt-4">
                                    <span
                                        >{{ visibleText
                                        }}{{ needToExpand && !isExpanded ? '...' : ' ' }}</span
                                    >
                                    <span v-show="isExpanded">{{ hiddenText }}</span>

                                    <v-btn
                                        v-if="needToExpand"
                                        size="small"
                                        color="primary"
                                        variant="plain"
                                        @click="toggleExpand"
                                        :ripple="false"
                                    >
                                        {{ isExpanded ? 'Show less' : 'Show more' }}
                                    </v-btn>
                                </p>
                            </div>
                        </v-card-text>
                    </div>

                    <v-card-actions>
                        <div class="flex">
                            <v-dialog
                                v-model="showDialog"
                                max-width="700"
                                transition="scale-transition"
                                persistent
                            >
                                <template #activator="{ props: activatorProps }">
                                    <v-btn
                                        v-bind="activatorProps"
                                        color="primary"
                                        variant="plain"
                                        :ripple="false"
                                    >
                                        <v-icon
                                            size="35"
                                            icon="mdi-square-edit-outline"
                                            color="primary"
                                        ></v-icon>
                                    </v-btn>
                                </template>

                                <template #default>
                                    <WorkUpdateDialog
                                        :work="work"
                                        @close="handleClose"
                                        @update="handleUpdate"
                                    />
                                </template>
                            </v-dialog>

                            <v-dialog
                                v-model="showDeleteDialog"
                                max-width="400"
                                transition="scale-transition"
                                persistent
                            >
                                <template #activator="{ props: activatorProps }">
                                    <v-btn color="error" variant="plain" :ripple="false">
                                        <v-icon
                                            v-bind="activatorProps"
                                            size="35"
                                            icon="mdi-delete"
                                            color="error"
                                        ></v-icon>
                                    </v-btn>
                                </template>

                                <template #default>
                                    <DeleteConfirmation
                                        @close="handleClose"
                                        @delete="handleDelete"
                                    />
                                </template>
                            </v-dialog>
                        </div>
                    </v-card-actions>
                </div>
            </div>
        </v-card>
    </div>
</template>

<style scoped></style>
