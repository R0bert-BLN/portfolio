<script setup lang="ts">
import PageHeader from '@/components/admin/PageHeader.vue'
import { onMounted, type Ref, ref } from 'vue'
import WorkCreateDialog from '@/components/admin/WorkCreateDialog.vue'
import { useWorkStore } from '@/stores/WorkStore.ts'
import { storeToRefs } from 'pinia'
import { useMediaQuery } from '@vueuse/core'
import type { Work, WorkRequest } from '@/types/types.ts'
import { useLoaderStore } from '@/stores/LoaderStore.ts'
import { useNotificationStore } from '@/stores/NotificationStore.ts'
import EducationCard from '@/components/admin/EducationCard.vue'
import draggable from 'vuedraggable'
import WorkCard from '@/components/admin/WorkCard.vue'

const workStore = useWorkStore()
const storeRefs = storeToRefs(workStore)
const loaderStore = useLoaderStore()
const notificationStore = useNotificationStore()
const isLargeScreen = useMediaQuery('(min-width: 1000px)')

const showDialog = ref<boolean>(false)
const works: Ref<Array<Partial<Work>>> = storeRefs.works

const handleClose = () => {
    showDialog.value = false
}

const handleCreate = async (payload: WorkRequest) => {
    handleClose()
    loaderStore.show()

    try {
        await workStore.createWork(payload)
        notificationStore.success('Work Experience created successfully!')
    } catch (error) {
        console.error(error)
        notificationStore.error(error.response.data.message)
    } finally {
        loaderStore.hide()
    }
}

const handleUpdate = async (payload: WorkRequest, id: number) => {
    handleClose()
    loaderStore.show()

    try {
        await workStore.updateWork(payload, id)
        notificationStore.success('Work Experience updated successfully!')
    } catch (error) {
        console.error(error)
        notificationStore.error(error.response.data.message)
    } finally {
        loaderStore.hide()
    }
}

const handleDelete = async (id: number) => {
    loaderStore.show()

    try {
        await workStore.deleteWork(id)
        notificationStore.success('Work Experience deleted successfully!')
    } catch (error) {
        console.error(error)
        notificationStore.error(error.response.data.message)
    } finally {
        loaderStore.hide()
    }
}

const onDragEnd = async () => {
    const payload = works.value.map((work, index) => {
        return {
            id: work.id,
            display_order: index,
        }
    })

    try {
        await workStore.updateDisplayOrder(payload)
    } catch (error) {
        console.error(error)
    }
}

const fetchWorks = async () => {
    loaderStore.show()

    try {
        await workStore.getAllWorks()
    } catch (error) {
        console.error(error)
    } finally {
        loaderStore.hide()
    }
}

onMounted(async () => {
    await fetchWorks()
})
</script>

<template>
    <div class="pt-8" :class="isLargeScreen ? 'mx-16 px-5 mt-16 pb-16' : 'px-2 mt-5 pb-5'">
        <v-card flat color="transparent">
            <v-card-title>
                <PageHeader>
                    <template v-slot:title>Work</template>

                    <template v-slot:actions>
                        <v-dialog
                            v-model="showDialog"
                            max-width="700"
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

                            <template v-slot:default>
                                <WorkCreateDialog @close="handleClose" @create="handleCreate" />
                            </template>
                        </v-dialog>
                    </template>
                </PageHeader>
            </v-card-title>

            <v-card-text class="mt-16" :class="{ 'pt-8': isLargeScreen }">
                <div class="flex flex-col justify-center items-center">
                    <draggable
                        v-model="works"
                        item-key="id"
                        class="w-full"
                        handle=".drag-handle"
                        tag="div"
                        @end="onDragEnd"
                        :animation="300"
                    >
                        <template #item="{ element: work, index }">
                            <WorkCard
                                :work="work"
                                :index="index"
                                @update="handleUpdate"
                                @delete="handleDelete"
                            />
                        </template>
                    </draggable>
                </div>
            </v-card-text>
        </v-card>
    </div>
</template>

<style scoped></style>
