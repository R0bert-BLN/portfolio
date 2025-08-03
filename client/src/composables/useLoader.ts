import { reactive, toRefs } from 'vue'

const state = reactive({
    isLoading: false,
})

export default () => {
    const { isLoading } = toRefs(state)
    const show = () => (state.isLoading = true)
    const hide = () => (state.isLoading = false)

    return {
        isLoading,
        show,
        hide,
    }
}
