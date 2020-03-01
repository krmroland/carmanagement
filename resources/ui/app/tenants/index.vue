<template>
  <div class="mt-2">
    <div class="mb-5 flex items-center">
      <v-btn depressed color="primary" large>
        New Tenant
      </v-btn>
      <v-spacer />
      <v-text-field
        hide-details
        outlined
        placeholder="Search"
        solo
        rounded
        prepend-inner-icon="mdi-magnify"
      />
      <v-spacer />
    </div>

    <v-simple-table flat>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">#</th>
            <th class="text-left">Name</th>
            <th class="text-left">Calories</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in desserts" :key="item.name" class="mb-5 ">
            <td>
              <v-avatar size="32px" item large>
                <v-img src="https://cdn.vuetifyjs.com/images/logos/logo.svg" alt="Vuetify"
              /></v-avatar>
            </td>
            <td>{{ item.name }}</td>
            <td>{{ item.calories }}</td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
  </div>
</template>
<script>
export default {
  data() {
    return {
      desserts: [
        {
          name: 'Frozen Yogurt',
          calories: 159,
        },
        {
          name: 'Ice cream sandwich',
          calories: 237,
        },
        {
          name: 'Eclair',
          calories: 262,
        },
        {
          name: 'Cupcake',
          calories: 305,
        },
        {
          name: 'Gingerbread',
          calories: 356,
        },
        {
          name: 'Jelly bean',
          calories: 375,
        },
        {
          name: 'Lollipop',
          calories: 392,
        },
        {
          name: 'Honeycomb',
          calories: 408,
        },
        {
          name: 'Donut',
          calories: 452,
        },
        {
          name: 'KitKat',
          calories: 518,
        },
      ],
    };
  },
};
</script>
