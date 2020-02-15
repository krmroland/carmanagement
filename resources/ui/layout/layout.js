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
  fixedLayoutPreset,
} from '@mui-treasury/layout';

import TopHeader from './header';

import { Sidebar } from './sidebar';

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

export default ({ sidebarLinks, sidebarHeader, children }) => {
  const classes = useStyles();

  return (
    <Root config={fixedLayoutPreset}>
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
            <Sidebar
              sidebarStyles={sidebarStyles}
              collapsed={collapsed}
              sidebarLinks={sidebarLinks}
              sidebarHeader={sidebarHeader}
              className="bg-green-500"
            />
            <Content>
              <div className={classes.root}>{children}</div>
            </Content>
            <Footer />
          </React.Fragment>
        );
      }}
    </Root>
  );
};
