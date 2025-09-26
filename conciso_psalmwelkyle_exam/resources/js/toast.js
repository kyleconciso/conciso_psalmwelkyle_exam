import { reactive } from "vue";

export const toast = reactive({
    show: false,
    message: "",
    type: "success",

    showToast(message, type = "success", duration = 4000) {
        this.message = message;
        this.type = type;
        this.show = true;

        setTimeout(() => {
            this.show = false;
        }, duration);
    },
});
