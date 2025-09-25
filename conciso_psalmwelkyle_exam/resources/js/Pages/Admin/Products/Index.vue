<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import ProductModal from "./Partials/ProductModal.vue";

defineProps({
    products: Array,
});

const showProductModal = ref(false);
const selectedProduct = ref(null);

const openModal = (product = null) => {
    selectedProduct.value = product;
    showProductModal.value = true;
};

const deleteProduct = (product) => {
    if (confirm(`Are you sure you want to delete ${product.name}?`)) {
        router.delete(route("admin.products.destroy", product.id));
    }
};
</script>

<template>
    <Head title="Products Management" />
    <AdminLayout>
        <div
            class="bg-white p-6 rounded-xl shadow-lg flex justify-between items-center mb-8"
        >
            <h2 class="text-2xl font-bold text-[#8B3F93]">
                Products Management
            </h2>
            <button
                @click="openModal()"
                class="bg-[#65558F] text-white font-bold py-2 px-6 rounded-full hover:bg-opacity-90 transition"
            >
                Add Product
            </button>
        </div>

        <div class="flex-1 bg-transparent space-y-4">
            <div
                class="bg-[#8B3F93] text-white grid grid-cols-12 gap-4 py-5 px-4 rounded-xl font-bold items-center"
            >
                <div class="col-span-5">Product Name</div>
                <div class="col-span-2">Price</div>
                <div class="col-span-3">Number of Stocks</div>
                <div class="col-span-2 text-center">Action</div>
            </div>

            <div
                v-for="product in products"
                :key="product.id"
                class="bg-white p-4 rounded-xl shadow-lg grid grid-cols-12 gap-4 items-center"
            >
                <div class="col-span-5 font-medium text-gray-800">
                    {{ product.name }}
                </div>
                <div class="col-span-2 text-gray-600">
                    P {{ product.price }}
                </div>
                <div class="col-span-3 text-gray-600">{{ product.stock }}</div>
                <div
                    class="col-span-2 flex items-center space-x-4 justify-center"
                >
                    <button
                        @click="openModal(product)"
                        class="text-gray-500 hover:text-blue-500"
                    >
                        <svg
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
                        @click="deleteProduct(product)"
                        class="text-gray-500 hover:text-red-500"
                    >
                        <svg
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
                v-if="!products.length"
                class="bg-white p-4 rounded-xl shadow-lg text-center text-gray-500"
            >
                No products found. Click "Add Product" to create one.
            </div>
        </div>
    </AdminLayout>

    <ProductModal
        :show="showProductModal"
        :product="selectedProduct"
        @close="showProductModal = false"
    />
</template>
