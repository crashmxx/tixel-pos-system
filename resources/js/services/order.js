import axios from 'axios';

// No token in your case, we assume the API is expose only for the POS System
axios.defaults.baseURL = 'http://localhost/api';

const getOrders = async (limit = 10, page = 1) => {
    try {
        const response = await axios.get('/orders', {
            params: { limit, page },
        });
        return response.data;
    } catch (error) {
        throw error;
    }
};

const updateOrderStatus = async (orderId, status) => {
    console.log(`Call API: Updating order ${orderId} to status ${status}`);
    return { success: true, message: 'Order updated successfully.' };
};

export default {
    getOrders,
    updateOrderStatus
};
