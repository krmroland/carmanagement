<template>
  <div class="mt-2 h-full">
    <div class="mb-5 md:flex items-center">
      <v-btn
        depressed
        color="primary"
        large
        @click="isCreating = !isCreating"
        class="mb-3 md:mb-0"
        :block="$vuetify.breakpoint.xsOnly"
      >
        New Tenant
      </v-btn>
      <new-tenant :is-open.sync="isCreating" @created="handleCreated" />
      <v-spacer />
      <v-text-field
        hide-details
        outlined
        placeholder="Search"
        solo
        prepend-inner-icon="mdi-account-search-outline"
      />
      <v-spacer />
    </div>

    <v-simple-table>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">#</th>
            <th class="text-left">Name</th>
            <th class="text-left" v-if="$vuetify.breakpoint.mdAndUp">Email</th>
            <th class="text-left" v-if="$vuetify.breakpoint.mdAndUp">Phone Number</th>
            <th class="text-left">Dues</th>
            <th class="text-left">Product</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in data" :key="item.id" class="mb-5 ">
            <td>
              <v-avatar size="32px" item large>
                <v-img src="https://cdn.vuetifyjs.com/images/logos/logo.svg" alt="Vuetify"
              /></v-avatar>
            </td>
            <td>{{ item.first_name }}</td>
            <td v-if="$vuetify.breakpoint.mdAndUp">{{ item.email }}</td>
            <td v-if="$vuetify.breakpoint.mdAndUp">{{ item.phone_number }}</td>
            <td>{{ item.total_dues }}</td>
            <td></td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
  </div>
</template>
<script>
import { http } from '@/services/http';
export default {
  components: {
    NewTenant: require('./create').default,
  },
  mounted() {
    http.get('api/v1/tenants').then(({ data: { data } }) => {
      this.data = data;
    });
  },
  data() {
    return {
      data: [],
      isCreating: false,
    };
  },
  methods: {
    handleCreated(tenant) {
      this.isCreating = false;
      window.Notify.success('Tenant was created successfully');
    },
  },
};
</script>
