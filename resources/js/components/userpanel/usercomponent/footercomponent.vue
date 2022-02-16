<template>
  <v-row>
    <v-col cols="12" md="6">
      <ul class="footer-nav">
        <li>
          <v-btn
            class="white--text"
            plain
            to="/user"
            :class="{
              active: $route.name == 'Uindex' || $route.name == 'Index',
            }"
            text
            >Manga Online</v-btn
          >
        </li>
        <li>
          <v-btn
            class="white--text"
            plain
            to="/hotmanga"
            :class="{
              active:
                $route.name == 'hotmanga' || $route.name == 'paginateHotmanga',
            }"
            text
            >Hot Manga</v-btn
          >
        </li>
        <li>
          <v-btn
            class="white--text"
            to="/newest"
            plain
            :class="{
              active:
                $route.name == 'newestmanga' ||
                $route.name == 'paginateNewestmanga',
            }"
            text
            >Newest Manga</v-btn
          >
        </li>
      </ul>
    </v-col>
    <v-col cols="12" md="6">
      <ul class="icon-nav">
        <li><img src="/manga/vue.png" alt="vue" /></li>
        <li><img src="/manga/vuetify.png" alt="vuetify" /></li>
        <li>
          <img style="height: 70px" src="/manga/laravel.png" alt="laravel" />
        </li>
        <li><img src="/manga/mysql.png" alt="mysql" /></li>
      </ul>
    </v-col>
  </v-row>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
.footer-nav li {
  display: inline-block;
  padding: 5px;
  cursor: pointer;
  color: white;
}
.footer-nav {
  list-style: none;
  float: left;
}
.active {
  background: rgb(0, 62, 161);
  transition: background 0.3s;
  border: 1px solid blue;
  border-radius: 15px;
}
.icon-nav img {
  height: 40px;
  width: auto;
}
.icon-nav {
  list-style: none;
  float: right;
}
.icon-nav li {
  display: inline-block;
  padding: 0 20px;
}
</style>