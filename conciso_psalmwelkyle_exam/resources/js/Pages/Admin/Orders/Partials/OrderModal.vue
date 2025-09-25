<script setup>
import Modal from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";

const props = defineProps({
    show: Boolean,
    order: Object,
});

const emit = defineEmits(["close"]);

const form = useForm({
    status: "",
});

watch(
    () => props.order,
    (newOrder) => {
        if (newOrder) {
            form.status = newOrder.status;
        }
    }
);

const updateOrder = () => {
    form.patch(route("admin.orders.update", props.order.id), {
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    emit("close");
};
</script>

<template>
    <Modal :show="show" max-width="2xl" @close="closeModal">
        <div v-if="order" class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-[#8B3F93] p-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-white uppercase">
                    {{ order.user.name }}'s Order
                </h2>
                <div class="flex space-x-3">
                    <button
                        @click="updateOrder"
                        :disabled="form.processing"
                        class="bg-white text-[#8B3F93] font-bold py-2 px-8 rounded-lg text-sm hover:bg-gray-200 transition"
                    >
                        SAVE
                    </button>
                    <button
                        @click="closeModal"
                        class="bg-white text-gray-600 font-bold py-2 px-8 rounded-lg text-sm hover:bg-gray-200 transition"
                    >
                        CLOSE
                    </button>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Full Name</label
                        >
                        <input
                            type="text"
                            :value="order.user.name"
                            class="w-full px-3 py-2 bg-gray-200 border border-gray-300 rounded-md"
                            readonly
                        />
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Product Ordered</label
                        >
                        <input
                            type="text"
                            :value="order.product.name"
                            class="w-full px-3 py-2 bg-gray-200 border border-gray-300 rounded-md"
                            readonly
                        />
                    </div>
                    <div>
                        <label
                            for="status"
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Status</label
                        >
                        <select
                            v-model="form.status"
                            id="status"
                            class="w-full px-3 py-2 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                        >
                            <option>Pending</option>
                            <option>For Delivery</option>
                            <option>Delivered</option>
                            <option>Canceled</option>
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                            >Quantity</label
                        >
                        <input
                            type="number"
                            :value="order.quantity"
                            class="w-full px-3 py-2 bg-gray-200 border border-gray-300 rounded-md"
                            readonly
                        />
                    </div>
                </div>
            </div>
        </div>
    </Modal>
</template>
