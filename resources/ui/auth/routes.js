export default {
  path: '/auth',
  component: () => import('./layout'),
  children: [
    {
      path: 'login',
      component: () => import('./login'),
    },
  ],
};
