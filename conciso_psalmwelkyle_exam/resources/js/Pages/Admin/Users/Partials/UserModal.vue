<script setup>
import Modal from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import { watch, computed } from "vue";

const props = defineProps({
    show: Boolean,
    user: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(["close"]);

const isEditing = computed(() => !!props.user);

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    is_active: true,
});

watch(
    () => props.user,
    (newUser) => {
        form.defaults({
            name: newUser?.name || "",
            email: newUser?.email || "",
            is_active: newUser ? newUser.is_active : true,
        }).reset();
        form.clearErrors();
    }
);

const submit = () => {
    if (isEditing.value) {
        const data = form.data();
        if (!data.password) {
            delete data.password;
            delete data.password_confirmation;
        }
        form.patch(route("admin.users.update", props.user.id), {
            onSuccess: () => closeModal(),
            preserveScroll: true,
        });
    } else {
        form.post(route("admin.users.store"), {
            onSuccess: () => closeModal(),
            preserveScroll: true,
        });
    }
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
                <h2 class="text-xl font-bold text-white">
                    {{ isEditing ? "Edit User" : "Add User" }}
                </h2>
                <div class="flex space-x-3">
                    <button
                        @click="submit"
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
            <form @submit.prevent="submit" class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <!-- Full Name -->
                    <div>
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Full Name</label
                        >
                        <input
                            v-model="form.name"
                            type="text"
                            id="name"
                            class="w-full px-3 py-2 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                        />
                        <div
                            v-if="form.errors.name"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.name }}
                        </div>
                    </div>
                    <!-- Email -->
                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Email</label
                        >
                        <input
                            v-model="form.email"
                            type="email"
                            id="email"
                            class="w-full px-3 py-2 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                        />
                        <div
                            v-if="form.errors.email"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.email }}
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Password</label
                        >
                        <input
                            v-model="form.password"
                            type="password"
                            id="password"
                            class="mt-1 w-full px-3 py-2 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                        />
                        <div
                            v-if="form.errors.password"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.password }}
                        </div>
                    </div>

                    <!-- Confirm Password-->
                    <div v-if="!isEditing || form.password">
                        <label
                            for="confirm-password"
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Confirm Password</label
                        >
                        <input
                            v-model="form.password_confirmation"
                            type="password"
                            id="confirm-password"
                            class="mt-1 w-full px-3 py-2 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                        />
                    </div>

                    <!-- Status -->
                    <div v-if="isEditing">
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
                    </div>
                </div>
            </form>
        </div>
    </Modal>
</template>
