<script setup lang="ts">
import {useMediaQuery} from "@vueuse/core";
import {ref} from "vue";
import {useAuthStore} from "@/stores/AuthStore.ts";

const isLargeScreen = useMediaQuery('(min-width: 800px)');
const showMenu = ref(false);
const authStore = useAuthStore();

const handleLogout = async () => {
    try {
        await authStore.logout();
    } catch (error) {
        console.error(error);
    }
}
</script>

<template>
    <v-layout full-height>
        <v-navigation-drawer v-if="isLargeScreen" permanent floating width="240">
            <div class="flex flex-col h-full">
                <div class="px-5 py-3">
                    <h1 class="text-[#2475c8] text-[35px] text-center font-bold">Portfolio</h1>
                </div>

                <div class="my-auto">
                    <v-list nav>
                        <v-list-item  value="profile" to="/admin/profile" color="primary">
                            <template v-slot:title>
                                <span class="d-block w-100 text-center font-semibold text-[18px]">Profile</span>
                            </template>
                        </v-list-item>

                        <v-list-item value="education" to="/admin/education" color="primary">
                            <template v-slot:title>
                                <span class="d-block w-100 text-center font-semibold text-[18px]">Education</span>
                            </template>
                        </v-list-item>

                        <v-list-item value="work" to="/admin/work" color="primary">
                            <template v-slot:title>
                                <span class="d-block w-100 text-center font-semibold text-[18px]">Work</span>
                            </template>
                        </v-list-item>

                        <v-list-item value="skill" to="/admin/skill" color="primary">
                            <template v-slot:title>
                                <span class="d-block w-100 text-center font-semibold text-[18px]">Skills</span>
                            </template>
                        </v-list-item>

                        <v-list-item value="project" to="/admin/project" color="primary">
                            <template v-slot:title>
                                <span class="d-block w-100 text-center font-semibold text-[18px]">Projects</span>
                            </template>
                        </v-list-item>

                        <v-list-item value="contact" to="/admin/contact" color="primary">
                            <template v-slot:title>
                                <span class="d-block w-100 text-center font-semibold text-[18px]">Contact</span>
                            </template>
                        </v-list-item>
                    </v-list>
                </div>
            </div>

            <template v-slot:append>
                <div  class="px-3 py-2">
                    <v-btn size="large" variant="text" block color="primary" @click="handleLogout">
                        <span class="font-semibold">Logout</span>
                    </v-btn>
                </div>
            </template>
        </v-navigation-drawer>

        <v-app-bar v-else height="70">
            <v-menu v-model="showMenu">
                <template v-slot:activator="{ props }">
                    <v-app-bar-nav-icon color="primary" v-bind="props"/>
                </template>

                <v-list>
                    <v-list-item color="primary" to="/admin/profile" title="Profile" />
                    <v-list-item color="primary" to="/admin/education" title="Education" />
                    <v-list-item color="primary" to="/admin/work" title="Work" />
                    <v-list-item color="primary" to="/admin/skill" title="Skills" />
                    <v-list-item color="primary" to="/admin/project" title="Projects" />
                    <v-list-item color="primary" to="/admin/contact" title="Contact" />
                </v-list>
            </v-menu>

            <v-app-bar-title>
                <span class="font-bold text-[#2475c8] text-[20px]">Portfolio</span>
            </v-app-bar-title>

            <template v-slot:append>
                <v-btn size="large" variant="text" color="primary" @click="handleLogout">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="#2475c8" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h7v2H5v14h7v2zm11-4l-1.375-1.45l2.55-2.55H9v-2h8.175l-2.55-2.55L16 7l5 5z" />
                    </svg>
                </v-btn>
            </template>
        </v-app-bar>

        <v-main class="bg-[#191919] h-screen">
            <div class="h-full overflow-y-auto">
                <RouterView />
            </div>
        </v-main>
    </v-layout>
</template>
