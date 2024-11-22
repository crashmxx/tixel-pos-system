import axios from 'axios';

// No token in your case, we assume the API is expose only for the POS System
axios.defaults.baseURL = 'http://localhost/api';

const getOrder = async (orderId) => {
    try {
        const response = await axios.get(`/orders/${orderId}`);
        return response.data;
    } catch (error) {
        console.error('Error fetching order:', error);
        throw error;
    }
};

export default {
    getOrder,
};
