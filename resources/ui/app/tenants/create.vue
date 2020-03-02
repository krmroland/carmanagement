<template>
  <v-dialog :value="isOpen" max-width="400px" scrollable persistent @input="close">
    <v-card flat tile>
      <v-card-title class="justify-between">
        <h4 class="title font-semibold">New Tenant</h4>
        <v-btn icon color="primary" @click="close">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-card-title>
      <v-divider />
      <v-card-text>
        <form
          @submit.prevent="
            form.post('/api/v1/tenants', { onSuccess: tenant => $emit('created', tenant) })
          "
        >
          <v-text-field
            label="First Name"
            v-model="form.fields.first_name"
            :error-messages="form.errors.first_name"
            outlined
            prepend-inner-icon="mdi-account-circle-outline"
            required
            class="mt-6"
          />

          <v-text-field
            prepend-inner-icon="mdi-account-circle-outline"
            label="Last Name"
            v-model="form.fields.last_name"
            :error-messages="form.errors.last_name"
            outlined
            required
          />

          <v-text-field
            prepend-inner-icon="mdi-email-plus-outline"
            label="Email"
            outlined
            v-model="form.fields.email"
            :error-messages="form.errors.email"
          />

          <v-text-field
            prepend-inner-icon="mdi-phone"
            label="Phone Number"
            outlined
            v-model="form.fields.phone_number"
            :error-messages="form.errors.phone_number"
            required
          />
          <v-btn
            color="primary"
            block
            type="submit"
            large
            :loading="form.loading.value"
            :disabled="form.loading.value"
          >
            <v-icon class="mr-1">mdi-account-plus-outline</v-icon>
            Save
          </v-btn>
        </form>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
<script>
import { useForm } from '@/services/forms';

export default {
  props: {
    isOpen: Boolean,
  },
  setup() {
    const form = useForm();

    return { form };
  },
  methods: {
    close() {
      this.$emit('update:isOpen', false);
    },
  },
};
</script>
