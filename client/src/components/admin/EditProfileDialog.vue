<script setup lang="ts">
import type { Profile } from "@/types/types.ts";
import {reactive, ref, watch} from "vue";

interface Props {
    profile: Profile
}

interface Emits {
    (e: 'close'): void,
    (e: 'update', data: FormData): void
}

const props = defineProps<Props>()
const emits = defineEmits<Emits>()

const localProfile = reactive<Partial<Profile>>({})

const resumeFile = ref<File | null>(null);
const pictureFile = ref<File | null>(null);

const handleCancel = () => {
    emits('close');
}

const handleUpdate = () => {
   const formData = new FormData();

   if (resumeFile.value) {
       formData.append('cv', resumeFile.value);
   }

   if (pictureFile.value) {
       formData.append('picture', pictureFile.value);
   }

   if (localProfile.description) {
       formData.append('description', localProfile.description);
   }

   if (localProfile.first_name) {
       formData.append('first_name', localProfile.first_name);
   }

   if (localProfile.last_name) {
       formData.append('last_name', localProfile.last_name);
   }

   if (localProfile.job_title) {
       formData.append('job_title', localProfile.job_title);
   }

   if (localProfile.github_link) {
       formData.append('github_link', localProfile.github_link);
   }

   if (localProfile.linkedin_link) {
       formData.append('linkedin_link', localProfile.linkedin_link);
   }

   emits('update', formData);
}

watch(() => props.profile, (newProfile) => {
    Object.assign(localProfile, newProfile);
}, {immediate: true, deep: true})
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
                            v-model="localProfile.first_name"
                            label="First Name"
                            persistent-placeholder
                            variant="underlined"
                            color="primary"
                            class="login-input mt-5"
                        />
                    </v-col>

                    <v-col cols="12" lg="6">
                        <v-text-field
                            v-model="localProfile.last_name"
                            label="Last Name"
                            persistent-placeholder
                            variant="underlined"
                            color="primary"
                            class="login-input mt-5"
                        />
                    </v-col>
                </v-row>

                <v-text-field
                    v-model="localProfile.job_title"
                    label="Job Title"
                    persistent-placeholder
                    variant="underlined"
                    color="primary"
                    class="login-input mt-5"
                />

                <v-row>
                    <v-col cols="12" lg="6">
                        <v-text-field
                            v-model="localProfile.github_link"
                            label="Github Link"
                            persistent-placeholder
                            variant="underlined"
                            color="primary"
                            class="login-input mt-5"
                        />
                    </v-col>

                    <v-col cols="12" lg="6">
                        <v-text-field
                            v-model="localProfile.linkedin_link"
                            label="Linkedin Link"
                            persistent-placeholder
                            variant="underlined"
                            color="primary"
                            class="login-input mt-5"
                        />
                    </v-col>
                </v-row>

                <v-file-input
                    v-model="resumeFile"
                    label="Resume"
                    active
                    variant="underlined"
                    color="primary"
                    class="login-input mt-5"
                    icon-color="primary"
                />

                <v-file-input
                    v-model="pictureFile"
                    label="Profile Picture"
                    active
                    variant="underlined"
                    color="primary"
                    class="login-input mt-5"
                    icon-color="primary"
                />

                <v-textarea
                    v-model="localProfile.description"
                    label="Description"
                    persistent-placeholder
                    variant="underlined"
                    color="primary"
                    class="login-input mt-5"
                />
            </v-form>
        </v-card-text>

        <div class="flex justify-center">
            <v-card-actions class="pb-10">
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
                        text="Update"
                        size="large"
                        color="primary"
                        variant="outlined"
                        @click="handleUpdate"
                        rounded="lg"
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
