import React from 'react';
import Button from '@material-ui/core/Button';
import CircularProgress from '@material-ui/core/CircularProgress';

export default props => {
  const { loading, children, ...otherProps } = props;
  return (
    <div className="relative m-1">
      <Button variant="contained" color="primary" disabled={!!loading} {...otherProps}>
        {loading && <CircularProgress size={24} className="absolute" />}
        {children}
      </Button>
    </div>
  );
};
