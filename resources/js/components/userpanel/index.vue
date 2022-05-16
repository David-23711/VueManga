<template>
  <div class="frame">
    <v-container v-if="datas == 0">
      <v-row class="text-center">
        <v-col cols="12">
          <v-progress-circular
            v-if="isSearch == false"
            :size="70"
            :width="7"
            color="primary"
            :indeterminate="datas == 0"
          ></v-progress-circular>
          <v-card v-if="isSearch == true">
            <h3>Result not found...</h3>
            <v-btn @click="notFound">Back</v-btn>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <v-container v-if="datas != 0">
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
              :hidden="isOnGenre == true"
              name="genre"
              v-model="byRelease"
              class="form-control mt-2"
              @change="byReleaseController"
            >
              <option value="Latest" selected>Latest</option>
              <option value="Desc" selected>Desc</option>
              <option value="Asc" selected>Asc</option>
              <option
                v-for="(manga, index) in releaseDates"
                :value="manga"
                :key="index"
              >
                {{ manga }}
              </option>
            </select>
          </v-col>
          <v-col cols="2" md="5" sm="4"> </v-col>
          <v-col cols="6" md="4" sm="4">
            <v-text-field
              class="mt-2"
              placeholder="Search with captial letter at start"
              prepend-icon="search"
              v-model="searchName"
              clearable
              @keyup.enter="getAllDatas()"
            >
            </v-text-field>
          </v-col>
        </v-row>
      </v-toolbar>

      <transition-group tag="div" name="slide-up" class="row" appear>
        <v-col cols="12" sm="6" md="4" v-for="data in datas" :key="data.id">
          <v-card>
            <v-card-text>
              <v-row>
                <v-col cols="5" md="5" sm="5" class="img-container">
                  <v-img
                    class="img"
                    :src="`/manga/${data.visual_key}`"
                    :alt="data.visual_key"
                  ></v-img>
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
              <v-col cols="5" sm="10" md="10" class="rate">
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
              <v-col cols="2" sm="2" md="2"> </v-col>
              <v-col cols="5" sm="10" md="10" class="rateFont">
                <span class="subtitle-2"
                  >{{ data.rating }} Rating ({{
                    data.users ? data.user : 0
                  }})</span
                >
              </v-col>
            </v-row>
            <v-toolbar>
              <v-row>
                <v-btn text :to="`/index/viewinfo/${data.id}`">
                  <span>Read</span>
                </v-btn>
              </v-row>
            </v-toolbar>
          </v-card>
        </v-col>
      </transition-group>

      <v-toolbar class="mt-3">
        <v-row>
          <div v-if="isOnDate == false">
            <v-pagination
              :hidden="isOnGenre == true"
              v-model="pagination.current"
              :length="pagination.total"
              @input="onPageChange(pagination.current, pagination.total)"
              prev-icon="mdi-menu-left"
              next-icon="mdi-menu-right"
            ></v-pagination>
            <v-pagination
              :hidden="isOnGenre == false"
              v-model="paginationGenre.current"
              :length="paginationGenre.total"
              @input="
                onChangeGenre(paginationGenre.current, paginationGenre.total)
              "
              prev-icon="mdi-menu-left"
              next-icon="mdi-menu-right"
            ></v-pagination>
          </div>
          <v-pagination
            :hidden="isOnDate == false"
            v-model="paginationDate.current"
            :length="paginationDate.total"
            @input="onChangeDate(paginationDate.current, paginationDate.total)"
            prev-icon="mdi-menu-left"
            next-icon="mdi-menu-right"
          ></v-pagination>
        </v-row>
      </v-toolbar>
    </v-container>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      datas: [],
      datasGenre: [],
      length: 5,
      rating: 0,
      searchName: "",
      total: 0,
      releaseDates: [],
      searchName: "",
      path: this.$route.path,
      isOnGenre: false,
      isOnDate: false,
      isSearch: false,
      datagenre: this.$route.params.category,
      tab: this.$route.params.category
        ? `tab-${this.$route.params.category}`
        : "",
      genres: [],
      pagination: {
        current: this.$route.params.current
          ? JSON.parse(this.$route.params.current)
          : 1,
        total: this.$route.params.total
          ? JSON.parse(this.$route.params.total)
          : 0,
      },
      paginationDate: {
        current: this.$route.params.current
          ? JSON.parse(this.$route.params.current)
          : 1,
        total: this.$route.params.total
          ? JSON.parse(this.$route.params.total)
          : 0,
      },
      paginationGenre: {
        current: this.$route.params.current
          ? JSON.parse(this.$route.params.current)
          : 1,
        total: this.$route.params.total
          ? JSON.parse(this.$route.params.total)
          : 0,
      },
      byRelease: this.$route.params.date,
    };
  },
  methods: {
    notFound() {
      this.searchName = "";
      this.isSearch = false;
      this.getAllDatas();
    },
    async getAllDatas() {
      await axios
        .get(
          `/admin/manga/post?search=${this.searchName} && page=${this.$route.params.pageCurrent}`
        )
        .then((resp) => {
          this.datas = resp.data.data;
          // console.log("getAllDatas");
          this.byRelease = "Latest";
          this.isOnDate = false;
          this.pagination.current = resp.data.current_page;
          this.pagination.total = resp.data.last_page;
          if (this.searchName != "") {
            this.isSearch = true;
          } else {
            this.isSearch = false;
          }
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
      this.isSearch = false;
      await axios
        .get(`/admin/category/byGenre?genre=${this.datagenre}`)
        .then((resp) => {
          // console.log("getDataByGenre");
          let array = resp.data;
          this.datasGenre = [];
          for (let i = 0; i < array.length; i++) {
            let data = array[i];

            for (let j = 0; j < data.length; j++) {
              this.datasGenre.push(data[j]);
            }
          }

          if (this.$route.params.category == "Latest") {
            this.isOnGenre = false;
          } else {
            this.isOnGenre = true;
          }
          this.byRelease = "Desc";
          const numberOfItems = this.datasGenre.length;
          const numberPerPage = 6;
          const currentPage = this.paginationGenre.current;
          let numberOfPages = 0;
          numberOfPages = Math.ceil(numberOfItems / numberPerPage);
          const trimStart = (currentPage - 1) * numberPerPage;
          const trimEnd = trimStart + numberPerPage;
          // console.log(this.datasGenre.slice(trimStart, trimEnd));
          this.paginationGenre.current = currentPage;
          this.paginationGenre.total = numberOfPages;
          this.datas = this.datasGenre.slice(trimStart, trimEnd);
        });
    },
    onChangeGenre(current, total) {
      let path = `/user/${this.$route.params.category}/${current}/${total}`;
      if (this.$route.path != path) {
        this.$router.push(path);
      }
      this.getDataByGenre();
    },
    onChangeDate(current, total) {
      let path = `/user/data/${this.$route.params.date}/${current}/${total}`;
      if (this.$route.path != path) {
        this.$router.push(path);
      }
      this.getByRelease();
    },
    goGenre(cat) {
      if (this.$route.path != `/user/${cat}`) {
        this.$router.push(`/user/${cat}`);
        this.paginationGenre.current = 1;
      }
      this.datagenre = this.$route.params.category;
      this.isOnDate = false;
      this.datas = [];

      if (this.$route.params.category == "Latest") {
        this.isOnGenre = false;
        this.getAllDatas();
      } else {
        this.getDataByGenre();
      }
    },
    async getReleaseDates() {
      await axios.get("/admin/manga/post/releaseDate").then((resp) => {
        this.releaseDates = new Set(resp.data);
      });
    },
    async getByRelease() {
      await axios
        .get(
          `/admin/manga/post/byrelease?release=${this.byRelease}&& page=${this.paginationDate.current}`
        )
        .then((resp) => {
          this.isOnGenre = false;
          this.isOnDate = true;
          this.datas = resp.data.data;
          this.paginationDate.current = resp.data.current_page;
          this.paginationDate.total = resp.data.last_page;
        });
    },
    async byReleaseController() {
      this.$router.push(`/user/data/${this.byRelease}`);
      this.getByRelease();
    },
    onPageChange(current, total) {
      let path = `/user/pagination/${current}/${total}`;
      if (this.$route.path != path) {
        this.$router.push(path);
      }
      this.getAllDatas();
    },
  },
  mounted() {
    this.getAllGenres();
    this.getReleaseDates();
    if (this.$route.params.category == "Latest") {
      this.getAllDatas();
    }
    if (
      this.$route.params.category != "Latest" &&
      this.$route.params.category
    ) {
      this.getDataByGenre();
    }
    if (this.$route.params.date) {
      this.getByRelease();
    }
    // if (this.reload == true) {
    //   this.getAllDatas();
    // }
    if (Object.keys(this.$route.params).length === 0) {
      // this.isOnGenre=false;
      this.getAllDatas();
    }
    if (this.$route.params.pageCurrent && this.$route.params.pageTotal) {
      this.getAllDatas();
    }
  },
};
</script>

<style>
.frame {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}
.img-container {
  width: 100%;
  height: auto;
  padding: 0;
}
.img {
  border: 2px solid black;
  border-radius: 6px;
  width: 100%;
  height: 90%;
}
.rate {
  padding-bottom: 0;
}
.rateFont {
  padding: 0 0 25px 25px;
}
@media (min-width: 960px) and (max-width: 1266px) {
  .container {
    max-width: 1140px;
  }
  .img-container {
    height: 220px;
    width: auto;
  }
  .subFont {
    font-size: 15px;
  }
  .font {
    font-size: 17px;
  }
}
@media (min-width: 600px) and (max-width: 960px) {
  .container {
    max-width: 900px;
  }
  .img-container {
    height: 250px;
    width: 200px;
  }
  .subFont {
    font-size: 17px;
  }
  .font {
    font-size: 18px;
  }
  .rate {
    padding-bottom: 0;
  }
  .rateFont {
    padding: 0 0 25px 25px;
  }
}
@media (max-width: 599px) {
  .rate {
    padding-bottom: 25px;
  }
  .rateFont {
    padding: 0 0 20px 0;
    margin-top: 17px;
  }
}
</style>
