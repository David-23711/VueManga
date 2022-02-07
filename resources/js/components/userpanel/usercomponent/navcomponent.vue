<template>
  <div>
    <v-app-bar v-if="hide == false" :hidden="hide" app class="indigo">
      <div class="d-lg-none d-xl-flex">
        <v-btn text class="mr-2" @click="drawer = !drawer">
          <v-icon size="35" color="white">menu</v-icon>
        </v-btn>
      </div>
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
        <v-tooltip left>
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              fab
              @click="goBookmark"
              :loading="loading"
              text
              class="mr-2"
              v-on="on"
              v-bind="attrs"
            >
              <v-badge
                :content="bookmarks == 0 ? '0' : bookmarks"
                class="mr-5 mt-2"
              >
                <v-icon color="white">bookmarks</v-icon>
              </v-badge>
            </v-btn>
          </template>
          <span>Bookmarks</span>
        </v-tooltip>
        <v-dialog
          v-model="remote"
          max-width="500"
          transition="dialog-top-transition"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              :hidden="userImage != null"
              v-on="on"
              v-bind="attrs"
              class="blue"
              fab
              text
              v-if="userData"
            >
              <span>{{ twoFirst() }}</span>
            </v-btn>
            <v-avatar v-on="on" :hidden="userImage == null">
              <img
                :src="userImage != null ? `/manga/${userData.avatar}` : ''"
                alt=""
              />
            </v-avatar>
          </template>
          <template v-slot:default="dialog">
            <v-card>
              <v-toolbar flat>
                <v-spacer></v-spacer>
                <v-btn class="pink" @click="dialog.value = false">
                  <v-icon color="white">clear</v-icon>
                </v-btn>
              </v-toolbar>
              <v-card-text class="text-center">
                <v-avatar class="mt-3" size="100" :hidden="userImage == null">
                  <v-img
                    :src="userImage != null ? `/manga/${userData.avatar}` : ''"
                  ></v-img> </v-avatar
                ><br />
                <v-avatar
                  class="primary mb-2"
                  size="100"
                  :hidden="userImage != null"
                  v-if="userData"
                >
                  <span class="headline">{{ twoFirst() }}</span> </v-avatar
                ><br />
                <edit-user-component></edit-user-component>
                <div v-if="userData">
                  <span class="title"
                    >{{ userData.first_name }} {{ userData.last_name }}</span
                  ><br />
                  <span class="subtitle-2">{{ userData.email }}</span>
                </div>
              </v-card-text>
              <v-card-actions class="justify-end">
                <v-btn outlined color="red" @click="logout">Logout</v-btn>
              </v-card-actions>
            </v-card>
          </template>
        </v-dialog>
      </div>
    </v-app-bar>
    <v-navigation-drawer
      fixed
      v-model="drawer"
      dark
      class="d-lg-none d-xl-flex"
    >
      <v-row class="ma-8 justify-center">
        <v-avatar class="mt-3" size="100" :hidden="userImage == null">
          <img
            :src="
              userImage != null ? `/manga/${userData.avatar}` : ''
            " /></v-avatar
        ><br />
        <v-avatar
          v-if="userData"
          class="primary mb-2"
          size="100"
          :hidden="userImage != null"
        >
          <span class="headline">{{ twoFirst() }}</span> </v-avatar
        ><br />
        <v-col cols="12" class="text-center">
          <v-btn v-if="userData" class="primary" dark @click="remote = true"
            >Edit</v-btn
          ><br />
          <div v-if="userData">
            <span class="white--text"
              >{{ userData.first_name }} {{ userData.last_name }}</span
            >
            <span class="white--text">{{ userData.email }}</span>
          </div>
        </v-col>
      </v-row>
      <div class="ml-2" v-if="!userData">
        <v-btn to="/index/login">
          <span>Login</span>
          <v-icon>login</v-icon>
        </v-btn>
        <v-btn to="/index/register">
          <span>Register</span>
          <v-icon>group</v-icon>
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
      <div v-if="userData">
        <v-btn outlined @click="logout" color="red" class="ml-5">
          <span>Logout</span>
          <v-icon>logout</v-icon>
        </v-btn>
      </div>
    </v-navigation-drawer>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { eventBus } from "../../../app";
import editUserComponent from "./editUserComponent.vue";
export default {
  components: { editUserComponent },
  data() {
    return {
      navlinks: [
        { title: "Manga Online", link: "/user" },
        { title: "Hot Manga", link: "/hotmanga" },
        { title: "Newest Manga", link: "/newest" },
      ],
      remote: false,
      loading: false,
      drawer: false,
      bookmarks: 0,
      hide: false,
    };
  },
  computed: {
    ...mapGetters(["userData"]),
    userImage() {
      if (this.userData) {
        if (this.userData.avatar == null) {
          return null;
        } else {
          return this.userData.avatar;
        }
      }
      if (!this.userDara) {
        return null;
      }
    },
  },
  methods: {
    logout() {
      this.$store.dispatch("setUser", null);
      this.remote = false;
    },
    twoFirst() {
      let first = this.userData.first_name.substring(0, 1);
      let last = this.userData.last_name.substring(0, 1);
      return `${first + last}`;
    },
    goBookmark() {
      let path = `/bookmarks/${this.userData.id}`;
      if (this.$route.path != path) {
        this.$router.push(`/bookmarks/${this.userData.id}`);
      }
    },
    async getBookmarks() {
      this.loading = true;
      await axios
        .get(`/user/getBookmark/${this.userData.id}`)
        .then((resp) => {
          this.bookmarks = resp.data;
        })
        .then((resp) => {
          this.loading = false;
        })
        .catch((error) => {
          this.loading = false;
        });
    },
  },
  mounted() {
    if (this.userData) {
      this.getBookmarks();
    }

    eventBus.$on("bookmark", () => {
      this.getBookmarks();
    });
    eventBus.$on("hide", () => {
      this.hide = true;
    });
    eventBus.$on("show", () => {
      this.hide = false;
    });
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
  // position: absolute;
  // left: 0;
  // top: 0;
  padding-top: 70px;
  // bottom: 0;
  z-index: 1;
}
</style>