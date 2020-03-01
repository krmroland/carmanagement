import Vue from 'vue';
import VueCompositionApi from '@vue/composition-api';
import App from './App.vue';
import router from './router';
import vuetify from './plugins/vuetify';
import './services/notifications';

import './components/global';
Vue.use(VueCompositionApi);

Vue.config.productionTip = false;

new Vue({
  router,
  vuetify,
  render: h => h(App),
}).$mount('#root');
