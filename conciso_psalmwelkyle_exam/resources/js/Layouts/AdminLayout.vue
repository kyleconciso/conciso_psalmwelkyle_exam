<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <!-- Set the entire screen background to the light purple tint -->
    <div class="flex h-screen bg-[#8B3F93]/15 font-sans">
        <!-- Sidebar: Has a white background and margin -->
        <aside class="w-64 bg-white m-4 rounded-xl flex flex-col shadow-lg">
            <div class="p-6">
                <img
                    src=""
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
                            route().current('admin.products.*'),
                    }"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 mr-3"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                        />
                    </svg>
                    <span class="font-medium">Products Management</span>
                </Link>
                <Link
                    href="#"
                    class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg"
                    :class="{
                        'bg-[#8B3F93]/50 text-white hover:bg-[#8B3F93]/50':
                            route().current('admin.orders.*'),
                    }"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 mr-3"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"
                        />
                    </svg>
                    <span class="font-medium">Orders</span>
                </Link>
                <Link
                    :href="route('admin.users.index')"
                    class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 rounded-lg"
                    :class="{
                        'bg-[#8B3F93]/50 text-white hover:bg-[#8B3F93]/50':
                            route().current('admin.users.index'),
                    }"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 mr-3"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197M15 21a6 6 0 006-6v-1a6 6 0 00-9-5.197"
                        />
                    </svg>
                    <span class="font-medium">Users Management</span>
                </Link>
            </nav>

            <div class="p-4 border-t border-gray-200 mt-auto">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 text-gray-500"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                />
                            </svg>
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
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                            />
                        </svg>
                    </Link>
                </div>
            </div>
        </aside>

        <!-- Main Content: This area has no background, it is transparent, letting the root div's color show through -->
        <main class="flex-1 p-4 pr-8 pt-8 flex flex-col">
            <slot />
        </main>
    </div>
</template>
