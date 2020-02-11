import React from 'react';
import debounce from 'lodash/debounce';
import each from 'lodash/each';
import get from 'lodash/get';
import has from 'lodash/has';
import omit from 'lodash/omit';

import http from './api';

export const useHttpData = (url, params = {}, method = 'get') => {
  const [data, updateData] = React.useState(null);
  const [isFetching, updateIsFetching] = React.useState(false);
  const [error, updateError] = React.useState(null);
  const [query, updateQueryState] = React.useState(params);

  const fetch = () => {
    if (!isFetching && url) {
      updateIsFetching(true);

      if (error) {
        updateError(null);
      }

      http[method](url, { params: query })
        .then(({ data: response }) => updateData(response))
        .catch(error => updateError(get(error, 'response.data', error)))
        .finally(() => updateIsFetching(false));
    }
  };

  // if the value is a empty and we have it in the query
  // we will have to delete it
  const shouldDeleteKeyFromQuery = (key, value) => {
    return (value === null || value === undefined || value === '') && has(query, key);
  };

  const updateQuery = data => {
    const result = { ...query };
    each(data, (value, key) => {
      if (shouldDeleteKeyFromQuery(key, value)) {
        delete result[key];
      } else {
        result[key] = value;
      }
    });
    updateQueryState(result);
  };

  const updateKeyValueInQuery = (key, value) => {
    // if the value is a empty and we have it in the query
    // we will have to delete it
    if (shouldDeleteKeyFromQuery(key, value)) {
      return updateQueryState(omit(query, key));
    }

    if (value !== query[key]) {
      updateQueryState({ ...query, [key]: value });
    }
  };

  const updateSearch = debounce(function(value, key = 'search') {
    // reset current page
    updateQuery({ paage: 1, [key]: value });
  }, 500);

  const updateSort = fields => {
    return updateKeyValueInQuery('sort', fields);
  };

  /* eslint-disable-next-line react-hooks/exhaustive-deps */
  React.useEffect(() => fetch(), [url, query]);

  return {
    isFetching,
    data,
    error,
    updateQuery,
    query,
    updateKeyValueInQuery,
    updateSearch,
    updateSort,
  };
};

export const useSendHttpData = (method = 'post') => {
  const [response, updateResponse] = React.useState(null);
  const [error, updateError] = React.useState({});
  const [isBusy, updateIsBusy] = React.useState(false);

  const makeHttpCall = (url, data = {}, options = {}) => {
    updateIsBusy(true);
    updateError(null);
    return http[method || 'post'](url, data, options)
      .then(({ data }) => {
        updateResponse(data);
        updateIsBusy(false);
        return Promise.resolve(data);
      })
      .catch(error => {
        updateIsBusy(false);
        updateError(error);
        return Promise.reject(error);
      });
  };

  return {
    error,
    isBusy,
    response,
    send: (url, data, options) => makeHttpCall(url, data, options),
  };
};
