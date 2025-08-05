import { ref } from 'vue'
import { defineStore } from 'pinia'

export const useLoaderStore = defineStore('LoaderStore', () => {
    const _isLoading = ref<boolean>(false)

    const show = () => (_isLoading.value = true)

    const hide = () => (_isLoading.value = false)

    return {
        isLoading: _isLoading,
        show,
        hide,
    }
})
