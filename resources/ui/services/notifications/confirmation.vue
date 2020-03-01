<template>
  <v-dialog
    v-model="dialog"
    :max-width="options.width"
    :style="{ zIndex: options.zIndex }"
    @keydown.esc="cancel"
  >
    <v-card tile>
      <v-card-title class="headline">{{ title }}</v-card-title>
      <v-card-text v-show="!!message" class="body-1">{{ message }}</v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="primary darken-1" text @click.native="agree">Yes</v-btn>
        <v-btn color="grey" text @click.native="cancel">Cancel</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  mounted() {
    window.Notify.confirm = (message, title = "Are you sure?", options = {}) => {
      return this.open(title, message, options);
    };
  },
  data: () => ({
    dialog: false,
    resolve: null,
    reject: null,
    message: null,
    title: null,
    options: {
      color: "",
      width: 290,
      zIndex: 200,
    },
  }),
  methods: {
    open(title, message, options) {
      this.dialog = true;
      this.title = title;
      this.message = message;
      this.options = Object.assign(this.options, options);
      return new Promise((resolve, reject = () => {}) => {
        this.resolve = resolve;
        this.reject = reject;
      });
    },
    agree() {
      this.resolve(true);
      this.dialog = false;
    },
    cancel() {
      this.dialog = false;
    },
  },
};
</script>
