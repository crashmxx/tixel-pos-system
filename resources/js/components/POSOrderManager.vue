<template>
    <div>
        <h1>Order Details</h1>
        <div v-if="order">
            <p>Order ID: {{ order.id }}</p>
            <p>Status: {{ order.status }}</p>
        </div>
        <div v-else>
            <p>Loading order...</p>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import orderService from '@/services/order';

const order = ref(null);
const orderId = 1; //@todo

onMounted(async () => {
    try {
        const data = await orderService.getOrder(orderId);
        order.value = data.order;
    } catch (error) {
        console.error("Error loading order:", error);
    }
});
</script>

<style scoped>
</style>

