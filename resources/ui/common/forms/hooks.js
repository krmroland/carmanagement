import React from 'react';
import get from 'lodash/get';
import each from 'lodash/each';
import first from 'lodash/first';
import { useSendHttpData } from '@/services/http';

export const useForm = (fields = {}) => {
  const [values, updateValues] = React.useState(fields);

  const updateValue = (key, value) => {
    updateValues({ ...values, [key]: value });
  };

  const handleOnChange = name => event => {
    return updateValue(name, event.target ? event.target.value : event);
  };

  return {
    values,
    updateValue,
    handleOnChange,
  };
};

export const useAPIForm = (method, fields) => {
  const { error, isBusy, send } = useSendHttpData(String(method).toLowerCase());

  const { values, updateValue, handleOnChange } = useForm(fields);

  const [formattedErrors, updateFormattedErrors] = React.useState({});

  const formatErrors = () => {
    const result = {};
    if (get(error, 'response.status') === 422) {
      const errors = get(error, 'response.data.errors', {});

      each(errors, (values, name) => {
        result[name] = first(values);
      });
    }
    updateFormattedErrors(result);
  };

  /* eslint-disable-next-line react-hooks/exhaustive-deps */
  React.useEffect(() => formatErrors(), [error]);

  return {
    values,
    updateValue,
    handleOnChange,
    error,
    isBusy,
    send,
    formattedErrors,
  };
};
