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
.slide-up-enter {
  transform: translateY(20px);
  opacity: 0;
}
.slide-up-enter-active {
  transition: all 0.5s ease;
}
.slide-up-move {
  transition: transform 0.5s ease-in;
}
/* .slide-up-leave-to {
  transform: translateX(-10px);
  opacity: 0;
} */
</style>
