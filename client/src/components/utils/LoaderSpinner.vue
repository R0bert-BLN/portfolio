<script setup lang="ts">
import { useLoaderStore } from '@/stores/LoaderStore.ts'

const loaderStore = useLoaderStore()
</script>

<template>
    <v-overlay
        v-model="loaderStore.isLoading"
        class="flex justify-center items-center"
        color="primary"
        persistent
        :model-value="loaderStore.isLoading"
    >
        <v-progress-circular
            size="60"
            width="5"
            indeterminate
            color="primary"
        ></v-progress-circular>
    </v-overlay>
</template>

<style scoped></style>
