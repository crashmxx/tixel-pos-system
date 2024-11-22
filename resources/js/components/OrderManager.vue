<template>
    <div class="p-6 bg-gray-50 rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Order List</h1>

        <table class="min-w-full table-auto bg-white shadow-md rounded-lg">
            <thead>
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">ID</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Status</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="order in orders" :key="order.id" class="hover:bg-gray-100">
                <td class="px-4 py-2 text-sm text-gray-700">{{ order.id }}</td>
                <td class="px-4 py-2">
                    <select v-model="order.status" @change="updateOrderStatus(order)" class="border rounded-md p-2 w-full text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option v-for="(name, value) in statusOptions" :value="value" :key="value">
                            {{ name }}
                        </option>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="mt-6 flex justify-between items-center">
            <button :disabled="page === 1" @click="changePage(page - 1)" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 disabled:bg-gray-300">Previous</button>
            <span class="text-lg font-medium text-gray-700">Page {{ page }}</span>
            <button :disabled="!hasNextPage" @click="changePage(page + 1)" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 disabled:bg-gray-300">Next</button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import orderService from '@/services/order';

const orders = ref([]);
const page = ref(1);
const limit = 10;
const hasNextPage = ref(false);
const statusOptions = ref({});

const fetchOrders = async () => {
    const response = await orderService.getOrders(limit, page.value);
    orders.value = response.orders.data;
    hasNextPage.value = response.orders.current_page < response.orders.last_page;
    statusOptions.value = response.statuses;
};

const updateOrderStatus = async(order) => {
    await orderService.updateOrderStatus(order.id, order.status);
};

const changePage = (newPage) => {
    page.value = newPage;
    fetchOrders();
};

onMounted(fetchOrders);
</script>
