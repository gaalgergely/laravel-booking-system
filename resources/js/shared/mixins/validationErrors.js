export default {
  data() {
      return {
          errors: null
      };
  },
  methods: {
      errorFor: function (field) {
          return this.errors!==null && this.errors[field] ? this.errors[field] : null;
      }
  }
};
