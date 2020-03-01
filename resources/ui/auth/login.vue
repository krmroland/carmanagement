<template>
  <v-card>
    <v-toolbar class="d-flex justify-center elevation-0">
      <v-toolbar-title centered class="mt-16 mb-8">
        <v-icon size="80" class="text-blue-500">mdi-shield-star-outline</v-icon>
      </v-toolbar-title>
    </v-toolbar>
    <v-card-text>
      <h1 class="my-8 text-center  text-2xl font-bold ">Login form</h1>
      <v-form @submit.prevent="form.post('login', { onSuccess: handleLoggedIn })">
        <v-text-field
          label="Login"
          v-model="form.fields.email"
          prepend-inner-icon="mdi-account-circle-outline"
          :error-messages="form.errors.email"
          type="text"
          outlined
        />

        <v-text-field
          label="Password"
          prepend-inner-icon="mdi-lock"
          type="password"
          v-model="form.fields.password"
          :error-messages="form.errors.password"
          outlined
        />
        <v-divider />
        <v-btn
          color="primary"
          block
          large
          type="submit"
          :loading="form.loading.value"
          :disabled="form.loading.value"
        >
          <v-icon>
            mdi-lock-open-outline
          </v-icon>
          Login
        </v-btn>
      </v-form>
    </v-card-text>
  </v-card>
</template>
<script>
import { useForm } from '@/services/forms';

export default {
  setup() {
    const form = useForm({ fails: false });

    return { form };
  },
  methods: {
    handleLoggedIn() {
      window.location.reload();
    },
  },
};
</script>
