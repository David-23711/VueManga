<template>
  <div>
    <v-container>
      <v-tabs v-model="tab" class="mb-5" show-arrows>
        <v-tabs-slider color="primary"></v-tabs-slider>
        <!-- <v-tab :href="`#tab-${datagenre}`">Latest</v-tab> -->
        <v-tab
          @click="goGenre(genre.category)"
          v-for="genre in genres"
          :key="genre.id"
          :href="`#tab-${genre.category}`"
        >
          {{ genre.category }}
        </v-tab>
      </v-tabs>
      <v-toolbar class="mb-4">
        <v-row class="justify-end">
          <v-col cols="4" md="3" sm="4">
            <select
              name="genre"
              v-model="byRelease"
              class="form-control mt-2"
              @change="getByRelease"
            >
              <option value="Desc" selected>Descend</option>
              <option value="Asc" selected>Ascend</option>
              <option
                v-for="(manga, index) in releaseDates"
                :value="manga"
                :key="index"
              >
                {{ manga }}
              </option>
            </select>
          </v-col>
          <v-col cols="2" md="3" sm="2"> </v-col>
          <v-col cols="6" md="6" sm="6">
            <v-text-field
              class="mt-2"
              placeholder="Search Manga"
              prepend-icon="search"
              v-model="searchName"
              clearable
              @keyup.enter="getAllDatas()"
            >
            </v-text-field>
          </v-col>
        </v-row>
      </v-toolbar>
      <v-row>
        <v-col cols="12" sm="6" md="4" v-for="data in datas" :key="data.id">
          <v-card>
            <v-card-text>
              <v-row>
                <v-col cols="5" md="5" sm="5">
                  <img class="img" :src="`/manga/${data.visual_key}`" alt="" />
                </v-col>
                <v-col cols="7" md="7" sm="7">
                  <v-list>
                    <v-list-item>
                      <v-list-item-content>
                        <v-list-item-subtitle>
                          <span>Manga Name</span>
                        </v-list-item-subtitle>
                        <v-list-item-title>
                          <span
                            style="cursor: pointer"
                            :title="data.manga_name"
                            class="font"
                            >{{ data.manga_name }}</span
                          >
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-content>
                        <v-list-item-subtitle>
                          <span>Alternative Name</span>
                        </v-list-item-subtitle>
                        <v-list-item-title>
                          <span
                            style="cursor: pointer"
                            :title="data.alternative_name"
                            class="font"
                            >{{ data.alternative_name }}</span
                          >
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-content>
                        <v-list-item-subtitle>
                          <span>Release Date</span>
                        </v-list-item-subtitle>
                        <v-list-item-title>
                          <span class="font">{{ data.release_date }}</span>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-actions>
              <v-rating
                v-model="rating"
                :length="length"
                color="red lighten-3"
                background-color="grey lighten-1"
              ></v-rating>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      datas: [],
      length: 5,
      rating: 0,
      searchName: "",
      releaseDates: [],
      searchName: "",
      datagenre: this.$route.params.category,
      tab: this.$route.params.category
        ? `tab-${this.$route.params.category}`
        : "",
      genres: [],
      pagination: {
        current: 1,
        total: 0,
      },
      byRelease: this.$route.params.date,
    };
  },
  methods: {
    async getAllDatas() {
      await axios
        .get(
          `/admin/manga/post?search=${this.searchName} && page=${this.pagination.current}`
        )
        .then((resp) => {
          this.datas = resp.data.data;
        });
    },
    async getAllGenres() {
      await axios.get(`/admin/category/post`).then((resp) => {
        let array = resp.data;
        let object = { category: "Latest" };
        array.unshift(object);
        this.genres = array;
      });
    },
    async getDataByGenre() {
      this.datas = [];
      await axios
        .get(`/admin/category/byGenre?genre=${this.datagenre}`)
        .then((resp) => {
          let array = resp.data;
          for (let i = 0; i < array.length; i++) {
            let data = array[i];
            for (let j = 0; j < data.length; j++) {
              this.datas.push(data[j]);
            }
          }
          this.byRelease = "Desc";
        });
    },
    goGenre(cat) {
      this.$router.push(`/user/${cat}`);
      this.datagenre = this.$route.params.category;
      this.datas = [];
      this.getDataByGenre();
      if (this.$route.params.category == "Latest") {
        this.getAllDatas();
      }
    },
    async getReleaseDates() {
      await axios.get("/admin/manga/post/releaseDate").then((resp) => {
        this.releaseDates = resp.data;
      });
    },
    async getByRelease() {
      await axios
        .get(`/admin/manga/post/byrelease?release=${this.byRelease}`)
        .then((resp) => {
          this.$router.push(`/user/data/${this.byRelease}`).catch(() => {});
          this.datas = resp.data.data;
        });
    },
  },
  mounted() {
    this.getAllGenres();
    if (this.$route.params.category == "Latest") {
      this.getAllDatas();
    }
    if (this.$route.params.category) {
      this.getDataByGenre();
    } else if (this.$route.params.date) {
      this.getByRelease();
    } else {
      this.getAllDatas();
    }
    this.getReleaseDates();
  },
};
</script>

<style lang="scss" scoped>
.img {
  border: 2px solid black;
  border-radius: 6px;
  width: 130px;
  height: 180px;
}
</style>