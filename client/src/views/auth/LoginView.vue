<script setup lang="ts">
import { reactive } from 'vue'
import {useAuthStore} from "@/stores/AuthStore.ts";
import {useRouter} from "vue-router";

interface Payload {
    username: string
    password: string
}

const authStore = useAuthStore();
const router = useRouter();

const form = reactive<Payload>({
    username: '',
    password: '',
})

const onSubmit = async () => {
    try {
        await authStore.login(form);
    } catch (error) {
        console.error(error);
    }
}
</script>

<template>
    <div class="h-screen flex justify-center items-center">
        <div class="w-full sm:max-w-[450px] mx-10">
            <h1 class="text-[#2475c8] text-[45px] text-center font-bold pb-5">For Admin Only</h1>

            <v-form @submit.prevent="onSubmit" class="mt-16">
                <v-text-field
                    v-model="form.username"
                    label="Email"
                    type="email"
                    variant="underlined"
                    color="primary"
                    class="login-input mb-6"
                />
                <v-text-field
                    v-model="form.password"
                    label="Password"
                    type="password"
                    variant="underlined"
                    color="primary"
                    class="login-input mb-6"
                />

                <v-btn
                    type="submit"
                    block
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
