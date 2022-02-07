<template>
  <div class="frame">
    <v-container v-if="datas == 0">
      <v-row class="text-center">
        <v-col cols="12">
          <v-progress-circular
            :size="70"
            :width="7"
            color="primary"
            :indeterminate="datas == 0"
          ></v-progress-circular>
        </v-col>
      </v-row>
    </v-container>
    <v-container v-if="datas != 0">
      <v-dialog v-model="dialog" max-width="600">
        <v-card>
          <v-toolbar>
            <v-toolbar-title>
              <span class="headline">Please Login To Continue...</span>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn outlined class="red" @click="dialog = false">
              <v-icon color="white">clear</v-icon>
            </v-btn>
          </v-toolbar>
          <v-card-text class="text-center">
            <v-row class="mt-5">
              <v-col cols="6" offset="3">
                <v-btn dark outlined class="primary" to="/index/login"
                  >Login</v-btn
                >
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-dialog>
      <v-snackbar v-model="snackbar" :timeout="1000">
        {{ snackbarTitle }}
        <template v-slot:action="{ attrs }">
          <v-btn color="red" text v-bind="attrs" @click="snackbar = false">
            close
          </v-btn>
        </template>
      </v-snackbar>
      <v-toolbar class="mb-5">
        <v-toolbar-title>
          <v-btn :loading="loading" class="mr-2" @click="goBack" text>
            <v-icon>west</v-icon>
          </v-btn>
          <span>{{ datas != 0 ? datas[0]["manga_name"] : "" }}</span>
        </v-toolbar-title>
      </v-toolbar>
      <v-row v-for="data in datas" :key="data.id">
        <v-col cols="12" md="2" sm="3">
          <v-card class="backCard" align="center">
            <v-img
              height="261"
              width="150"
              :src="`/manga/${data.visual_key}`"
            ></v-img>
          </v-card>
        </v-col>
        <v-col class="mt-3" cols="12" md="10" sm="9">
          <v-card>
            <v-row>
              <v-col cols="12" md="8" sm="8">
                <div class="ml-7">
                  <span class="subtitle-1 hidden-md-and-up">{{ message }}</span>
                </div>
                <v-toolbar flat>
                  <v-rating
                    v-model="rating"
                    :length="length"
                    color="yellow accent-4"
                    hover
                    half-increments
                    half-icon="star_half"
                    full-icon="star_rate"
                    empty-icon="star_outline"
                    background-color="grey lighten-1"
                    size="30"
                    @input="userRating"
                    :readonly="userData && reRating != 0"
                  ></v-rating>
                  <h2 class="mt-3">
                    {{ rating }}
                  </h2>
                  <v-spacer></v-spacer>
                  <span class="headline hidden-md-and-down">{{ message }}</span>
                </v-toolbar>
                <table class="mytable" cell-padding="50">
                  <tr>
                    <td width="110">
                      <span class="subtitle-2">Rating</span>
                    </td>
                    <td>
                      <span class="subtitle-2">Average {{ rating }}/5</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class="subtitle-2">Alternative</span>
                    </td>
                    <td>
                      <span class="subtitle-2">{{
                        data.alternative_name
                      }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class="subtitle-2">Author</span>
                    </td>
                    <td>
                      <span class="subtitle-2">{{ data.author }},</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="subtitle-2">Genre</td>
                    <td>
                      <span
                        class="subtitle-2"
                        v-for="genre in genres"
                        :key="genre.id"
                        >{{ genre.genre }},
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class="subtitle-2">Release</span>
                    </td>
                    <td>
                      <span class="subtitle-2">{{ data.release_date }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class="subtitle-2">Status</span>
                    </td>
                    <td>
                      <span class="subtitle-2">{{ data.status }}</span>
                    </td>
                  </tr>
                </table>
              </v-col>
              <v-col cols="12" md="4" sm="4">
                <v-sheet class="text-center mt-15">
                  <v-btn text @click="bookmark(data.id)">
                    <v-icon size="50">{{
                      isBookmark ? "bookmark" : "bookmark_border"
                    }}</v-icon>
                  </v-btn>
                  <br />
                  <span>{{ isBookmark ? "UnBookmark" : "Bookmark" }}</span>
                </v-sheet>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
        <v-col cols="12" md="12" sm="12">
          <v-card>
            <v-card-title>
              <v-icon>assistant</v-icon>
              <span>Description</span>
            </v-card-title>
            <v-card-text>
              <p>{{ data.description }}</p>
            </v-card-text>
            <v-card-actions> </v-card-actions>
          </v-card>
        </v-col>
        <v-col cols="12" md="12" sm="12">
          <v-card>
            <v-card-title>
              <v-icon>pages</v-icon>
              <span class="pr-2">Latest Manga Release</span>
              <span>
                <v-btn text @click="ascend">
                  <v-icon>swap_vert</v-icon>
                  <span>{{ order ? "Asc" : "Desc" }}</span>
                </v-btn>
              </span>
            </v-card-title>
            <v-card-text ref="top">
              <v-list three-line>
                <template v-for="(episode, index) in episodes">
                  <v-divider :key="index"></v-divider>
                  <v-list-item :key="episode.episode">
                    <v-list-item-content>
                      <v-list-item-title>
                        <span
                          >{{ episode.episode_name }},
                          {{ data.manga_name }}</span
                        >
                      </v-list-item-title>
                      <v-list-item-subtitle>
                        <span>{{ ago(episode.created_at) }}</span>
                      </v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-action>
                      <v-btn
                        outlined
                        rounded
                        :to="`/user/readmanga/${$route.params.mid}/${episode.volume_id}/${episode.id}/${number}`"
                        >Read</v-btn
                      >
                    </v-list-item-action>
                  </v-list-item>
                </template>
              </v-list>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <v-btn small fixed bottom right outlined text @click="scrollTop('top')">
      <v-icon color="blue">arrow_upward</v-icon>
    </v-btn>
  </div>
</template>

<script>
import moment from "moment";
import { mapGetters } from "vuex";
import axios from "axios";
import { eventBus } from "../../app";
export default {
  data() {
    return {
      datas: [],
      imageLoading: false,
      adminName: "",
      rating: 0,
      length: 5,
      genres: [],
      isBookmark: false,
      rawepisodes: [],
      fineEpisodes: [],
      episodes: [],
      cardLoading: false,
      volumes: [],
      searchEpisode: "",
      order: false,
      dialog: false,
      reRating: [],
      message: "This is only your rating!",
      snackbar: false,
      snackbarTitle: "",
      ratingTotal: 0,
      finalRating: 0,
      narray: [],
      loading: false,
      userLength: 0,
      number: 1,
    };
  },
  methods: {
    ago(time) {
      return moment(time).fromNow();
    },
    goBack() {
      this.$router.go(-1);
    },
    scrollTop(refName) {
      var element = this.$refs[refName];
      var top = element.offsetTop;
      window.scrollTo(0, top);
    },
    async bookmark(id) {
      if (this.userData) {
        this.snackbar = true;
        this.snackbarTitle = "Bookmarked";
        this.isBookmark = !this.isBookmark;
        if (this.isBookmark == true) {
          await axios
            .post(`${this.$route.path}/bookmark`, {
              manga_information_id: id,
              user_id: this.userData.id,
            })
            .then((resp) => {
              eventBus.$emit("bookmark");
            });
        }
        //for unbookmark
        if (this.isBookmark == false) {
          let formData = new FormData();
          formData.append("_method", "DELETE");
          this.snackbar = true;
          this.snackbarTitle = "UnBookmark";
          await axios
            .post(
              `${this.$route.path}/${this.userData.id}/deleteBookmark`,
              formData
            )
            .then((resp) => {
              this.getBookmark();
              eventBus.$emit("bookmark");
            });
        }
      } else {
        this.dialog = true;
      }
    },
    async getAdmin(aid) {
      await axios.get(`/admin/manga/setting/${aid}`).then((resp) => {
        this.adminName = resp.data[0];
      });
    },
    async getAllDatas() {
      this.imageLoading = true;
      const mid = this.$route.params.mid;
      await axios
        .get(`/admin/manga/setting/data/${mid}`)
        .then((resp) => {
          this.datas = resp.data;
          this.imageLoading = false;
          let aid = resp.data[0]["admin_id"];
          this.getAdmin(aid);
        })
        .catch((error) => {
          this.imageLoading = false;
        });
    },
    async getGenres() {
      this.cardLoading = true;
      const mid = this.$route.params.mid;
      await axios.get(`/admin/manga/getGenre/${mid}`).then((resp) => {
        this.genres = resp.data;
        this.cardLoading = false;
      });
    },

    ascend() {
      this.order = !this.order;
      this.episodes.reverse();
    },
    async getVolume() {
      const mid = this.$route.params.mid;
      await axios
        .get(`/admin/manga/getVolume/${mid}`)
        .then((resp) => {
          this.volumes = resp.data;
        })
        .then((resp) => {
          for (let i = 0; i < this.volumes.length; i++) {
            let vid = this.volumes[i]["id"];
            // console.log(vid);
            axios
              .get(
                `/admin/manga/setting/episode/save/${vid}?search=${this.searchEpisode}`
              )
              .then((resp) => {
                this.rawepisodes.push(resp.data);
                this.fineEpisodes = [];
                this.episodes = [];
                for (let j = 0; j < this.rawepisodes.length; j++) {
                  this.fineEpisodes = this.rawepisodes[j];
                  for (let k = 0; k < this.fineEpisodes.length; k++) {
                    this.episodes.push(this.fineEpisodes[k]);
                  }
                }
                this.episodes.reverse();
              });
          }
        });
    },
    async userRating() {
      if (this.userData) {
        this.narray = [];
        this.loading = true;
        await axios
          .post(`${this.$route.path}/rating`, {
            user_id: this.userData.id,
            manga_information_id: this.$route.params.mid,
            rating: this.rating,
          })
          .then((resp) => {
            this.getRating();
          })
          .then((resp) => {
            this.getTotalRating();
            this.loading = false;
            this.message = "Thank You For Rating";
          })
          .catch((error) => {
            this.loading = false;
          });
      } else {
        this.rating = 0;
        this.dialog = true;
      }
    },
    async getRating() {
      if (this.userData) {
        await axios
          .get(`/getUserRating/${this.$route.params.mid}/${this.userData.id}`)
          .then((resp) => {
            this.reRating = resp.data;
            for (let i = 0; i < this.reRating.length; i++) {
              this.rating = JSON.parse(this.reRating[i].rating);
            }
          });
      }
    },
    async getBookmark() {
      if (this.userData) {
        await axios
          .get(`${this.$route.path}/${this.userData.id}/getBookmark`)
          .then((resp) => {
            console.log(resp.data);
            if (resp.data == 0) {
              this.isBookmark = false;
            } else if (resp.data > 0) {
              this.isBookmark = true;
            }
          });
      }
    },
    async getTotalRating() {
      if (this.userData) {
        await axios
          .get(`${this.$route.path}/${this.userData.id}/getRatingTotal`)
          .then((resp) => {
            let total = resp.data;
            this.userLength = resp.data.length;
            for (let i = 0; i < total.length; i++) {
              let number = Number(total[i].rating);
              this.narray.push(number);
            }
            this.ratingTotal = this.narray.reduce((sum, a) => sum + a, 0);
            let totalUser = total.length;
            let mangaRating = this.ratingTotal / totalUser;
            this.finalRating = mangaRating.toFixed(1);
          })
          .then((resp) => {
            axios
              .post(`${this.$route.path}/totalRating`, {
                rating: this.finalRating,
                users: this.userLength,
              })
              .then((resp) => {
                //dfsfsf
              });
          });
      }
    },
  },
  computed: {
    ...mapGetters(["userData"]),
  },
  mounted() {
    this.getBookmark();
    this.getRating();
    this.getAllDatas();
    this.getGenres();
    this.getVolume();
    eventBus.$emit("show");
  },
};
</script>

<style lang="scss" scoped>
.frame {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}
.backCard {
  background: url("/manga/backphoto.jpg");
  background-size: 100% 100%;
  padding-top: 20px;
  padding-bottom: 20px;
}
::v-deep .mytable {
  border-bottom: none !important;
}
.mytable tr,
td {
  padding-left: 20px;
  padding-bottom: 11.5px;
}
</style>