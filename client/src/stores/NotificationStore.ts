import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useNotificationStore = defineStore('NotificationStore', () => {
    const _show = ref<boolean>(false)
    const _message = ref<string>('')
    const _color = ref<string>('')
    const _title = ref<string>('')
    const _timeout = ref<number>(3000)

    const showNotification = (message: string, color: string, timeout: number, title: string) => {
        _show.value = true
        _message.value = message
        _color.value = color
        _timeout.value = timeout
        _title.value = title
    }

    const success = (message: string, timeout: number = 3000) => {
        showNotification(message, 'success', timeout, 'Success')
    }

    const error = (message: string, timeout: number = 3000) => {
        showNotification(message, 'error', timeout, 'Error')
    }

    const warning = (message: string, timeout: number = 3000) => {
        showNotification(message, 'warning', timeout, 'Warning')
    }

    const info = (message: string, timeout: number = 3000) => {
        showNotification(message, 'info', timeout, 'Info')
    }

    const hideNotification = () => {
        _show.value = false
    }

    return {
        show: _show,
        message: _message,
        color: _color,
        timeout: _timeout,
        title: _title,
        success,
        error,
        warning,
        info,
        hideNotification,
    }
})
