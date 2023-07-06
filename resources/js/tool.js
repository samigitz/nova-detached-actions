Nova.booting((app, store) => {
  app.component("ActionButton", require("./components/ActionButton.vue").default);
  app.component("ActionButtons", require("./components/ActionButtons.vue").default);
  app.component("IndexActions", require("./components/IndexActions.vue").default);
  app.component("ResourceTableToolbar", require("./nova-components/ResourceTableToolbar.vue").default);
});
