import React from 'react';
import { Switch, Route } from 'react-router-dom';
import { DashboardView } from '@/dashboard';

export default () => {
  return (
    <Switch>
      <Route path="/">
        <DashboardView />
      </Route>
    </Switch>
  );
};
