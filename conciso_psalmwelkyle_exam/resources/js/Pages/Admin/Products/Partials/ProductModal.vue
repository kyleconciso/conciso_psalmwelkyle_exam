<script setup>
import Modal from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import { watch, computed } from "vue";

const props = defineProps({
    show: Boolean,
    product: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(["close"]);

const isEditing = computed(() => !!props.product);

const form = useForm({
    name: "",
    price: "",
    stock: "",
});

watch(
    () => props.show,
    (show) => {
        if (show) {
            form.defaults({
                name: props.product?.name || "",
                price: props.product?.price || "",
                stock: props.product?.stock || "",
            }).reset();
        }
    }
);

const submit = () => {
    if (isEditing.value) {
        form.patch(route("admin.products.update", props.product.id), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route("admin.products.store"), {
            onSuccess: () => closeModal(),
        });
    }
};

const closeModal = () => {
    emit("close");
};
</script>

<template>
    <Modal :show="show" max-width="4xl" @close="closeModal">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-[#8B3F93] p-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">
                    {{ isEditing ? "Edit Product" : "Add Product" }}
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
            <form @submit.prevent="submit" class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Product Image</label
                        >
                        <div
                            class="w-full aspect-square bg-gray-200 rounded-lg flex items-center justify-center text-gray-400"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-24 w-24"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div>
                            <label
                                for="price"
                                class="block text-sm font-medium text-gray-700"
                                >Price</label
                            >
                            <div class="mt-1 relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                                >
                                    <span
                                        class="text-gray-500 sm:text-sm font-bold"
                                        >P</span
                                    >
                                </div>
                                <input
                                    v-model="form.price"
                                    type="text"
                                    id="price"
                                    class="w-full pl-7 pr-3 py-2 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                                />
                                <div
                                    v-if="form.errors.price"
                                    class="text-sm text-red-600 mt-1"
                                >
                                    {{ form.errors.price }}
                                </div>
                            </div>
                        </div>
                        <div>
                            <label
                                for="product-name"
                                class="block text-sm font-medium text-gray-700"
                                >Product Name</label
                            >
                            <input
                                v-model="form.name"
                                type="text"
                                id="product-name"
                                class="mt-1 w-full px-3 py-2 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                            />
                            <div
                                v-if="form.errors.name"
                                class="text-sm text-red-600 mt-1"
                            >
                                {{ form.errors.name }}
                            </div>
                        </div>
                        <div>
                            <label
                                for="stocks"
                                class="block text-sm font-medium text-gray-700"
                                >Number of Stocks</label
                            >
                            <input
                                v-model="form.stock"
                                type="number"
                                id="stocks"
                                class="mt-1 w-full px-3 py-2 border border-gray-400 rounded-md focus:ring-1 focus:ring-[#8B3F93] focus:border-[#8B3F93]"
                            />
                            <div
                                v-if="form.errors.stock"
                                class="text-sm text-red-600 mt-1"
                            >
                                {{ form.errors.stock }}
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </Modal>
</template>
