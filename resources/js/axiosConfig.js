// resources/js/axiosConfig.js
import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: 'https://chup.local/api/v1', // Your API base URL
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
    // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    // Include other global headers here, e.g., Authorization if you have a token
  },
});

// Add a request interceptor
axiosInstance.interceptors.request.use(function (config) {
  // Do something before request is sent, e.g., add an authorization token
  const token = localStorage.getItem('token');
//   token = '3346|9S4nYhUYin56VzilFW5n05t8kboqYIVssyLW5tGl65625a3d';
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
}, function (error) {
  // Do something with request error
  return Promise.reject(error);
});

// Optionally, add a response interceptor
axiosInstance.interceptors.response.use(function (response) {
  // Any status code that lie within the range of 2xx cause this function to trigger
  return response;
}, function (error) {
  // Any status codes that falls outside the range of 2xx cause this function to trigger
  return Promise.reject(error);
});

export default axiosInstance;
