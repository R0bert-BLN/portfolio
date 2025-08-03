<script setup lang="ts">
import type { Profile } from "@/types/types.ts";
import {reactive, ref} from "vue";

interface Props {
    profile: Profile
}

interface Emits {
    (e: 'close'): void,
    (e: 'update', data: Partial<Profile>): void
}

const props = defineProps<Props>()
const emits = defineEmits<Emits>()

const profile = reactive<Partial<Profile>>(JSON.parse(JSON.stringify(props.profile)))
const resume = ref<Array<File>>([]);

const handleCancel = () => {
    emits('close');
}

const handleUpdate = () => {
    emits('update', JSON.parse(JSON.stringify(profile)))
}
</script>

<template>
    <v-card>
        <v-card-title class="text-center mt-5 mb-10">
            <span class="text-[#2475c8] text-[30px] font-bold">Edit Profile</span>
        </v-card-title>

        <v-card-text>
            <v-form>
                <v-row>
                    <v-col cols="12" lg="6">
                        <v-text-field
                            v-model="profile.first_name"
                            label="First Name"
                            persistent-placeholder
                            variant="underlined"
                            color="primary"
                            class="login-input mt-5"
                        />
                    </v-col>

                    <v-col cols="12" lg="6">
                        <v-text-field
                            v-model="profile.last_name"
                            label="Last Name"
                            persistent-placeholder
                            variant="underlined"
                            color="primary"
                            class="login-input mt-5"
                        />
                    </v-col>
                </v-row>

                <v-text-field
                    v-model="profile.job_title"
                    label="Job Title"
                    persistent-placeholder
                    variant="underlined"
                    color="primary"
                    class="login-input mt-5"
                />

                <v-row>
                    <v-col cols="12" lg="6">
                        <v-text-field
                            v-model="profile.github_link"
                            label="Github Link"
                            persistent-placeholder
                            variant="underlined"
                            color="primary"
                            class="login-input mt-5"
                        />
                    </v-col>

                    <v-col cols="12" lg="6">
                        <v-text-field
                            v-model="profile.linkedin_link"
                            label="Linkedin Link"
                            persistent-placeholder
                            variant="underlined"
                            color="primary"
                            class="login-input mt-5"
                        />
                    </v-col>
                </v-row>

                <v-file-input
                    v-model="resume"
                    label="Resume"
                    active
                    variant="underlined"
                    color="primary"
                    class="login-input mt-5"
                    icon-color="primary"
                />

                <v-textarea
                    v-model="profile.description"
                    label="Description"
                    persistent-placeholder
                    variant="underlined"
                    color="primary"
                    class="login-input mt-5"
                />
            </v-form>
        </v-card-text>

        <div class="flex justify-center">
            <v-card-actions class="mt-5 pb-10">
                <div class="flex gap-5">
                    <v-btn
                        text="Cancel"
                        size="large"
                        color="error"
                        variant="outlined"
                        @click="handleCancel"
                    ></v-btn>

                    <v-btn
                        text="Update"
                        size="large"
                        color="primary"
                        variant="outlined"
                        @click="handleUpdate"
                    ></v-btn>
                </div>
            </v-card-actions>
        </div>
    </v-card>
</template>

<style scoped>
.login-input::v-deep(.v-field-label) {
    font-size: 1rem;
    color: #ced0d1;
}

.login-input::v-deep(.v-field-label.v-field-label--floating) {
    color: #4695e5;
    font-weight: 550;
    translate: 0 -1rem;
    font-size: 1.3rem;
}

.login-input ::v-deep(input) {
    font-size: 1rem;
    padding-bottom: 0.5rem;
    color: #ced0d1;
}
</style>
