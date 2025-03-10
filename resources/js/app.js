import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";
import { post } from "./http.js";

Alpine.plugin(collapse);
window.Alpine = Alpine;

// Define Alpine components BEFORE starting Alpine
document.addEventListener("alpine:init", () => {
    Alpine.store("header", {
        //productItem: {},
        cartItemsObject: {},
        //cartItemsCount: {},

        get cartItems() {
            return Object.values(this.cartItemsObject).reduce(
                (accum, next) => accum + parseInt(next.quantity),
                0
            );
        },
    });
    Alpine.data("toast", () => ({
        message: null,
        visible: false,
        percent: 0,
        interval: null,
        delay: 5000,
        timeout: null,

        show(message) {
            this.message = message;
            this.visible = true;
            this.percent = 0; // Reset progress bar
            console.log("toast show:", message); // Debugging log
            console.log("toast visible:", this.visible); // Debugging log
            //setTimeout(() => (this.visible = false), 5000);
            // clearTimeout(this.timeout); // Clear any existing timeout
            // this.timeout = setTimeout(() => this.close(), this.delay);

            if (this.interval) {
                clearInterval(this.interval);
                this.interval = null;
            }

            if (this.timeout) {
                clearTimeout(this.timeout);
                this.timeout = null;
            }

            // this.timeout = setTimeout(() => {
            //     this.visible = false;
            // }, this.delay);
        },

        close() {
            this.visible = false;
            this.message = ""; // Clear the message
            this.percent = 0; // Reset progress bar
            clearInterval(this.interval); // Clear the progress bar interval
        },
    }));

    Alpine.data("productItem", (product) => {
        console.log("Product Data:", product);
        return {
            product,
            message: "",

            addToCart(quantity = 1) {
                post(this.product.addToCartUrl, { quantity })
                    .then((result) => {
                        this.$dispatch("cart-change", { count: result.count });
                        this.$dispatch("notify", {
                            message: "The item was added to cart",
                        });
                    })

                    .catch((response) => {
                        console.log(response);
                    });
            },

            removeItemFromCart() {
                post(this.product.removeUrl).then((result) => {
                    this.$dispatch("cart-change", { count: result.count });
                    this.$dispatch("notify", {
                        message: "The item was removed from cart",
                    });
                    this.cartItems = this.cartItems.filter(
                        (p) => p.id !== product.id
                    );
                });
            },

            changeQuantity() {
                post(this.product.updateQuantityUrl, {
                    quantity: this.product.quantity,
                }).then((result) => {
                    this.cartItemsCount = result.count;
                    this.$dispatch("cart-change", { count: result.count });
                    this.$dispatch("notify", {
                        message: "This item quantity was updated",
                    });
                });
            },
        };
    });
});
//Start Alpine.js AFTER defining all components
Alpine.start();
