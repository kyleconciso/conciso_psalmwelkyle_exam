<script setup>
import Modal from "@/Components/Modal.vue";
import { cart } from "@/cart.js";
import { useForm } from "@inertiajs/vue3";

defineProps({
    show: Boolean,
});

const emit = defineEmits(["close", "order-placed"]); // <-- Added 'order-placed'

const form = useForm({});

const placeOrder = () => {
    form.transform(() => ({
        cart: cart.items.map((item) => ({
            id: item.id,
            quantity: item.quantity,
        })),
    })).post(route("cart.store"), {
        onSuccess: () => {
            cart.clear();
            closeModal();
            emit("order-placed"); // <-- EMIT THE EVENT
        },
    });
};

const closeModal = () => {
    emit("close");
};
</script>

<template>
    <Modal :show="show" max-width="2xl" @close="closeModal">
        <!-- ... (rest of the cart modal template is unchanged) ... -->
        <div class="w-full bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-center pb-4">
                    <div class="flex items-center space-x-3">
                        <svg
                            class="h-8 w-8 text-[#8B3F93]"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                            />
                        </svg>
                        <h1 class="text-3xl font-bold text-[#8B3F93]">Cart</h1>
                    </div>
                    <button
                        @click="placeOrder"
                        :disabled="form.processing || cart.items.length === 0"
                        class="bg-[#8B3F93] text-white font-semibold py-2 px-6 rounded-lg hover:bg-opacity-90 transition disabled:bg-gray-400"
                    >
                        PLACE ORDER
                    </button>
                </div>
                <hr class="border-gray-200" />
            </div>

            <div class="p-6 overflow-y-auto max-h-96">
                <div v-if="cart.items.length > 0" class="space-y-6">
                    <div
                        v-for="item in cart.items"
                        :key="item.id"
                        class="flex items-start space-x-6"
                    >
                        <div
                            class="w-24 h-24 bg-gray-200 rounded-md flex-shrink-0"
                        ></div>
                        <div class="flex-1 text-left">
                            <h3 class="text-lg font-semibold text-gray-800">
                                {{ item.name }}
                            </h3>
                            <p class="text-xl font-bold text-gray-900 mt-1">
                                P {{ item.price }}
                            </p>
                            <div class="mt-2 flex items-center justify-between">
                                <p class="text-sm text-gray-600">
                                    Quantity: {{ item.quantity }}
                                </p>
                                <button
                                    @click="cart.removeItem(item.id)"
                                    class="text-red-500 hover:underline text-sm"
                                >
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center text-gray-500">
                    Your cart is empty.
                </div>
            </div>

            <div class="bg-[#8B3F93] text-white p-6 flex items-center">
                <p class="text-xl font-semibold">TOTAL:</p>
                <p class="text-3xl font-bold ml-4">
                    P {{ cart.total.toFixed(2) }}
                </p>
            </div>
        </div>
    </Modal>
</template>
