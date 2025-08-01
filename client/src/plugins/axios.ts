import axios from "axios";
import {useAuthStore} from "@/stores/AuthStore.ts";

const axiosInstance = axios.create({
    baseURL: 'http://localhost:8080',
});

axiosInstance.interceptors.request.use((config) => {
    const authStore = useAuthStore();

    if (authStore.tokens?.accessToken) {
        config.headers.Authorization = `Bearer ${authStore.tokens.accessToken}`;
    }

    return config;
});

axiosInstance.interceptors.response.use(
    (response) => {
        return response
    },
    async (error) => {
        const authStore = useAuthStore();
        const originalRequest = error.config;

        if (error.response.status === 401 && !originalRequest._retry) {
            originalRequest._retry = true;

            try {
                await authStore.refreshTokens();
                return axiosInstance(originalRequest);
            } catch (refreshError) {
                return Promise.reject(refreshError);
            }
        }

        return Promise.reject(error);
    }
);

export default axiosInstance
