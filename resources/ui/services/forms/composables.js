import { ref, reactive } from '@vue/composition-api';
import set from 'lodash/set';
import get from 'lodash/get';
import first from 'lodash/first';
import isFunction from 'lodash/isFunction';
import { http } from '@/services/http';

const extractResponseErrors = error => {
  const result = {};

  if (get(error, 'response.status') === 422) {
    const validationErrors = get(error, 'response.data.errors');

    Object.keys(validationErrors).forEach(field => {
      result[field] = first(validationErrors[field]);
    });
  }

  return result;
};

export const useForm = (options = { data: {} }) => {
  const loading = ref(false);

  const fields = reactive(options.data || {});

  const errors = reactive({});

  const clearItems = items => {
    for (let field in items) {
      delete items[field];
    }
  };

  const submit = (url, method, options = {}) => {
    const json = options.json ? options.json : fields;

    if (loading.value) {
      return;
    }
    loading.value = true;

    clearItems(errors);

    return http[method](url, json)
      .then(response => {
        loading.value = false;

        clearItems(fields);

        if (isFunction(options.onSuccess)) {
          options.onSuccess(response);
        }

        return Promise.resolve(response);
      })
      .catch(error => {
        loading.value = false;

        Object.assign(errors, extractResponseErrors(error));

        if (isFunction(options.onError)) {
          return options.onError(errors, error);
        }
      });
  };

  const post = (url, options = {}) => submit(url, 'post', options);

  const put = (url, options = {}) => submit(url, 'put', options);

  const updateValue = (key, value) => set(fields, key, value);

  const getValue = key => get(fields, key);

  return { loading, fields, errors, put, post, updateValue, getValue };
};
