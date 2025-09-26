<script setup>
import { computed } from "vue";
import { toast } from "@/toast.js";
import CheckCircleIcon from "@/Components/Icons/CheckCircleIcon.vue";
import XCircleIcon from "@/Components/Icons/XCircleIcon.vue";

const toastClasses = computed(() => ({
    "bg-green-600": toast.type === "success",
    "bg-red-600": toast.type === "error",
}));
</script>

<template>
    <Transition
        enter-active-class="ease-out duration-300"
        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
        leave-active-class="ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        <div
            v-if="toast.show"
            :class="toastClasses"
            class="fixed bottom-4 right-4 z-50 flex items-center text-white px-6 py-4 rounded-lg shadow-lg"
        >
            <div class="mr-4">
                <CheckCircleIcon
                    v-if="toast.type === 'success'"
                    class="w-6 h-6"
                />
                <XCircleIcon v-if="toast.type === 'error'" class="w-6 h-6" />
            </div>
            <div>
                {{ toast.message }}
            </div>
        </div>
    </Transition>
</template>
