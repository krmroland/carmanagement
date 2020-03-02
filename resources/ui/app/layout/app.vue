<template>
  <v-app>
    <custom-notification />
    <v-navigation-drawer v-model="drawer" app dark color="primary">
      <v-toolbar color="primary" tile class="items-center justify-center" elevation="1">
        <v-toolbar-title class="text-2xl font-extrabold mt-1">
          <v-icon large>mdi-home-circle-outline</v-icon>
          <span>Rentals</span>
        </v-toolbar-title>
      </v-toolbar>

      <v-list tile class="mt-5">
        <template v-for="item in items">
          <v-list-item v-if="item.text" :key="item.text" link :to="item.path" active-class="accent">
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                {{ item.text }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app color="white" flat>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" v-if="!$vuetify.breakpoint.lgAndUp" />
      <v-spacer />
      <v-btn icon>
        <v-icon>mdi-apps</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon>mdi-bell</v-icon>
      </v-btn>
      <v-btn text large>
        <v-avatar size="32px">
          <v-img src="https://cdn.vuetifyjs.com/images/logos/logo.svg" alt="Vuetify" />
        </v-avatar>
        <span v-if="$vuetify.breakpoint.lgAndUp">
          Ahimbisibwe Roland
        </span>

        <v-icon large>
          mdi-chevron-down
        </v-icon>
      </v-btn>
      <div class="mr-4"></div>
    </v-app-bar>
    <div class="bg-gray-200 fill-height">
      <v-content>
        <v-container fluid>
          <router-view />
        </v-container>
      </v-content>
    </div>
  </v-app>
</template>

<script>
export default {
  props: {
    source: String,
  },
  data: () => ({
    dialog: false,
    drawer: null,
    items: [
      { icon: 'mdi-home-analytics', text: 'Dashboard', path: '/' },
      { icon: 'mdi-view-dashboard-outline', text: 'Products', path: '/products' },
      { icon: 'mdi-account-group-outline', text: 'Tenants', path: '/tenants' },
      { icon: 'mdi-history', text: 'Payments', path: '/payments' },
    ],
  }),
};
</script>
