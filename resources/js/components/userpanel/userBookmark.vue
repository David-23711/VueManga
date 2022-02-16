<template>
  <div class="frame">
    <v-container v-if="loading == true">
      <v-row class="text-center">
        <v-col cols="12">
          <v-progress-circular
            :size="70"
            :width="7"
            color="primary"
            :indeterminate="loading == true"
          ></v-progress-circular>
        </v-col>
      </v-row>
    </v-container>
    <v-container v-if="datas == 0">
      <v-row class="text-center">
        <v-col cols="12">
          <v-card flat>
            <h3>Bookmark is empty</h3>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <v-container v-if="loading == false && datas != 0">
      <v-toolbar class="mb-4">
        <v-toolbar-title>
          <v-btn class="mr-2" @click="goBack" text>
            <v-icon>west</v-icon>
          </v-btn>
          <span>Bookmarks</span>
        </v-toolbar-title>
      </v-toolbar>
      <v-row>
        <v-col cols="12" sm="6" md="4" v-for="data in datas" :key="data.id">
          <v-card>
            <v-card-text>
              <v-row>
                <v-col class="img-container" cols="5" md="5" sm="5">
                  <img class="img" :src="`/manga/${data.visual_key}`" alt="" />
                </v-col>
                <v-col cols="7" md="7" sm="7">
                  <v-list>
                    <v-list-item>
                      <v-list-item-content>
                        <v-list-item-subtitle class="subFont">
                          <span>Manga Name</span>
                        </v-list-item-subtitle>
                        <v-list-item-title class="font">
                          <span
                            style="cursor: pointer"
                            :title="data.manga_name"
                            >{{ data.manga_name }}</span
                          >
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-content>
                        <v-list-item-subtitle class="subFont">
                          <span>Alternative Name</span>
                        </v-list-item-subtitle>
                        <v-list-item-title class="font">
                          <span
                            style="cursor: pointer"
                            :title="data.alternative_name"
                            >{{ data.alternative_name }}</span
                          >
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-content>
                        <v-list-item-subtitle class="subFont">
                          <span>Release Date</span>
                        </v-list-item-subtitle>
                        <v-list-item-title class="font">
                          <span>{{ data.release_date }}</span>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list>
                </v-col>
              </v-row>
            </v-card-text>
            <v-row>
              <v-col cols="6" sm="12" md="12" class="rate">
                <v-rating
                  :value="JSON.parse(data.rating)"
                  :length="length"
                  color="yellow accent-4"
                  background-color="grey lighten-1"
                  size="20"
                  readonly
                  half-increments
                  half-icon="star_half"
                  full-icon="star_rate"
                  empty-icon="star_outline"
                ></v-rating>
              </v-col>
              <v-col cols="6" sm="12" md="12" class="rateFont">
                <span class="subtitle-2"
                  >{{ data.rating }} Rating ({{ data.users }})</span
                >
              </v-col>
            </v-row>
            <v-card-actions>
              <span>Bookmark at {{ ago(data.bcreated) }}</span>
            </v-card-actions>
            <v-toolbar>
              <v-row>
                <v-btn text :to="`/index/viewinfo/${data.id}`">
                  <span>Read</span>
                </v-btn>
              </v-row>
            </v-toolbar>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import moment from "moment";
export default {
  data() {
    return {
      datas: null,
      length: 5,
      value: 0,
      loading: false,
      empty: false,
    };
  },
  methods: {
    ago(time) {
      return moment.utc(time).fromNow();
    },
    goBack() {
      this.$router.back();
    },
    async getUserBookmarks() {
      this.loading = true;
      let path = this.$route.path;
      await axios.get(`${path}/getUserBookmark`).then((resp) => {
        this.datas = resp.data;
        this.loading = false;
      });
    },
  },
  mounted() {
    this.getUserBookmarks();
  },
};
</script>

<style>
</style>