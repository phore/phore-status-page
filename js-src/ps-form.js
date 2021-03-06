

Vue.component('ps-form', {

  data: function () {
    return {
      form: {
        form_a: "abcdef"
      }
    }
  },

  mounted: function () {
      console.log("data", this.$data);
      console.log("default", this);
      console.log("slot", this.$scopedSlots.default);

      //this.$scopedSlots.default.$data = this.$data;

  },

  methods: {
    on_submit: function($event, $data) {
      $event.preventDefault();
      console.log(JSON.stringify(this.$parent.$data));
      return false;
    },
  },


  template: "<form v-on:submit='on_submit'>{{ form }}<slot v-bind='form'></slot></form>"
});
