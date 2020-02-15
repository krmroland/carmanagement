import React from 'react';
import { Layout } from '@/layout';

import { UserProductList } from '@/products';

// import UserContext from './userContext';

//  use full for when we start using organizations
// <div className="self-start w-full  mt-3">
//  <UserContext />
// </div>;
export default () => {
  return (
    <Layout sidebarLinks={<UserProductList />}>
      <h1> Dashboard</h1>
    </Layout>
  );
};
