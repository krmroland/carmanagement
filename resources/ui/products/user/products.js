import React from 'react';
import InputBase from '@material-ui/core/InputBase';

import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import appContext from '@/app/context';

import ProductCard from './card';

import AddNewProject from './create';

export default () => {
  const {
    user: { products = [] },
  } = React.useContext(appContext);

  console.log({ products });

  return (
    <React.Fragment>
      <div className="px-6 py-2">
        <AddNewProject />
        <InputBase placeholder="Search ...." classes={{ root: ' w-full border px-2 mb-2 mt-6' }} />
      </div>

      <List>
        <ListItem button>
          <ProductCard />
        </ListItem>
      </List>
    </React.Fragment>
  );
};
