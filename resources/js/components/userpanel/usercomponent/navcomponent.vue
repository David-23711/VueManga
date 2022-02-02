<template>
  <div>
    <v-app-bar app class="indigo">
      <v-btn text class="mr-2 hidden-md-and-up" @click="drawer = !drawer">
        <v-icon size="35" color="white">menu</v-icon>
      </v-btn>
      <v-toolbar-title>
        <span class="headline white--text">Manga</span>
        <span class="headline">Mize</span>
      </v-toolbar-title>
      <div
        class="ml-5 hidden-md-and-down"
        v-for="nav in navlinks"
        :key="nav.title"
      >
        <v-btn :to="nav.link" text class="white--text">{{ nav.title }}</v-btn>
      </div>
      <v-spacer></v-spacer>
      <div class="hidden-md-and-down" v-if="!userData">
        <v-btn to="/index/login">
          <span>Login</span>
          <v-icon>login</v-icon>
        </v-btn>
        <v-btn to="/index/register">
          <span>Register</span>
          <v-icon>group</v-icon>
        </v-btn>
      </div>
      <div v-if="userData">
        <v-btn @click="logout">
          <span>Logout</span>
          <v-icon>logout</v-icon>
        </v-btn>
      </div>
    </v-app-bar>
    <v-navigation-drawer
      stateless
      v-model="drawer"
      dark
      class="drawer hidden-md-and-up"
    >
      <div class="ml-2 hidden-md-and-up" v-if="!userData">
        <v-btn to="/index/login">
          <span>Login</span>
          <v-icon>login</v-icon>
        </v-btn>
        <v-btn to="/index/register">
          <span>Register</span>
          <v-icon>group</v-icon>
        </v-btn>
      </div>
      <div v-if="userData">
        <v-btn @click="logout">
          <span>Logout</span>
          <v-icon>logout</v-icon>
        </v-btn>
      </div>
      <v-list
        v-for="mnav in navlinks"
        :key="mnav.title"
        class="hidden-md-and-up"
      >
        <v-list-item>
          <v-btn :to="mnav.link" text>{{ mnav.title }}</v-btn>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      navlinks: [
        { title: "Manga Online", link: "/user" },
        { title: "Latest Manga", link: "" },
        { title: "Hot Manga", link: "" },
        { title: "Newest Manga", link: "" },
      ],
      drawer: false,
    };
  },
  computed: {
    ...mapGetters(["userData"]),
  },
  methods: {
    logout() {
      this.$store.dispatch("setUser", null);
    },
  },
};
</script>

<style lang="scss" scoped>
.center,
.tool {
  display: flex;
  justify-content: center;
  align-items: center;
}
.drawer {
  position: absolute;
  left: 0;
  top: 0;
  padding-top: 70px;
  bottom: 0;
  z-index: 1;
}
</style>