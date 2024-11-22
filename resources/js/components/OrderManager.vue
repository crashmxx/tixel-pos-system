<template>
    <div>
        <h1>Order List</h1>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="order in orders" :key="order.id">
                <td>{{ order.id }}</td>
                <td>
                    <select v-model="order.status" @change="updateOrderStatus(order)">
                        <option v-for="(name, value) in statusOptions" :value="value" :key="value">
                            {{ name }}
                        </option>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="pagination">
            <button :disabled="page === 1" @click="changePage(page - 1)">Previous</button>
            <span>Page {{ page }}</span>
            <button :disabled="!hasNextPage" @click="changePage(page + 1)">Next</button>
        </div>
    </div>
</template>

<script setup>
import {ref, onMounted} from 'vue';
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
