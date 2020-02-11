import React from 'react';
import CssBaseline from '@material-ui/core/CssBaseline';
import Toolbar from '@material-ui/core/Toolbar';
import LinearProgress from '@material-ui/core/LinearProgress';
import { makeStyles } from '@material-ui/core/styles';

import {
  Root,
  Header,
  Content,
  Footer,
  SidebarTrigger,
  SidebarTriggerIcon,
  cozyLayoutPreset,
} from '@mui-treasury/layout';

import TopHeader from './header';

import Sidebar from './sidebar';

const useStyles = makeStyles(({ breakpoints, transitions }) => {
  return {
    root: {
      padding: 16,
      transition: transitions.create(),
      [breakpoints.up('sm')]: {
        padding: 24,
        maxWidth: 700,
        margin: 'auto',
      },
      [breakpoints.up('md')]: {
        maxWidth: 960,
      },
    },
  };
});

export default () => {
  const classes = useStyles();
  console.log({ classes });

  return (
    <Root config={cozyLayoutPreset}>
      {({ headerStyles, sidebarStyles, collapsed }) => {
        return (
          <React.Fragment>
            <CssBaseline />
            <Header>
              <Toolbar>
                <SidebarTrigger className={headerStyles.leftTrigger}>
                  <SidebarTriggerIcon />
                </SidebarTrigger>
                <LinearProgress variant="query" />
                <TopHeader collapsed={collapsed} />
              </Toolbar>
            </Header>
            <Sidebar sidebarStyles={sidebarStyles} collapsed={collapsed} />
            <Content>
              <div className={classes.root}>
                <h1> Hello world</h1>
              </div>
            </Content>
            <Footer />
          </React.Fragment>
        );
      }}
    </Root>
  );
};
