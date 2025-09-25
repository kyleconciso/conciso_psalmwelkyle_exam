<script setup>
import InputError from "@/Components/InputError.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Log in" />

    <div
        class="bg-gray-100 flex items-center justify-center min-h-screen p-4 font-sans"
    >
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
            <div class="flex justify-center items-center mb-10">
                <img
                    src="/storage/images/logo.png"
                    alt="PurpleBug Logo"
                    class="max-w-[300px] h-auto"
                />
            </div>

            <h2 class="text-2xl font-bold text-gray-800 text-center mb-8">
                Welcome Back!
            </h2>

            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700"
                        >Email</label
                    >
                    <div class="mt-1 relative">
                        <div
                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                        >
                            <img
                                src="/storage/images/email.svg"
                                class="h-5 w-5 text-gray-500"
                                alt="Email icon"
                            />
                        </div>
                        <input
                            id="email"
                            type="email"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
                            class="w-full pl-10 px-3 py-3 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                        />
                    </div>
                    <InputError class="mt-1" :message="form.errors.email" />
                </div>

                <div>
                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700"
                        >Password</label
                    >
                    <div class="mt-1 relative">
                        <div
                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                        >
                            <img
                                src="/storage/images/password.svg"
                                class="h-5 w-5 text-gray-500"
                                alt="Password icon"
                            />
                        </div>
                        <input
                            id="password"
                            type="password"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                            class="w-full pl-10 px-3 py-3 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                        />
                    </div>
                    <InputError class="mt-1" :message="form.errors.password" />
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            v-model="form.remember"
                            class="rounded border-gray-300 text-[#8B3F93] shadow-sm focus:ring-[#8B3F93]"
                        />
                        <span class="ms-2 text-sm text-gray-600"
                            >Remember me</span
                        >
                    </label>

                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Forgot your password?
                    </Link>
                </div>

                <div class="flex justify-center pt-4">
                    <button
                        type="submit"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        class="bg-[#8B3F93] text-white font-bold py-3 px-20 rounded-lg hover:bg-opacity-90 transition shadow-md"
                    >
                        LOGIN
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
