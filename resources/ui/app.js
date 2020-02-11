import React from 'react';
import { ThemeProvider } from '@material-ui/core/styles';
import Layout from './layout';
import theme from './theme';

export default () => {
  return (
    <ThemeProvider theme={theme}>
      <Layout />
    </ThemeProvider>
  );
};
