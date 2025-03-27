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
        cartItemsCount: {},

        get cartItems() {
            return Object.values(this.cartItemsObject).reduce(
                (accum, next) => accum + parseInt(next.quantity),
                0
            );
        },

        // fetchCart() {
        //     fetch("/") // Update this URL if needed
        //         .then((response) => response.json())
        //         .then((data) => {
        //             this.cartItemsObject = data.cart_Items; // Update cart items
        //             console.log(
        //                 "Cart updated from backend:",
        //                 this.cartItemsObject
        //             );
        //         })
        //         .catch((error) => console.error("Error fetching cart:", error));
        // },
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

            if (this.interval) {
                clearInterval(this.interval);
                this.interval = null;
            }

            if (this.timeout) {
                clearTimeout(this.timeout);
                this.timeout = null;
            }

            // Start the progress bar

            this.interval = setInterval(() => {
                if (this.percent < 100) {
                    this.percent += 100 / (this.delay / 100); // Increment progress
                } else {
                    clearInterval(this.interval);
                }
            }, 100);

            // Hide the toast after the delay
            this.timeout = setTimeout(() => this.close(), this.delay);
        },

        close() {
            this.visible = false;
            this.message = ""; // Clear the message
            // this.percent = 0; // Reset progress bar
            // clearInterval(this.interval); // Clear the progress bar interval

            if (this.interval) {
                clearInterval(this.interval);
                this.interval = null;
            }
            if (this.timeout) {
                clearTimeout(this.timeout);
                this.timeout = null;
            }
            this.percent = 0;
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
                        if (result && result.count !== undefined) {
                            this.$dispatch("cart-change", {
                                count: result.count,
                            });

                            this.$dispatch("notify", {
                                message: "The item was added to cart",
                            });
                            console.log(
                                "Notify event dispatched with message: The item was added to cart"
                            );
                        }
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
                    // this.cartItemsCount = result.count;
                    Alpine.store("header").cartItemsObject = result.count;
                    this.$dispatch("cart-change", { count: result.count });
                    this.$dispatch("notify", {
                        message: "This item quantity was updated",
                    });

                    // Alpine.store("header").fetchCart();
                });
            },
        };
    });
});
//Start Alpine.js AFTER defining all components
Alpine.start();
