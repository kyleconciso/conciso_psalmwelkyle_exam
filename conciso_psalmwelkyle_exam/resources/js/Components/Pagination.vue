<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    links: Array,
});
</script>

<template>
    <div
        v-if="links.length > 3"
        class="mt-8 flex justify-center items-center space-x-1 text-sm"
    >
        <template v-for="(link, key) in links" :key="key">
            <div
                v-if="link.url === null"
                class="px-3 py-1 rounded-md text-gray-400"
                v-html="link.label"
            />
            <Link
                v-else
                class="px-3 py-1 rounded-md"
                :class="{
                    'bg-[#8B3F93] text-white font-semibold': link.active,
                    'text-gray-600 hover:bg-gray-100': !link.active,
                }"
                :href="link.url"
                v-html="link.label"
            />
        </template>
    </div>
</template>
