<script setup>
import InputError from "@/Components/InputError.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});
const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Register" />

    <div
        class="bg-gray-100 flex items-center justify-center min-h-screen p-4 font-sans"
    >
        <div class="w-full max-w-2xl bg-white rounded-lg shadow-lg p-8">
            <div class="flex justify-center items-center mb-10">
                <img
                    src="/storage/images/logo.png"
                    alt="PurpleBug Logo"
                    class="max-w-[300px] h-auto"
                />
            </div>

            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div>
                        <label
                            for="full-name"
                            class="block text-sm font-medium text-gray-700"
                            >Full Name</label
                        >
                        <div class="mt-1 relative">
                            <div
                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                            >
                                <img
                                    src="/storage/images/user.svg"
                                    class="h-5 w-5 text-gray-500"
                                    alt="User icon"
                                />
                            </div>
                            <input
                                type="text"
                                id="full-name"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                                class="w-full pl-10 px-3 py-3 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                            />
                        </div>
                        <InputError class="mt-1" :message="form.errors.name" />
                    </div>
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
                                type="email"
                                id="email"
                                v-model="form.email"
                                required
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
                                type="password"
                                id="password"
                                v-model="form.password"
                                required
                                autocomplete="new-password"
                                class="w-full pl-10 px-3 py-3 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                            />
                        </div>
                        <InputError
                            class="mt-1"
                            :message="form.errors.password"
                        />
                    </div>
                    <div>
                        <label
                            for="confirm-password"
                            class="block text-sm font-medium text-gray-700"
                            >Confirm Password</label
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
                                type="password"
                                id="confirm-password"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                                class="w-full pl-10 px-3 py-3 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                            />
                        </div>
                        <InputError
                            class="mt-1"
                            :message="form.errors.password_confirmation"
                        />
                    </div>
                </div>

                <div class="mt-10 flex justify-center">
                    <button
                        type="submit"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        class="bg-[#8B3F93] text-white font-bold py-3 px-20 rounded-lg hover:bg-opacity-90 transition shadow-md"
                    >
                        REGISTER
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
