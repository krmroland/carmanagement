import React from 'react';
import PropTypes from 'prop-types';
import TextField from '@material-ui/core/TextField';

const Input = props => {
  const { form, name, ...otherProps } = props;

  return (
    <TextField
      variant="outlined"
      name={name}
      margin="normal"
      fullWidth
      label="Email"
      value={form.values[name] || ''}
      error={!!form.formattedErrors[name]}
      helperText={form.formattedErrors[name]}
      onChange={e => {
        form.updateValue(name, e.target.value);
      }}
      {...otherProps}
    />
  );
};

Input.propTypes = {
  form: PropTypes.shape({
    values: PropTypes.object.isRequired,
    formattedErrors: PropTypes.object.isRequired,
    updateValue: PropTypes.func.isRequired,
  }).isRequired,
};

export default Input;
