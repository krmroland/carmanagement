import React from 'react';
import { ThemeProvider } from '@material-ui/core/styles';

import { BrowserRouter } from 'react-router-dom';
import Routes from '@/routes';
import theme from '@/theme';

console.log({ theme });
export default () => {
  return (
    <ThemeProvider theme={theme}>
      <BrowserRouter>
        <Routes />
      </BrowserRouter>
    </ThemeProvider>
  );
};
