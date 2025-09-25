<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import CreateUserModal from "./Partials/CreateUserModal.vue";
import EditUserModal from "./Partials/EditUserModal.vue";

defineProps({
    users: Array,
});

const showingCreateUserModal = ref(false);
const showingEditUserModal = ref(false);
const selectedUser = ref(null);

const openEditModal = (user) => {
    selectedUser.value = user;
    showingEditUserModal.value = true;
};

const deleteUser = (user) => {
    if (
        confirm(
            `Are you sure you want to PERMANENTLY DELETE ${user.name}? This cannot be undone.`
        )
    ) {
        router.delete(route("admin.users.destroy", user.id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Users Management" />

    <AdminLayout>
        <!-- Header -->
        <div
            class="bg-white p-6 rounded-xl shadow-lg flex justify-between items-center mb-8"
        >
            <h2 class="text-2xl font-bold text-[#8B3F93]">Users Management</h2>
            <button
                @click="showingCreateUserModal = true"
                class="bg-[#65558F] text-white font-bold py-2 px-6 rounded-full hover:bg-opacity-90 transition duration-300"
            >
                Add User
            </button>
        </div>

        <!-- Users Table -->
        <div class="flex-1 bg-transparent space-y-4">
            <div
                class="bg-[#8B3F93] text-white grid grid-cols-12 gap-4 py-5 px-4 rounded-xl font-bold items-center"
            >
                <div class="col-span-4">Full Name</div>
                <div class="col-span-4">Email</div>
                <div class="col-span-2">Status</div>
                <div class="col-span-2 text-center">Action</div>
            </div>

            <div
                v-if="users.length > 0"
                v-for="user in users"
                :key="user.id"
                class="bg-white p-4 rounded-xl shadow-lg grid grid-cols-12 gap-4 items-center"
            >
                <div class="col-span-4 font-medium text-gray-800">
                    {{ user.name }}
                </div>
                <div class="col-span-4 text-gray-600">{{ user.email }}</div>
                <div class="col-span-2">
                    <span
                        v-if="user.is_active"
                        class="text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded-full bg-[#55B36A]"
                        >Active</span
                    >
                    <span
                        v-else
                        class="text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded-full bg-[#C73B3B]"
                        >Inactive</span
                    >
                </div>
                <div
                    class="col-span-2 flex items-center space-x-4 justify-center"
                >
                    <button
                        @click="openEditModal(user)"
                        class="text-gray-500 hover:text-blue-500"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"
                            />
                            <path
                                fill-rule="evenodd"
                                d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                    <button
                        v-if="user.role !== 'Admin'"
                        @click="deleteUser(user)"
                        class="text-gray-500 hover:text-red-500"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </div>
            </div>
            <div
                v-else
                class="bg-white p-4 rounded-xl shadow-lg text-center text-gray-500"
            >
                No guest users found.
            </div>
        </div>
    </AdminLayout>

    <CreateUserModal
        :show="showingCreateUserModal"
        @close="showingCreateUserModal = false"
    />
    <EditUserModal
        :show="showingEditUserModal"
        :user="selectedUser"
        @close="showingEditUserModal = false"
    />
</template>
