<script setup lang="ts">
import { useProfileStore } from '@/stores/ProfileStore.ts'
import { onMounted, ref, type Ref } from 'vue'
import { storeToRefs } from 'pinia'
import type { Profile } from '@/types/types.ts'
import { useLoaderStore } from '@/stores/LoaderStore.ts'
import ProfileEditDialog from '@/components/admin/ProfileEditDialog.vue'
import PageHeader from '@/components/admin/PageHeader.vue'
import { useMediaQuery } from '@vueuse/core'
import { useNotificationStore } from '@/stores/NotificationStore.ts'

const profileStore = useProfileStore()
const storeRefs = storeToRefs(profileStore)
const notificationStore = useNotificationStore()
const loader = useLoaderStore()

const profile: Ref<Partial<Profile>> = storeRefs.profile
const showDialog = ref<boolean>(false)
const isLargeScreen = useMediaQuery('(min-width: 1000px)')

const handleClose = () => {
    showDialog.value = false
}

const handleUpdate = async (form: FormData) => {
    handleClose()
    loader.show()

    try {
        await profileStore.editProfile(form)
        notificationStore.success('Profile updated successfully!')
    } catch (error) {
        console.error(error)
        notificationStore.error('Failed to update profile.')
    } finally {
        loader.hide()
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
    <div class="pt-8 pb-16" :class="isLargeScreen ? 'mx-16 px-5 mt-16' : 'px-2 mt-5'">
        <v-card flat color="transparent">
            <v-card-title>
                <PageHeader>
                    <template v-slot:title>Profile</template>

                    <template v-slot:actions>
                        <v-dialog
                            v-model="showDialog"
                            max-width="800"
                            transition="scale-transition"
                            persistent
                            rounded="lg"
                        >
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
                                <ProfileEditDialog
                                    :profile="profile"
                                    @close="handleClose"
                                    @update="handleUpdate"
                                />
                            </template>
                        </v-dialog>
                    </template>
                </PageHeader>
            </v-card-title>

            <v-card-text class="mt-16" :class="{ 'pt-10': isLargeScreen }">
                <div class="flex flex-col gap-10">
                    <div
                        class="flex justify-center gap-10"
                        :class="{ 'flex-col items-center': !isLargeScreen }"
                    >
                        <v-avatar color="primary" size="150" variant="text">
                            <v-img
                                v-if="profile.picture_url"
                                :src="profile.picture_url"
                                alt="Profile Picture"
                            ></v-img>

                            <v-icon v-else size="150" icon="mdi-account-circle"></v-icon>
                        </v-avatar>

                        <div :class="{ 'text-center': !isLargeScreen }">
                            <h2 class="text-[#2475c8] text-[30px] font-bold">
                                {{ profile.first_name }} {{ profile.last_name }}
                            </h2>
                            <h3 class="text-[#ced0d1] text-[25px] font-bold mt-2">
                                {{ profile.job_title }}
                            </h3>

                            <div
                                class="flex gap-5 mt-5"
                                :class="{ 'justify-center': !isLargeScreen }"
                            >
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
                        <p
                            class="w-4/6 text-[#ced0d1] text-[20px] mt-5 text-center"
                            :class="{ 'w-full': !isLargeScreen }"
                        >
                            {{ profile.description }}
                        </p>
                    </div>

                    <div class="flex justify-center mt-10">
                        <v-btn
                            :href="profile.cv_url"
                            target="_blank"
                            color="primary"
                            variant="outlined"
                            size="large"
                            rounded="lg"
                            >View Resume</v-btn
                        >
                    </div>
                </div>
            </v-card-text>
        </v-card>
    </div>
</template>
