import { defineStore } from 'pinia'
import rawAxios from '@/plugins/rawAxios.ts'
import { computed, ref } from 'vue'
import type { ApiResponse, Tokens } from '@/types/types.ts'

export const useAuthStore = defineStore('AuthStore', () => {
    const tokens = ref<Tokens | null>(null)

    if (localStorage.getItem('tokens')) {
        tokens.value = JSON.parse(localStorage.getItem('tokens'))
    }

    const isAuthenticated = computed(() => {
        return tokens.value !== null
    })

    const login = async (form: Record<string, string>): Promise<void> => {
        try {
            const response = await rawAxios.post<ApiResponse<Tokens>>('/api/login_check', {
                ...form,
            })

            tokens.value = {
                accessToken: response.data.token,
                refreshToken: response.data.refresh_token,
            }

            localStorage.setItem('tokens', JSON.stringify(tokens.value))
            window.location.href = '/admin'
        } catch (error) {
            throw error
        }
    }

    const refreshTokens = async (): Promise<void> => {
        if (!tokens.value.refreshToken) {
            throw new Error('No refresh token found')
        }

        try {
            const response = await rawAxios.post('/api/token/refresh', {
                refresh_token: tokens.value.refreshToken,
            })

            tokens.value = {
                accessToken: response.data.token,
                refreshToken: response.data.refresh_token,
            }

            localStorage.setItem('tokens', JSON.stringify(tokens.value))
        } catch (error) {
            await logout()
            throw error
        }
    }

    const logout = async (): Promise<void> => {
        if (!tokens.value.accessToken || !tokens.value.refreshToken) {
            localStorage.removeItem('tokens')
            window.location.href = '/login'
            return
        }

        try {
            await rawAxios.post('/api/logout')

            await rawAxios.post('/api/token/invalidate', {
                refresh_token: tokens.value.refreshToken,
            })
        } catch (error) {
            throw error
        } finally {
            localStorage.removeItem('tokens')
            tokens.value = null
            window.location.href = '/login'
        }
    }

    return {
        tokens,
        isAuthenticated,
        login,
        refreshTokens,
        logout,
    }
})
