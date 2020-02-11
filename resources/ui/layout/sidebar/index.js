import React from 'react';
import Avatar from '@material-ui/core/Avatar';
import Typography from '@material-ui/core/Typography';
import Divider from '@material-ui/core/Divider';
import { Sidebar, CollapseBtn, CollapseIcon } from '@mui-treasury/layout';

import Links from './links';

export default ({ collapsed, sidebarStyles }) => {
  return (
    <Sidebar>
      <div
        style={{ padding: collapsed ? 8 : 16, transition: '0.3s' }}
        className="flex justify-center flex-col items-center"
      >
        <Avatar
          style={{
            width: collapsed ? 48 : 60,
            height: collapsed ? 48 : 60,
            transition: '0.3s',
          }}
        />
        <div style={{ paddingBottom: 16 }} />
        {!collapsed && (
          <React.Fragment>
            <Typography variant="h6" noWrap>
              {window.App.user.name}
            </Typography>

            <Typography color="textSecondary" noWrap gutterBottom>
              {window.App.user.email}
            </Typography>
          </React.Fragment>
        )}
      </div>
      <Divider />
      <div className={sidebarStyles.container}>
        <Links />
      </div>
      <CollapseBtn className={sidebarStyles.collapseBtn}>
        <CollapseIcon />
      </CollapseBtn>
    </Sidebar>
  );
};
