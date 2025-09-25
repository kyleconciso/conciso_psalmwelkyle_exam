<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import { cart } from "@/cart.js";
import CartModal from "@/Components/CartModal.vue";

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    products: Array,
    auth: Object,
});

const showCart = ref(false);

const addToCart = (product) => {
    if (!props.auth.user) {
        router.get(route("login"));
        return;
    }
    cart.addItem(product);
};
</script>

<template>
    <Head title="Welcome to PurpleBug Shopping" />

    <div class="text-gray-800 bg-gray-50 font-sans">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <header class="py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <img
                        src="https://placehold.co/160x40/8B3F93/FFFFFF?text=PurpleBug%C2%AE"
                        alt="PurpleBug Logo"
                        class="h-10"
                    />
                    <div v-if="canLogin" class="flex items-center space-x-6">
                        <!-- Logged-in User State -->
                        <div
                            v-if="auth.user"
                            class="flex items-center space-x-4"
                        >
                            <Link
                                :href="route('my-orders.index')"
                                class="text-sm font-medium text-gray-600 hover:text-[#8B3F93]"
                            >
                                My Orders
                            </Link>

                            <!-- Cart Icon -->
                            <button
                                @click="showCart = true"
                                class="relative text-gray-600 hover:text-[#8B3F93]"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                    />
                                </svg>
                                <span
                                    v-if="cart.items.length > 0"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
                                >
                                    {{
                                        cart.items.reduce(
                                            (acc, item) => acc + item.quantity,
                                            0
                                        )
                                    }}
                                </span>
                            </button>

                            <div class="flex items-center space-x-2">
                                <img
                                    src="https://placehold.co/32x32/E2E8F0/4A5568?text=U"
                                    alt="User Avatar"
                                    class="w-8 h-8 rounded-full"
                                />
                                <div>
                                    <p class="text-sm font-medium">
                                        Hi, {{ auth.user.name.split(" ")[0] }}!
                                    </p>
                                    <Link
                                        v-if="auth.user.role === 'Admin'"
                                        :href="route('admin.dashboard')"
                                        class="text-xs text-blue-500 hover:underline"
                                        >Go to CMS</Link
                                    >
                                    <Link
                                        v-else
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="text-xs text-red-500 hover:underline"
                                        >Logout</Link
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Guest-->
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="flex items-center space-x-2 bg-[#8B3F93] text-white font-semibold py-2 px-4 rounded-lg hover:bg-opacity-90 transition"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <span>LOGIN</span>
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="bg-[#8B3F93] text-white font-semibold py-2 px-4 rounded-lg flex items-center space-x-2 hover:bg-opacity-90 transition"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 11a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1v-1z"
                                    />
                                </svg>
                                <span>SIGN UP</span>
                            </Link>
                        </template>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="py-8">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <!-- Search and Sort -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="relative w-full max-w-xs">
                            <input
                                type="text"
                                placeholder="Search"
                                class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8B3F93] focus:border-transparent"
                            />
                            <div
                                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-gray-400"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </div>
                        <div
                            class="flex items-center space-x-1 bg-gray-100 p-1 rounded-lg"
                        >
                            <button
                                class="bg-[#8B3F93] text-white font-semibold py-1.5 px-4 rounded-md text-sm"
                            >
                                Price ascending
                            </button>
                            <button
                                class="text-gray-600 font-semibold py-1.5 px-4 rounded-md text-sm hover:bg-gray-200"
                            >
                                Price descending
                            </button>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div
                        v-if="products.length > 0"
                        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
                    >
                        <div
                            v-for="product in products"
                            :key="product.id"
                            class="bg-white border border-gray-200 rounded-lg p-4 text-left flex flex-col"
                        >
                            <div
                                class="bg-gray-200 w-full h-48 rounded-md flex items-center justify-center mb-4"
                            >
                                <svg
                                    class="w-16 h-16 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    ></path>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500">
                                {{ product.name }}
                            </p>
                            <p class="font-bold">P {{ product.price }}</p>
                            <p class="text-xs text-gray-400">
                                Stock: {{ product.stock }}
                            </p>

                            <div class="mt-auto pt-4">
                                <button
                                    @click="addToCart(product)"
                                    :disabled="product.stock === 0"
                                    class="w-full bg-[#8B3F93] text-white font-semibold py-2 rounded-lg hover:bg-opacity-90 transition text-sm disabled:bg-gray-400 disabled:cursor-not-allowed"
                                >
                                    {{
                                        product.stock > 0
                                            ? "Add to Cart"
                                            : "Out of Stock"
                                    }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center text-gray-500 py-8">
                        No products available at the moment.
                    </div>

                    <!-- Pagination -->
                    <div
                        class="mt-8 flex justify-center items-center space-x-2 text-sm"
                    >
                        <a
                            href="#"
                            class="flex items-center space-x-1 text-gray-500 hover:text-gray-800"
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 19l-7-7 7-7"
                                /></svg
                            ><span>Previous</span></a
                        >
                        <a
                            href="#"
                            class="px-3 py-1 rounded-md bg-[#8B3F93] text-white font-semibold"
                            >1</a
                        >
                        <a
                            href="#"
                            class="px-3 py-1 rounded-md text-gray-600 hover:bg-gray-100"
                            >2</a
                        >
                        <a
                            href="#"
                            class="px-3 py-1 rounded-md text-gray-600 hover:bg-gray-100"
                            >3</a
                        >
                        <span class="text-gray-500">...</span>
                        <a
                            href="#"
                            class="px-3 py-1 rounded-md text-gray-600 hover:bg-gray-100"
                            >67</a
                        >
                        <a
                            href="#"
                            class="px-3 py-1 rounded-md text-gray-600 hover:bg-gray-100"
                            >68</a
                        >
                        <a
                            href="#"
                            class="flex items-center space-x-1 text-gray-500 hover:text-gray-800"
                            ><span>Next</span
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"
                                /></svg
                        ></a>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="py-6 mt-8 border-t border-gray-200">
                <div class="flex flex-col items-center">
                    <img
                        src="https://placehold.co/120x30/8B3F93/FFFFFF?text=PurpleBug%C2%AE"
                        alt="PurpleBug Logo"
                        class="h-8"
                    />
                    <p class="text-xs text-gray-500 mt-2">
                        Copyright 2025 PurpleBug Inc.
                    </p>
                </div>
            </footer>
        </div>

        <CartModal :show="showCart" @close="showCart = false" />
    </div>
</template>
