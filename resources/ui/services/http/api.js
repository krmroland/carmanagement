import axios from 'axios';
import get from 'lodash/get';

const api = axios.create({
  withCredentials: true,
  headers: { 'X-Requested-With': 'XMLHttpRequest' },
});

api.interceptors.response.use(
  response => response.data,
  error => {
    // Any status codes that falls outside the range of 2xx cause this function to trigger
    // Do something with response error
    // get the error message
    const message = get(error, 'response.data.message', get(error, 'message'));

    if (message) {
      //  probably notify error message
    }
    return Promise.reject(error);
  },
);

export default api;
