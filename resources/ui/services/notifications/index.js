import Vue from 'vue';
import get from 'lodash/get';
import Notification from './Notification';

Vue.component('CustomNotification', Notification);

class Notifier {
  constructor() {
    this.emitter = new Vue();
  }
  emit(message, color = null, options = {}) {
    this.emitter.$emit('globalNotifcations', Object.assign({}, options, { color, message }));
  }
  success(message, options = {}) {
    this.emit(message, 'success', options);
  }
  error(message, options = {}) {
    this.emit(message, 'error', options);
  }
  errorFromResponse(error, options = {}) {
    const message =
      get(error, 'response.data.message', get(error, 'response.message')) || 'Something went wrong';

    this.error(message, options);
  }
  info(message, options = {}) {
    this.emit(message, 'info', options);
  }
  warning(message, options = {}) {
    this.emit(message, 'warning', options);
  }
}

window.Notify = new Notifier();
