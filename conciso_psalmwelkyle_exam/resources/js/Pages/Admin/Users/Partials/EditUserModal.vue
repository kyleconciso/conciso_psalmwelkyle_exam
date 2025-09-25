<script setup>
import Modal from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";

const props = defineProps({
    show: Boolean,
    user: Object,
});

const emit = defineEmits(["close"]);

const form = useForm({
    name: "",
    email: "",
    is_active: true,
});

// When the user prop changes (when the modal is opened), fill the form
watch(
    () => props.user,
    (newUser) => {
        if (newUser) {
            form.name = newUser.name;
            form.email = newUser.email;
            form.is_active = newUser.is_active;
        }
    }
);

const updateUser = () => {
    form.patch(route("admin.users.update", props.user.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    emit("close");
};
</script>

<template>
    <Modal :show="show" max-width="2xl" @close="closeModal">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-[#8B3F93] p-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">Edit User</h2>
                <div class="flex space-x-3">
                    <button
                        @click="updateUser"
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
            <form @submit.prevent="updateUser" class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <!-- Full Name -->
                    <div>
                        <label
                            for="edit-name"
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Full Name</label
                        >
                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-3"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-gray-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                            </span>
                            <input
                                v-model="form.name"
                                type="text"
                                id="edit-name"
                                class="w-full pl-10 pr-3 py-2 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                            />
                            <div
                                v-if="form.errors.name"
                                class="text-sm text-red-600 mt-1"
                            >
                                {{ form.errors.name }}
                            </div>
                        </div>
                    </div>
                    <!-- Email -->
                    <div>
                        <label
                            for="edit-email"
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Email</label
                        >
                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-3"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-gray-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    />
                                </svg>
                            </span>
                            <input
                                v-model="form.email"
                                type="email"
                                id="edit-email"
                                class="w-full pl-10 pr-3 py-2 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                            />
                            <div
                                v-if="form.errors.email"
                                class="text-sm text-red-600 mt-1"
                            >
                                {{ form.errors.email }}
                            </div>
                        </div>
                    </div>
                    <!-- Status -->
                    <div>
                        <label
                            for="status"
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Status</label
                        >
                        <select
                            id="status"
                            v-model="form.is_active"
                            class="mt-1 w-full pl-3 pr-10 py-2 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                        >
                            <option :value="true">Active</option>
                            <option :value="false">Inactive</option>
                        </select>
                        <div
                            v-if="form.errors.is_active"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.is_active }}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </Modal>
</template>
