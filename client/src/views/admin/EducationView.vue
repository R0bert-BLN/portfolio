<script setup lang="ts">
import PageHeader from "@/components/admin/PageHeader.vue";
import {onMounted, type Ref, ref} from "vue";
import {useMediaQuery} from "@vueuse/core";
import {useEducationStore} from "@/stores/EducationStore.ts";
import {storeToRefs} from "pinia";
import type {Education} from "@/types/types.ts";
import {useLoaderStore} from "@/stores/LoaderStore.ts";
import draggable from "vuedraggable";
import EducationCard from "@/components/admin/EducationCard.vue";
import CreateEducationDialog from "@/components/admin/CreateEducationDialog.vue";
import {useNotificationStore} from "@/stores/NotificationStore.ts";

const educationStore = useEducationStore();
const loaderStore = useLoaderStore();
const storeRefs = storeToRefs(educationStore);
const notificationStore = useNotificationStore();
const isLargeScreen = useMediaQuery('(min-width: 1000px)');

const educations: Ref<Array<Partial<Education>>> = storeRefs.educations
const showDialog = ref<boolean>(false);

const fetchEducations = async () => {
    loaderStore.show();

    try {
        await educationStore.getAllEducations();
    } catch (error) {
        console.error(error);
    } finally {
        loaderStore.hide();
    }
}

const handleCreate = async (payload: Record<string, string>) => {
    handleClose();
    loaderStore.show();

    try {
        await educationStore.createEducation(payload);
        notificationStore.success('Education created successfully!');
    } catch (error) {
        console.error(error);
        notificationStore.error(error.response.data.message);
    } finally {
        loaderStore.hide();
    }
}

const handleUpdate = async (payload: Record<string, string>, id: number) => {
    handleClose();
    loaderStore.show();

    try {
        await educationStore.updateEducation(payload, id);
        notificationStore.success('Education updated successfully!');
    } catch (error) {
        console.error(error);
        notificationStore.error(error.response.data.message);
    } finally {
        loaderStore.hide();
    }
}

const handleDelete = async (id: number) => {
    loaderStore.show();

    try {
        await educationStore.deleteEducation(id);
        notificationStore.success('Education deleted successfully!');
    } catch (error) {
        console.error(error);
        notificationStore.error(error.response.data.message);
    } finally {
        loaderStore.hide();
    }
}

const handleClose = () => {
    showDialog.value = false;
}

const onDragEnd = async () => {
    const updatedOrder = educations.value.map((education, index) => {
        return {
            id: education.id,
            display_order: index
        }
    })
    console.log(updatedOrder);
    // await educationStore.updateDisplayOrder(updatedOrder);
}

onMounted(async () => {
    await fetchEducations();
})
</script>

<template>
    <div class="pt-8 pb-16" :class="isLargeScreen ? 'mx-16 px-5 mt-16' : 'px-2 mt-5'">
        <v-card flat color="transparent">
            <v-card-title>
                <PageHeader>
                    <template v-slot:title>Education</template>

                    <template v-slot:actions>
                        <v-dialog v-model="showDialog" max-width="700" transition="scale-transition" persistent>
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

                            <template v-slot:default>
                                <CreateEducationDialog @close="handleClose" @create="handleCreate"/>
                            </template>
                        </v-dialog>
                    </template>
                </PageHeader>
            </v-card-title>

            <v-card-text class="mt-16" :class="{'pt-8': isLargeScreen}">
                <div class="flex flex-col justify-center items-center">
                <draggable v-model="educations" item-key="id" handle=".drag-handle" tag="div" @end="onDragEnd" :animation="300">
                    <template #item="{ element: education, index}">
                        <EducationCard :education="education" :index="index" @update="handleUpdate" @delete="handleDelete"/>
                    </template>
                </draggable>
                </div>
            </v-card-text>
        </v-card>
    </div>
</template>
