import React from 'react';

import { makeStyles } from '@material-ui/core/styles';

import InputBase from '@material-ui/core/InputBase';
import IconButton from '@material-ui/core/IconButton';
import Typography from '@material-ui/core/Typography';
import Search from '@material-ui/icons/Search';
import MoreVert from '@material-ui/icons/MoreVert';

const useStyles = makeStyles(({ spacing, transitions, breakpoints, palette, shape }) => ({
  search: {
    position: 'relative',
    marginRight: 8,
    borderRadius: shape.borderRadius,
    background: palette.grey[200],
    '&:hover': {
      background: palette.grey[300],
    },
    marginLeft: 0,
    width: '100%',
    [breakpoints.up('sm')]: {
      marginLeft: spacing(1),
      width: 'auto',
    },
  },
  searchIcon: {
    width: spacing(9),
    height: '100%',
    position: 'absolute',
    pointerEvents: 'none',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
  },
  inputRoot: {
    color: 'inherit',
    width: '100%',
  },
  inputInput: {
    borderRadius: 4,
    paddingTop: spacing(1),
    paddingRight: spacing(1),
    paddingBottom: spacing(1),
    paddingLeft: spacing(10),
    transition: transitions.create('width'),
    width: '100%',
    [breakpoints.up('sm')]: {
      width: 120,
      '&:focus': {
        width: 200,
      },
    },
  },
}));

export default ({ screen, collapsed }) => {
  const classes = useStyles();
  return (
    <div className="flex w-full">
      {!collapsed && (
        <Typography noWrap color="textSecondary" className="font-black text-xl min-w-0">
          My Rentals
        </Typography>
      )}

      <div className="flex-grow" />
      <div className={classes.search}>
        <div className={classes.searchIcon}>
          <Search />
        </div>

        <InputBase
          placeholder="Search ...."
          classes={{
            root: classes.inputRoot,
            input: classes.inputInput,
          }}
        />
      </div>
      {screen === 'xs' && (
        <IconButton>
          <MoreVert />
        </IconButton>
      )}
    </div>
  );
};
