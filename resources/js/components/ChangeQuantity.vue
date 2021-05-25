<template>
        <div id="option">
                            <div class="spinner-width py-2">
                                <span>Quantity:</span>
                                <input class="input-spinner form-control-sm" type="number" v-model="quantity" min="1" max="100" step="1" @change="changeQty"/>
                            </div>
                        </div>
</template>

<script>
    export default {
        data() {
            return {
                quantity: 1,
            }
        },
        mounted() {
        },
        methods: {
            changeQty() {
                this.$root.$emit("updateQuantity",this.quantity);
            }
        },
    }
</script>
