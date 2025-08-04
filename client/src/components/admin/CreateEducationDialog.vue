<script setup lang="ts">
import type {CreateEducation} from "@/types/types.ts";
import {computed, reactive, ref} from "vue";
import {format} from "date-fns";

interface Emits {
    (e: 'close'): void,
    (e: 'create', data: Record<string, string>): void
}

const emits = defineEmits<Emits>()
const education = reactive<Partial<CreateEducation>>({})
const isFormValid = ref<boolean>(false)

const institutionNameRules = [
    (value: string) => !!value || 'Institution name is required',
    (value: string) => value.length >= 3 || 'Institution name must be at least 3 characters long',
]

const specialisationRules = [
    (value: string) => !!value || 'Specialisation is required',
    (value: string) => value.length >= 3 || 'Specialisation must be at least 3 characters long',
]

const startDateRules = computed(() => [
    (value: Date) => !!value || 'Start date is required',
    (value: Date) => value < new Date() || 'Start date must be in the past',
    (value: Date) => !education.end_date || value <= new Date(education.end_date) || 'Start date must be before end date',
])

const endDateRules = computed(() => [
    (value: Date) => !value || value >= new Date(education.start_date) || 'End date must be after start date',
])

const handleCancel = () => {
    emits('close');
}

const handleCreate = () => {
    if (!isFormValid.value) {
        return;
    }

    const payload = {
        institution_name: education.institution_name,
        specialisation: education.specialisation,
        start_date: format(education.start_date, 'yyyy-MM-dd'),
        end_date: education.end_date ? format(education.end_date, 'yyyy-MM-dd') : null,
    }

    emits('create', payload);
}
</script>

<template>
    <v-card rounded="lg">
        <v-card-title class="text-center mt-5 mb-10">
            <span class="text-[#2475c8] text-[30px] font-bold">Create Education</span>
        </v-card-title>

        <v-card-text>
            <v-form v-model="isFormValid" @submit.prevent="handleCreate">
                <v-text-field
                    v-model="education.institution_name"
                    label="Institution Name"
                    persistent-placeholder
                    variant="underlined"
                    color="primary"
                    class="login-input mt-5"
                    :rules="institutionNameRules"
                />

                <v-text-field
                    v-model="education.specialisation"
                    label="Specialisation"
                    persistent-placeholder
                    variant="underlined"
                    color="primary"
                    class="login-input mt-5"
                    :rules="specialisationRules"
                />

                <v-date-input
                    v-model="education.start_date"
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
                    v-model="education.end_date"
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
                                text="Create"
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
