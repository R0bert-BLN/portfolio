<script setup lang="ts">
import { useProfileStore } from '@/stores/ProfileStore.ts'
import {onMounted, ref, type Ref} from 'vue'
import { storeToRefs } from 'pinia'
import type { Profile } from '@/types/types.ts'
import useLoader from '@/composables/useLoader.ts'
import EditProfileDialog from '@/components/admin/EditProfileDialog.vue'
import PageHeader from "@/components/admin/PageHeader.vue";

const profileStore = useProfileStore()
const loader = useLoader()
const storeRefs = storeToRefs(profileStore)

const profile: Ref<Partial<Profile>> = storeRefs.profile
const showDialog = ref<boolean>(false)
const snackbarShow = ref<boolean>(false)
const snackbarMessage = ref<string>('')
const snackbarColor = ref<string>('')
const snackbarTimeout = ref<number>(2000)

const handleClose = () => {
    showDialog.value =false;
}

const handleUpdate = async (form: FormData) => {
    handleClose();
    loader.show();

    try {
        await profileStore.editProfile(form);

        snackbarShow.value = true;
        snackbarMessage.value = 'Profile updated successfully';
        snackbarColor.value = 'success';
    } catch (error) {
        console.error(error);

        snackbarShow.value = true;
        snackbarMessage.value = 'Failed to update profile';
        snackbarColor.value = 'error';
    } finally {
        loader.hide();
    }
}

const fetchProfile = async () => {
    loader.show()

    try {
        await profileStore.getProfile()
    } catch (error) {
        console.error(error)
    } finally {
        loader.hide()
    }
}

onMounted(async () => {
    await fetchProfile()
})
</script>

<template>
    <div class="mx-16 mt-16 pt-8 px-5 pb-16">
        <v-snackbar class="mt-10" v-model="snackbarShow" :color="snackbarColor" :timeout="snackbarTimeout" location="top">
            <span class="font-semibold text-[18px]">{{ snackbarMessage }}</span>

            <template v-slot:actions>
                <v-btn color="white" icon="mdi-close" variant="text" @click="snackbarShow = false"></v-btn>
            </template>
        </v-snackbar>

        <v-card flat color="transparent">
            <v-card-title>
                <PageHeader>
                    <template v-slot:title>Profile</template>

                    <template v-slot:actions>
                        <v-dialog v-model="showDialog" max-width="800" transition="scale-transition" persistent>
                            <template v-slot:activator="{ props: activatorProps }">
                                <v-btn
                                    color="primary"
                                    variant="outlined"
                                    rounded="lg"
                                    v-bind="activatorProps"
                                >
                                    <span class="font-semibold text-[16px]">EDIT</span>
                                </v-btn>
                            </template>

                            <template v-slot:default>
                                <EditProfileDialog :profile="profile" @close="handleClose" @update="handleUpdate" />
                            </template>
                        </v-dialog>
                    </template>
                </PageHeader>
            </v-card-title>

            <v-overlay
                v-if="loader.isLoading.value"
                class="flex justify-center items-center"
                color="primary"
                persistent
                :model-value="loader.isLoading.value"
            >
                <v-progress-circular
                    size="60"
                    width="5"
                    indeterminate
                    color="primary"
                ></v-progress-circular>
            </v-overlay>

            <v-card-text v-else class="mt-16 pt-10">
                <div class="flex flex-col gap-10">
                    <div class="flex justify-center gap-10">
                        <v-avatar color="primary" size="150" variant="text" >
                            <v-img v-if="profile.picture_url" :src="profile.picture_url"></v-img>

                            <v-icon v-else size="150" icon="mdi-account-circle"></v-icon>
                        </v-avatar>

                        <div>
                            <h2 class="text-[#2475c8] text-[30px] font-bold">
                                {{ profile.first_name }} {{ profile.last_name }}
                            </h2>
                            <h3 class="text-[#ced0d1] text-[25px] font-bold mt-2">
                                {{ profile.job_title }}
                            </h3>

                            <div class="flex gap-5 mt-5">
                                <v-chip
                                    link
                                    color="primary"
                                    :href="profile.github_link"
                                    target="_blank"
                                    variant="outlined"
                                    prepend-icon="mdi-github"
                                >
                                    <span class="font-semibold">GitHub</span>
                                </v-chip>
                                <v-chip
                                    link
                                    color="primary"
                                    :href="profile.linkedin_link"
                                    target="_blank"
                                    variant="outlined"
                                    prepend-icon="mdi-linkedin"
                                >
                                    <span class="font-semibold">LinkedIn</span>
                                </v-chip>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <p class="w-4/6 text-[#ced0d1] text-[20px] mt-5 text-center">
                            {{ profile.description }}
                        </p>
                    </div>

                    <div class="flex justify-center mt-10">
                        <v-btn :href="profile.cv_url" target="_blank" color="primary" variant="outlined" size="large" rounded="lg">View Resume</v-btn>
                    </div>
                </div>
            </v-card-text>
        </v-card>
    </div>
</template>
