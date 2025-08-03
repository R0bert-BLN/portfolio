<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useAuthStore } from '@/stores/AuthStore.ts'
import useLoader from '@/composables/useLoader.ts'

interface Payload {
    username: string
    password: string
}

const authStore = useAuthStore()
const errorMessage = ref<string | null>(null)
const loader = useLoader()
const isFormValid = ref<boolean>(false)

const form = reactive<Payload>({
    username: '',
    password: '',
})

const emailRules: Array<Function> = [
    (value: string) => !!value || 'Email is required',
    (value: string) => value.includes('@') || 'Invalid email',
]

const passwordRules: Array<Function> = [(value: string) => !!value || 'Password is required']

const onSubmit = async () => {
    if (!isFormValid.value) {
        return
    }

    loader.show()

    try {
        await authStore.login(form)
    } catch (error) {
        if (error.response.status === 401) {
            errorMessage.value = 'Invalid email or password'
        } else {
            errorMessage.value = error.response.data.message
        }
    } finally {
        loader.hide()
    }
}
</script>

<template>
    <div class="h-screen flex flex-col justify-center items-center position-relative">
        <div v-if="errorMessage" class="position-absolute top-10">
            <v-alert
                closable
                type="error"
                :title="errorMessage"
                icon="mdi-alert"
                @click:close="errorMessage = null"
            />
        </div>

        <div class="md:w-[450px] mx-14">
            <h1 class="text-[#2475c8] text-[45px] text-center font-bold pb-5">For Admin Only</h1>

            <v-form v-model="isFormValid" @submit.prevent="onSubmit" class="mt-16">
                <v-text-field
                    v-model="form.username"
                    label="Email"
                    type="email"
                    variant="underlined"
                    color="primary"
                    class="login-input mb-8"
                    :rules="emailRules"
                />
                <v-text-field
                    v-model="form.password"
                    label="Password"
                    type="password"
                    variant="underlined"
                    color="primary"
                    class="login-input mb-8"
                    :rules="passwordRules"
                />

                <v-btn
                    type="submit"
                    block
                    :loading="loader.isLoading.value"
                    variant="outlined"
                    color="primary"
                    size="large"
                    class="login-btn mt-10"
                    >Login</v-btn
                >
            </v-form>
        </div>
    </div>
</template>

<style scoped>
.login-input::v-deep(.v-field-label) {
    font-size: 1.2rem;
    color: #ced0d1;
}

.login-input::v-deep(.v-field-label.v-field-label--floating) {
    color: #4695e5;
    font-weight: 550;
    translate: 0 -1.5rem;
    font-size: 1.45rem;
}

.login-input ::v-deep(input) {
    font-size: 1.2rem;
    color: #ced0d1;
    padding: 0.8rem 0;
}
</style>
