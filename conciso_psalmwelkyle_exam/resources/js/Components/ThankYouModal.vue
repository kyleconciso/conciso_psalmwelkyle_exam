<script setup>
import Modal from "@/Components/Modal.vue";

const props = defineProps({
    show: Boolean,
});

const emit = defineEmits(["close"]);

const closeModal = () => {
    emit("close");
};
</script>

<template>
    <Modal :show="show" max-width="lg" @close="closeModal">
        <div
            class="w-full bg-white rounded-lg shadow-lg overflow-hidden p-8 relative"
        >
            <div class="flex flex-col items-center justify-center text-center">
                <div class="flex justify-center items-center mb-8 w-full">
                    <img
                        src="/storage/images/logo.png"
                        alt="PurpleBug Logo"
                        class="max-w-[300px] h-auto"
                    />
                </div>

                <div class="mb-8 w-full">
                    <img
                        src="/storage/images/shopper.png"
                        alt="Thank You Illustration"
                        class="w-full max-w-[300px] mx-auto aspect-square object-cover rounded-lg"
                    />
                </div>

                <p class="text-xl font-medium text-[#8B3F93] mb-8">
                    Thank you for shopping with us.
                </p>

                <button
                    @click="closeModal"
                    class="w-12 h-12 rounded-full border-2 border-[#8B3F93] text-[#8B3F93] flex items-center justify-center hover:bg-[#f3e8f5] transition"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </Modal>
</template>
