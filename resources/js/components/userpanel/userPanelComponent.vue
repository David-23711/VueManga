<template>
  <div>
      <v-app>
        <navcomponent></navcomponent>
        <v-main>
           <router-view></router-view>
        </v-main>
        <v-footer>

        </v-footer>
      </v-app>
  </div>
</template>

<script>
import navcomponent from './usercomponent/navcomponent.vue'
export default {
  components: { navcomponent },

}
</script>

<style>

</style>