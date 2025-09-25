<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { cart } from "@/cart.js";
import CartModal from "@/Components/CartModal.vue";
import ThankYouModal from "@/Components/ThankYouModal.vue";
import Pagination from "@/Components/Pagination.vue"; // The new pagination component
import { debounce } from "lodash"; // A utility to delay function execution

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    products: Object, // Products is now a paginator object { data, links, ... }
    auth: Object,
    filters: Object, // The current search/sort filters from the backend
});

const showCart = ref(false);
const showThankYou = ref(false);

// Reactive refs bound to the form inputs. Initialized with values from the backend.
const searchTerm = ref(props.filters.search || "");
const sortOrder = ref(props.filters.sort || "latest");

// This watches for any changes to our search or sort refs.
// When they change, it sends a GET request to the backend with the new values.
// `debounce` prevents sending a request on every single keystroke.
watch(
    [searchTerm, sortOrder],
    debounce(() => {
        router.get(
            route("welcome"),
            {
                search: searchTerm.value,
                sort: sortOrder.value,
            },
            {
                preserveState: true, // Prevents losing focus on the search input
                replace: true, // Avoids polluting browser history
            }
        );
    }, 300)
); // 300ms delay

const addToCart = (product) => {
    if (!props.auth.user) {
        router.get(route("login"));
        return;
    }
    cart.addItem(product);
};

const handleOrderPlaced = () => {
    showThankYou.value = true;
};
</script>

<template>
    <Head title="Welcome to PurpleBug Shopping" />

    <div class="text-gray-800 bg-gray-50 font-sans">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <header class="py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <Link :href="route('welcome')">
                        <img
                            src="/storage/images/logo.png"
                            alt="PurpleBug Logo"
                            class="h-10"
                        />
                    </Link>
                    <div v-if="canLogin" class="flex items-center space-x-6">
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
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="flex items-center space-x-2 bg-[#8B3F93] text-white font-semibold py-2 px-4 rounded-lg hover:bg-opacity-90 transition"
                            >
                                <img
                                    src="/storage/images/login.svg"
                                    class="h-5 w-5"
                                    alt="Login icon"
                                />
                                <span>LOGIN</span>
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="bg-[#8B3F93] text-white font-semibold py-2 px-4 rounded-lg flex items-center space-x-2 hover:bg-opacity-90 transition"
                            >
                                <img
                                    src="/storage/images/signup.svg"
                                    class="h-5 w-5"
                                    alt="Sign Up icon"
                                />
                                <span>SIGN UP</span>
                            </Link>
                        </template>
                    </div>
                </div>
            </header>

            <main class="py-8">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <div class="relative w-full max-w-xs">
                            <input
                                v-model="searchTerm"
                                type="text"
                                placeholder="Search products..."
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
                                @click="sortOrder = 'price_asc'"
                                :class="{
                                    'bg-[#8B3F93] text-white':
                                        sortOrder === 'price_asc',
                                    'text-gray-600 hover:bg-gray-200':
                                        sortOrder !== 'price_asc',
                                }"
                                class="font-semibold py-1.5 px-4 rounded-md text-sm transition"
                            >
                                Price ascending
                            </button>
                            <button
                                @click="sortOrder = 'price_desc'"
                                :class="{
                                    'bg-[#8B3F93] text-white':
                                        sortOrder === 'price_desc',
                                    'text-gray-600 hover:bg-gray-200':
                                        sortOrder !== 'price_desc',
                                }"
                                class="font-semibold py-1.5 px-4 rounded-md text-sm transition"
                            >
                                Price descending
                            </button>
                        </div>
                    </div>

                    <div
                        v-if="products.data.length > 0"
                        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
                    >
                        <div
                            v-for="product in products.data"
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
                        No products found matching your search.
                    </div>

                    <Pagination :links="products.links" />
                </div>
            </main>

            <footer class="py-6 mt-8 border-t border-gray-200">
                <div class="flex flex-col items-center">
                    <img
                        src="/storage/images/logo.png"
                        alt="PurpleBug Logo"
                        class="h-8 opacity-75"
                    />
                    <p class="text-xs text-gray-500 mt-2">
                        Copyright 2025 PurpleBug Inc.
                    </p>
                </div>
            </footer>
        </div>

        <CartModal
            :show="showCart"
            @close="showCart = false"
            @order-placed="handleOrderPlaced"
        />
        <ThankYouModal :show="showThankYou" @close="showThankYou = false" />
    </div>
</template>
