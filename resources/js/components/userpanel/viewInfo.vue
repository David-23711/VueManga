<template>
  <div class="frame">
    <v-container>
      <v-toolbar class="mb-5">
        <v-toolbar-title>
          <v-btn class="mr-2" @click="goBack" text>
            <v-icon>west</v-icon>
          </v-btn>
          <span>{{ datas != 0 ? datas[0]["manga_name"] : "" }}</span>
        </v-toolbar-title>
      </v-toolbar>
      <v-row v-for="data in datas" :key="data.id">
        <v-col cols="12" md="2" sm="3">
          <v-card class="backCard" align="center">
            <v-img
              height="250"
              width="150"
              :src="`/manga/${data.visual_key}`"
            ></v-img>
          </v-card>
        </v-col>
        <v-col class="mt-3" cols="12" md="10" sm="9">
          <v-card>
            <v-row>
              <v-col cols="12" md="8" sm="8">
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
                  large
                ></v-rating>
                <table class="mytable" cell-padding="50">
                  <tr>
                    <td width="110">
                      <span class="subtitle-2">Rating</span>
                    </td>
                    <td><span class="subtitle-2">Average 4.5/5</span></td>
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
                  <v-btn text @click="bookmark">
                    <v-icon size="50">{{
                      isBookmark ? "bookmark" : "bookmark_border"
                    }}</v-icon>
                  </v-btn>
                  <br />
                  <span>{{ isBookmark ? "Bookmarked" : "Bookmark" }}</span>
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
                  <v-list-item :key="episode.id">
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
                      <v-btn outlined rounded>Read</v-btn>
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
    };
  },
  methods: {
    ago(time) {
      return moment(time).fromNow();
    },
    goBack() {
      this.$router.back();
    },
    scrollTop(refName) {
      var element = this.$refs[refName];
      var top = element.offsetTop;
      window.scrollTo(0, top);
    },
    async bookmark() {
      this.isBookmark = !this.isBookmark;
      if (this.isBookmark == true) {
        alert("Bookmark");
      }
      if (this.isBookmark == false) {
        alert("BookmarkDelete");
      }
    },
    async getAdmin(aid) {
      await axios.get(`/admin/manga/setting/${aid}`).then((resp) => {
        this.adminName = resp.data[0];
        console.log(this.adminName);
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
  },
  mounted() {
    this.getAllDatas();
    this.getGenres();
    this.getVolume();
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