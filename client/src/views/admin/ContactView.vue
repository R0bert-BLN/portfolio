<script setup lang="ts">
import PageHeader from '@/components/admin/PageHeader.vue'
import { ref } from 'vue'

const showDialog = ref<boolean>(false)
</script>

<template>
    <div class="mx-16 mt-16 pt-8 px-5 pb-16">
        <v-card flat color="transparent">
            <v-card-title>
                <PageHeader>
                    <template v-slot:title>Contact</template>

                    <template v-slot:actions>
                        <v-dialog
                            v-model="showDialog"
                            max-width="800"
                            transition="scale-transition"
                            persistent
                        >
                            <template v-slot:activator="{ props: activatorProps }">
                                <v-btn
                                    color="primary"
                                    variant="outlined"
                                    rounded="lg"
                                    v-bind="activatorProps"
                                >
                                    <span class="font-semibold text-[16px]">Add</span>
                                </v-btn>
                            </template>

                            <template v-slot:default> </template>
                        </v-dialog>
                    </template>
                </PageHeader>
            </v-card-title>
        </v-card>
    </div>
</template>
