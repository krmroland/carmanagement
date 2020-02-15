import React from 'react';

const user = window.App.user;

export default React.createContext({
  user,
  organization: {},
  updateOrganization: () => {},
});
