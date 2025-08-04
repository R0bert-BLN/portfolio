<script setup lang="ts">
import SnackNotification from "@/components/utils/SnackNotification.vue";
import LoaderSpinner from "@/components/utils/LoaderSpinner.vue";
</script>

<template>
    <RouterView></RouterView>
    <SnackNotification />
    <LoaderSpinner />
</template>
