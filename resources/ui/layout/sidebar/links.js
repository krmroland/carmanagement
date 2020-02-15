import React from 'react';
import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import ListItemText from '@material-ui/core/ListItemText';
import ListItemIcon from '@material-ui/core/ListItemIcon';
import Icon from '@material-ui/core/Icon';
import Divider from '@material-ui/core/Divider';
import Folder from '@material-ui/icons/Folder';
import People from '@material-ui/icons/People';
import Star from '@material-ui/icons/Star';
import Settings from '@material-ui/icons/Settings';

const list = [
  {
    label: 'Collections',
    icon: <Folder />,
  },
  {
    label: 'Debtors',
    icon: <People />,
  },
  {
    label: 'Expenditures',
    icon: <Star />,
  },
];

export default ({ onClickItem }) => {
  return (
    <React.Fragment>
      <List className="pt-0">
        {list.map(({ label, icon }, i) => (
          <ListItem key={label} selected={i === 0} button onClick={onClickItem}>
            <ListItemIcon>
              <Icon>{icon}</Icon>
            </ListItemIcon>
            <ListItemText primary={label} primaryTypographyProps={{ noWrap: true }} />
          </ListItem>
        ))}

        <Divider className="m-0" />
        <ListItem button onClick={onClickItem}>
          <ListItemIcon>
            <Settings />
          </ListItemIcon>
          <ListItemText primary="Settings & account" primaryTypographyProps={{ noWrap: true }} />
        </ListItem>
      </List>
    </React.Fragment>
  );
};
