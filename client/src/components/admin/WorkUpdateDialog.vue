<script setup lang="ts">
import type { CreateEducation, Work, WorkRequest } from '@/types/types.ts'
import { computed, reactive, ref, watch } from 'vue'
import { format, parseISO } from 'date-fns'

interface Props {
    work: Work
}

interface Emits {
    (e: 'close'): void
    (e: 'update', payload: WorkRequest, id: number): void
}

const props = defineProps<Props>()
const emits = defineEmits<Emits>()

const work = reactive<Partial<WorkRequest>>({})
const isFormValid = ref<boolean>(false)
const startDate = ref<Date | null>(null)
const endDate = ref<Date | null>(null)

const stringRules = [
    (value: string) => !!value || 'This field is required',
    (value: string) => value.length >= 3 || 'This field must be at least 3 characters long',
]

const startDateRules = computed(() => [
    (value: Date) => !!value || 'Start date is required',
    (value: Date) => value < new Date() || 'Start date must be in the past',
    (value: Date) =>
        !endDate.value || value <= endDate.value || 'Start date must be before end date',
])

const endDateRules = computed(() => [
    (value: Date) =>
        !value ||
        !startDate.value ||
        value >= startDate.value ||
        'End date must be after start date',
])

const handleCancel = () => {
    emits('close')
}

const handleUpdate = () => {
    if (!isFormValid.value) {
        return
    }

    const payload: WorkRequest = {
        job_title: work.job_title,
        job_description: work.job_description,
        company: work.company,
        start_date: format(startDate.value, 'yyyy-MM-dd'),
        end_date: endDate.value ? format(endDate.value, 'yyyy-MM-dd') : null,
    }

    emits('update', payload)
}

watch(
    () => props.work,
    () => {
        work.job_title = props.work.job_title
        work.job_description = props.work.job_description
        work.company = props.work.company
        startDate.value = parseISO(props.work.start_date)
        endDate.value = props.work.end_date ? parseISO(props.work.end_date) : null
    },
    { deep: true, immediate: true },
)
</script>

<template>
    <v-card rounded="lg">
        <v-card-title class="text-center mt-5 mb-10">
            <span class="text-[#2475c8] text-[30px] font-bold">Update Work</span>
        </v-card-title>

        <v-card-text>
            <v-form v-model="isFormValid" @submit.prevent="handleUpdate">
                <v-text-field
                    v-model="work.job_title"
                    label="Job Title"
                    persistent-placeholder
                    variant="underlined"
                    color="primary"
                    class="login-input mt-5"
                    :rules="stringRules"
                />

                <v-text-field
                    v-model="work.company"
                    label="Company Name"
                    persistent-placeholder
                    variant="underlined"
                    color="primary"
                    class="login-input mt-5"
                    :rules="stringRules"
                />

                <v-date-input
                    v-model="startDate"
                    label="Start Date"
                    persistent-placeholder
                    placeholder=""
                    variant="underlined"
                    color="primary"
                    class="login-input mt-5"
                    icon-color="primary"
                    :rules="startDateRules"
                    clearable
                />

                <v-date-input
                    v-model="endDate"
                    label="End Date"
                    persistent-placeholder
                    placeholder=""
                    variant="underlined"
                    color="primary"
                    class="login-input mt-5"
                    icon-color="primary"
                    :rules="endDateRules"
                    clearable
                />

                <v-textarea
                    v-model="work.job_description"
                    label="Job Description"
                    persistent-placeholder
                    variant="underlined"
                    color="primary"
                    class="login-input mt-5"
                    :rules="stringRules"
                />

                <div class="flex justify-center">
                    <v-card-actions class="mt-3 pb-4">
                        <div class="flex gap-10">
                            <v-btn
                                text="Cancel"
                                size="large"
                                color="error"
                                variant="outlined"
                                @click="handleCancel"
                                rounded="lg"
                            ></v-btn>

                            <v-btn
                                type="submit"
                                text="Update"
                                size="large"
                                color="primary"
                                variant="outlined"
                                rounded="lg"
                            ></v-btn>
                        </div>
                    </v-card-actions>
                </div>
            </v-form>
        </v-card-text>
    </v-card>
</template>

<style scoped>
.login-input::v-deep(.v-field-label) {
    font-size: 1.1rem;
    color: #ced0d1;
}

.login-input::v-deep(.v-field-label.v-field-label--floating) {
    color: #4695e5;
    font-weight: 550;
    translate: 0 -1rem;
    font-size: 1.3rem;
}

.login-input ::v-deep(input) {
    font-size: 1.1rem;
    padding-bottom: 0.5rem;
    color: #ced0d1;
}
</style>
