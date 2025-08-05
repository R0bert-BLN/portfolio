<script setup lang="ts"></script>

<template>
    <v-card rounded="xl">
        <div class="flex flex-col items-center justify-center gap-4 py-5">
            <v-card-title>
                <div class="flex flex-col justify-center items-center gap-2">
                    <v-icon icon="mdi-alert-circle-outline" size="70" color="error"></v-icon>
                    <span class="font-semibold text-[24px]">Are you sure?</span>
                </div>
            </v-card-title>

            <v-card-text>
                <div class="flex justify-center my-4">
                    <span class="text-[18px] text-center"
                        >Are you sure you want to delete this item? This action cannot be
                        undone.</span
                    >
                </div>
            </v-card-text>

            <v-card-actions>
                <div class="flex justify-between gap-8">
                    <v-btn
                        text="Cancel"
                        color="primary"
                        @click="$emit('close')"
                        variant="outlined"
                        rounded="lg"
                    ></v-btn>

                    <v-btn
                        text="Delete"
                        color="error"
                        @click="$emit('delete')"
                        variant="outlined"
                        rounded="lg"
                    ></v-btn>
                </div>
            </v-card-actions>
        </div>
    </v-card>
</template>

<style scoped></style>
