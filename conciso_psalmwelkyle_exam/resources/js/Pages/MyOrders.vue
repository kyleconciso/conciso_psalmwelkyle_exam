<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    orders: Array,
    auth: Object,
});

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
    <Head title="My Orders" />

    <div class="text-gray-800 bg-gray-50 font-sans min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <header class="py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <Link :href="route('welcome')">
                        <img src="" alt="PurpleBug Logo" class="h-10" />
                    </Link>
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
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="text-xs text-red-500 hover:underline"
                                >Logout</Link
                            >
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="py-8">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-[#8B3F93]">
                            My Order History
                        </h1>
                        <Link
                            :href="route('welcome')"
                            class="text-sm text-[#8B3F93] hover:underline"
                        >
                            &larr; Back to Shopping
                        </Link>
                    </div>

                    <div class="flex-1 bg-transparent space-y-4">
                        <!-- Table Header -->
                        <div
                            class="bg-gray-100 grid grid-cols-12 gap-4 py-3 px-4 rounded-lg font-bold text-gray-600 text-sm"
                        >
                            <div class="col-span-4">Product</div>
                            <div class="col-span-2 text-center">Quantity</div>
                            <div class="col-span-2 text-center">
                                Total Price
                            </div>
                            <div class="col-span-2 text-center">
                                Date Ordered
                            </div>
                            <div class="col-span-2 text-center">Status</div>
                        </div>

                        <!-- Order Rows -->
                        <div
                            v-if="orders.length > 0"
                            v-for="order in orders"
                            :key="order.id"
                            class="grid grid-cols-12 gap-4 items-center py-4 px-4 border-b"
                        >
                            <div class="col-span-4 font-medium text-gray-800">
                                {{ order.product.name }}
                            </div>
                            <div class="col-span-2 text-center text-gray-600">
                                {{ order.quantity }}
                            </div>
                            <div class="col-span-2 text-center text-gray-600">
                                P {{ order.total_price }}
                            </div>
                            <div
                                class="col-span-2 text-center text-gray-600 text-sm"
                            >
                                {{
                                    new Date(
                                        order.created_at
                                    ).toLocaleDateString()
                                }}
                            </div>
                            <div class="col-span-2 text-center">
                                <span
                                    :class="statusClasses[order.status]"
                                    class="text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded-full"
                                >
                                    {{ order.status }}
                                </span>
                            </div>
                        </div>

                        <div v-else class="text-center text-gray-500 py-8">
                            You haven't placed any orders yet.
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
