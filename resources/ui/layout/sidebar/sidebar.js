import React from 'react';
import Avatar from '@material-ui/core/Avatar';
import Typography from '@material-ui/core/Typography';
import Divider from '@material-ui/core/Divider';
import { Sidebar } from '@mui-treasury/layout';
import appContext from '@/app/context';

export default ({ collapsed, sidebarLinks, sidebarStyles, sidebarHeader, ...props }) => {
  const { user } = React.useContext(appContext);

  return (
    <Sidebar {...props} PaperProps={{ className: '' }}>
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

        <Typography variant="h6" noWrap>
          {user.name}
        </Typography>

        <Typography color="textSecondary" noWrap gutterBottom>
          {user.email}
        </Typography>

        {sidebarHeader}
      </div>
      <Divider />
      <div>{sidebarLinks}</div>
    </Sidebar>
  );
};
