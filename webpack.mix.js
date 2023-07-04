let mix = require("laravel-mix");
let path = require("path");
require("./nova.mix");

mix
  .setPublicPath("dist")
  .js("resources/js/tool.js", "js")
  .vue({ version: 3 })
  .nova("datomatic/nova-detached-actions");

mix.alias({
  "@": path.join(__dirname, "vendor/laravel/nova/resources/js"),
  "laravel-nova": path.join(
    __dirname,
    "vendor/laravel/nova/resources/js/mixins/packages.js"
  )
});
