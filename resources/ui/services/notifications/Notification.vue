<template>
  <v-snackbar v-model="isShowing" v-if="isShowing" v-bind="props">
    {{ message }}

    <v-btn text @click="isShowing = false" v-if="props.close">
      Close
    </v-btn>
  </v-snackbar>
</template>
<script>
export default {
  mounted() {
    window.Notify.emitter.$on('globalNotifcations', payload => {
      const {
        message,
        type: color,
        close = false,
        top = true,
        timeout = 4000,
        ...otherProps
      } = payload;

      this.isShowing = true;
      this.message = message;
      this.props = Object.assign({}, this.props, otherProps, {
        color,
        timeout: close ? 0 : timeout,
        top,
        close,
      });
    });
  },
  data() {
    return {
      isShowing: false,
      message: null,
      props: {},
    };
  },
  methods: {},
};
</script>
