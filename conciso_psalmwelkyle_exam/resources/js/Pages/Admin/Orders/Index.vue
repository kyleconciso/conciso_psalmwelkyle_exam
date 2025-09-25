<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import OrderModal from "./Partials/OrderModal.vue";

const props = defineProps({
    orders: Array,
});

const showOrderModal = ref(false);
const selectedOrder = ref(null);

const openModal = (order) => {
    selectedOrder.value = order;
    showOrderModal.value = true;
};

const deleteOrder = (order) => {
    if (
        confirm(
            `Are you sure you want to permanently delete this order for ${order.product.name}?`
        )
    ) {
        router.delete(route("admin.orders.destroy", order.id));
    }
};

const statusClasses = computed(() => {
    return {
        Delivered: "bg-[#55B36A]",
        Pending: "bg-[#FF8C00]",
        "For Delivery": "bg-[#C2D027]",
        Canceled: "bg-[#C73B3B]",
    };
});
</script>

<template>
    <Head title="Orders Management" />
    <AdminLayout>
        <div
            class="bg-white p-6 rounded-xl shadow-lg flex justify-between items-center mb-8"
        >
            <h2 class="text-2xl font-bold text-[#8B3F93]">Orders</h2>

            <!-- for consistent sizing purposes -->
            <div class="invisible">
                <button
                    class="bg-[#65558F] text-white font-bold py-2 px-6 rounded-full"
                >
                    Placeholder
                </button>
            </div>
        </div>

        <div class="flex-1 bg-transparent space-y-4">
            <div
                class="bg-[#8B3F93] text-white grid grid-cols-12 gap-4 py-5 px-4 rounded-xl font-bold items-center"
            >
                <div class="col-span-3">Full Name</div>
                <div class="col-span-3">Product</div>
                <div class="col-span-3">Status</div>
                <div class="col-span-3 text-center">Action</div>
            </div>

            <div
                v-for="order in orders"
                :key="order.id"
                class="bg-white p-4 rounded-xl shadow-lg grid grid-cols-12 gap-4 items-center"
            >
                <div class="col-span-3 font-medium text-gray-800">
                    {{ order.user.name }}
                </div>
                <div class="col-span-3 text-gray-600">
                    {{ order.product.name }}
                </div>
                <div class="col-span-3">
                    <span
                        :class="statusClasses[order.status]"
                        class="text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded-full"
                    >
                        {{ order.status }}
                    </span>
                </div>
                <div
                    class="col-span-3 flex items-center space-x-4 justify-center"
                >
                    <button
                        @click="openModal(order)"
                        class="text-gray-500 hover:text-blue-500"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                            />
                        </svg>
                    </button>
                    <button
                        @click="deleteOrder(order)"
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
                v-if="!orders.length"
                class="bg-white p-4 rounded-xl shadow-lg text-center text-gray-500"
            >
                No orders found.
            </div>
        </div>
    </AdminLayout>

    <OrderModal
        :show="showOrderModal"
        :order="selectedOrder"
        @close="showOrderModal = false"
    />
</template>
