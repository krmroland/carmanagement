import Layout from './layout/app';

export default {
  path: '/',
  component: Layout,
  children: [
    { path: 'products', component: require('./products').default },
    { path: 'tenants', component: require('./tenants').default },
    { path: 'Payments', component: require('./payments').default },
  ],
};
