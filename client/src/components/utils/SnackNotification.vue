<script setup lang="ts">
import {useNotificationStore} from "@/stores/NotificationStore.ts";
import {useMediaQuery} from "@vueuse/core";
import {computed} from "vue";

const notificationStore = useNotificationStore();
const isLargeScreen = useMediaQuery('(min-width: 1000px)')

const margins = computed(() => {
    return isLargeScreen.value ? 'mb-10 mr-10' : 'mt-16 pt-4'
})

const notificationLocation = computed(() => {
    return isLargeScreen.value ? 'bottom right' : 'top'
})
</script>

<template>
    <v-snackbar :class="margins" multi-line v-model="notificationStore.show" :color="notificationStore.color" :timeout="notificationStore.timeout" :location="notificationLocation">
        <div class="flex flex-col gap-1">
            <span class="font-semibold text-[24px]">{{ notificationStore.title }}</span>
            <span class="text-[20px]">{{ notificationStore.message }}</span>
        </div>

        <template v-slot:actions>
            <v-btn color="white" icon="mdi-close" variant="text" @click="notificationStore.hideNotification()"></v-btn>
        </template>
    </v-snackbar>
</template>

<style scoped>

</style>
