<script setup>
import { useForm } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    show: Boolean,
});

const emit = defineEmits(["close"]);

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    role: "Guest",
});

const createUser = () => {
    form.post(route("admin.users.store"), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            form.reset();
        },
        onError: () => {},
    });
};

const closeModal = () => {
    emit("close");
};
</script>

<template>
    <Modal :show="show" @close="closeModal">
        <div
            class="w-full max-w-2xl bg-white rounded-lg shadow-lg overflow-hidden"
        >
            <!-- Header -->
            <div class="bg-[#8B3F93] p-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">Add User</h2>
                <div class="flex space-x-3">
                    <button
                        @click="createUser"
                        :disabled="form.processing"
                        class="bg-white text-[#8B3F93] font-bold py-2 px-8 rounded-lg text-sm hover:bg-gray-200 transition"
                    >
                        SAVE
                    </button>
                    <button
                        @click="closeModal"
                        class="bg-white text-gray-600 font-bold py-2 px-8 rounded-lg text-sm hover:bg-gray-200 transition"
                    >
                        CANCEL
                    </button>
                </div>
            </div>

            <!-- Form Content -->
            <form @submit.prevent="createUser" class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <!-- Full Name -->
                    <div>
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700"
                            >Full Name</label
                        >
                        <input
                            type="text"
                            id="name"
                            v-model="form.name"
                            class="mt-1 w-full px-3 py-2 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-700"
                            >Email</label
                        >
                        <input
                            type="email"
                            id="email"
                            v-model="form.email"
                            class="mt-1 w-full px-3 py-2 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-700"
                            >Password</label
                        >
                        <input
                            type="password"
                            id="password"
                            v-model="form.password"
                            class="mt-1 w-full px-3 py-2 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                            required
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.password"
                        />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label
                            for="password_confirmation"
                            class="block text-sm font-medium text-gray-700"
                            >Confirm Password</label
                        >
                        <input
                            type="password"
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            class="mt-1 w-full px-3 py-2 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                            required
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.password_confirmation"
                        />
                    </div>

                    <!-- Role -->
                    <div>
                        <label
                            for="role"
                            class="block text-sm font-medium text-gray-700"
                            >Role</label
                        >
                        <select
                            id="role"
                            v-model="form.role"
                            class="mt-1 w-full px-3 py-2 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                            required
                        >
                            <option>Guest</option>
                            <option>Admin</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.role" />
                    </div>
                </div>
            </form>
        </div>
    </Modal>
</template>
