import axios from 'axios';
import get from 'lodash/get';
import combineURLs from 'axios/lib/helpers/combineURLs';
import buildURL from 'axios/lib/helpers/buildURL';

export const API_URL = 'http://localhost:8000';

const api = axios.create({
  baseURL: API_URL,
});

api.interceptors.request.use(
  config => {
    // Do something before request is sent
    return config;
  },
  error => {
    // Do something with request error
    return Promise.reject(error);
  },
);

// Add a response interceptor
api.interceptors.response.use(
  response => response,
  error => {
    // run a notification
    const message = get(
      error,
      'response.data.message',
      get(error, 'message', 'Something went wrong'),
    );
    if (message && window.Notify) {
      window.Notify.emit(message, null);
    }
    return Promise.reject(error);
  },
);

export const makeApiUrl = (path, params) => {
  return buildURL(combineURLs(API_URL, path), params);
};

export default api;
