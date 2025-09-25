import { reactive, computed } from "vue";

export const cart = reactive({
    items: [],

    total: computed(() => {
        return cart.items.reduce(
            (total, item) => total + item.price * item.quantity,
            0
        );
    }),

    addItem(product) {
        const existingItem = this.items.find((item) => item.id === product.id);
        if (existingItem) {
            if (existingItem.quantity < product.stock) {
                existingItem.quantity++;
            } else {
                alert("Cannot add more than available stock");
            }
        } else {
            if (product.stock > 0) {
                this.items.push({ ...product, quantity: 1 });
            } else {
                alert("Product is out of stock");
            }
        }
    },

    removeItem(productId) {
        this.items = this.items.filter((item) => item.id !== productId);
    },

    clear() {
        this.items = [];
    },
});
