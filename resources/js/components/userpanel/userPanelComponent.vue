<template>
  <div>
    <v-app>
      <navcomponent></navcomponent>
      <v-main>
        <router-view></router-view>
      </v-main>
      <v-footer color="secondary" class="mt-5" :hidden="hide">
        <footercomponent></footercomponent>
      </v-footer>
    </v-app>
  </div>
</template>

<script>
import Footercomponent from "./usercomponent/footercomponent.vue";
import navcomponent from "./usercomponent/navcomponent.vue";
import { eventBus } from "./../../app";
export default {
  components: { navcomponent, Footercomponent },
  data() {
    return {
      hide: false,
    };
  },
  created() {
    eventBus.$on("hide", () => {
      this.hide = true;
    });
    eventBus.$on("show", () => {
      this.hide = false;
    });
  },
};
</script>

<style>
</style>
