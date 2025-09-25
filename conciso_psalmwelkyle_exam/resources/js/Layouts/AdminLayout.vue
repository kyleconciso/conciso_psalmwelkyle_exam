<script setup>
import { Link } from "@inertiajs/vue3";
import InboxIcon from "@/Components/Icons/InboxIcon.vue";
import UsersIcon from "@/Components/Icons/UsersIcon.vue";
</script>

<template>
    <div class="min-h-screen bg-[#8B3F93]/15 font-sans">
        <aside class="w-70 bg-white flex flex-col shadow-lg fixed h-full">
            <div class="p-6">
                <img
                    src="/storage/images/logo.png"
                    alt="PurpleBug Logo"
                    class="w-full h-10 object-contain"
                />
            </div>
            <hr class="border-gray-200 mx-4" />

            <nav class="flex-1 px-4 py-2 space-y-2 mt-4">
                <Link
                    :href="route('admin.products.index')"
                    class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg"
                    :class="{
                        'bg-[#8B3F93]/50 text-white hover:bg-[#8B3F93]/50':
                            route().current('admin.products.index'),
                    }"
                >
                    <InboxIcon class="h-6 w-6 mr-3" />
                    <span class="font-medium">Products Management</span>
                </Link>

                <Link
                    :href="route('admin.orders.index')"
                    class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg"
                    :class="{
                        'bg-[#8B3F93]/50 text-white hover:bg-[#8B3F93]/50':
                            route().current('admin.orders.index'),
                    }"
                >
                    <InboxIcon class="h-6 w-6 mr-3" />
                    <span class="font-medium">Orders</span>
                </Link>

                <Link
                    :href="route('admin.users.index')"
                    class="flex items-center px-4 py-3 text-gray-600 rounded-lg"
                    :class="{
                        'bg-[#8B3F93]/50 text-white hover:bg-[#8B3F93]/50':
                            route().current('admin.users.index'),
                    }"
                >
                    <UsersIcon class="h-6 w-6 mr-3" />
                    <span class="font-medium">Users Management</span>
                </Link>
            </nav>

            <div class="p-4 border-t border-gray-200 mt-auto">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden"
                        >
                            <img
                                src="/storage/images/user2.svg"
                                class="h-6 w-6 text-gray-500"
                                alt="User Avatar"
                            />
                        </div>
                        <span class="font-medium text-sm text-gray-700"
                            >Hi,
                            {{
                                $page.props.auth.user.name.split(" ")[0]
                            }}!</span
                        >
                    </div>
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="text-red-500 hover:text-red-700"
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
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1 a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                            />
                        </svg>
                    </Link>
                </div>
            </div>
        </aside>

        <main class="flex-1 p-8 flex flex-col ml-64 overflow-y-auto">
            <slot />
        </main>
    </div>
</template>
