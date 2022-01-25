<template>
  <div class="eframe">
    <v-container v-if="allData == 0">
      <v-row class="text-center">
        <v-col cols="12" md="6" offset-md="3">
          <v-card>
            <v-card-text>
              <h4>Loading Wait</h4>
              <br />
              <div class="spinner-grow text-primary" role="status">
                <span class="sr-only">Loading...</span>
              </div>
              <div class="spinner-grow text-secondary" role="status">
                <span class="sr-only">Loading...</span>
              </div>
              <div class="spinner-grow text-success" role="status">
                <span class="sr-only">Loading...</span>
              </div>
              <div class="spinner-grow text-danger" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <v-container v-if="allData != 0">
      <v-row>
        <v-col cols="12" md="8" offset-md="2" sm="10" offset-sm="1">
          <v-card v-for="manga in allData" :key="manga.id">
            <v-toolbar flat dark class="cyan" floating>
              <v-btn class="cyan" text @click="$router.go(-1)">
                <v-icon>arrow_back</v-icon>
              </v-btn>
            </v-toolbar>
            <v-card-title>
              <v-row>
                <v-col md="4" cols="12" sm="5" class="text-center">
                  <img
                    :src="`/manga/${manga.visual_key}`"
                    class="img"
                    v-if="imageLoading == false"
                  />
                  <v-skeleton-loader type="image" v-if="imageLoading == true">
                  </v-skeleton-loader>
                </v-col>
                <v-col md="8" cols="12" sm="7">
                  <v-simple-table>
                    <tbody>
                      <tr>
                        <td>Name:</td>
                        <td>{{ manga.manga_name }}</td>
                      </tr>
                      <tr>
                        <td>Alternative:</td>
                        <td>{{ manga.alternative_name }}</td>
                      </tr>
                      <tr>
                        <td>Author:</td>
                        <td>{{ manga.author }}</td>
                      </tr>
                      <tr>
                        <td>Status:</td>
                        <td>{{ manga.status }}</td>
                      </tr>
                      <tr>
                        <td width="150px">Release Date:</td>
                        <td>{{ manga.release_date }}</td>
                      </tr>
                      <tr>
                        <td>Volume:</td>
                        <td>{{ volume.volume }}</td>
                      </tr>
                    </tbody>
                  </v-simple-table>
                </v-col>
              </v-row>
            </v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="12">
                  <v-toolbar flat>
                    <add-episode-component></add-episode-component>
                    <v-spacer></v-spacer>
                    <v-text-field
                      placeholder="search episode"
                      prepend-icon="search"
                      clearable
                      v-model="searchEpisode"
                      @keyup.enter="getEpisode()"
                    >
                    </v-text-field>
                  </v-toolbar>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12">
                  <v-list height="200" v-if="episodes != 0">
                    <v-list-item v-for="episode in episodes" :key="episode.id">
                      <v-list-item-icon>
                        <v-icon>label</v-icon>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>
                          <span>{{ episode.episode_name }}</span>
                        </v-list-item-title>
                      </v-list-item-content>

                      <v-list-item-action>
                        <v-menu :close-on-click="true" top>
                          <template v-slot:activator="{ on, attrs }">
                            <v-btn text v-on="on" v-bind="attrs">
                              <v-icon>settings</v-icon>
                            </v-btn>
                          </template>
                          <v-list max-width="200">
                            <v-list-item>
                              <v-list-item-content>
                                <v-list-item>
                                  {{ episode.episode_name }}
                                </v-list-item>
                                <v-list-item-title>
                                  <edit-episode-component
                                    :id="episode.id"
                                    :episode="episode.episode_name"
                                  ></edit-episode-component>
                                </v-list-item-title>
                                <v-list-item-title>
                                  <v-btn text @click="deleteEpisode(episode.id)"
                                    >Delete</v-btn
                                  >
                                </v-list-item-title>
                                <v-list-item-title>
                                  <v-btn
                                    :to="`/admin/manga/volume/episodes/insertImage/${episode.id}/${manga.id}/${volume.id}`"
                                    text
                                    >Insert</v-btn
                                  >
                                </v-list-item-title>
                                <v-list-item-title>
                                  <v-btn text :to="`/admin/manga/volume/images/${episode.id}/${volume.id}`">Read</v-btn>
                                </v-list-item-title>
                              </v-list-item-content>
                            </v-list-item>
                          </v-list>
                        </v-menu>
                      </v-list-item-action>
                    </v-list-item>
                  </v-list>
                  <v-list v-if="episodes == 0">
                    <v-list-item>
                      <v-list-item-content>
                        <v-list-item-title>
                          <span v-if="eloading == false">Result not found</span>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list>
                  <v-list v-if="eloading">
                    <v-list-item>
                      <v-list-item-content>
                        <v-list-item-title>
                          <v-progress-linear
                            indeterminate
                            color="yellow darken-2"
                          ></v-progress-linear>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import axios from "axios";
import addEpisodeComponent from "./admincomponents/addEpisodeComponent.vue";
import { eventBus } from "../../app";
import EditEpisodeComponent from "./admincomponents/editEpisodeComponent.vue";
export default {
  components: { addEpisodeComponent, EditEpisodeComponent },
  data() {
    return {
      allData: [],
      volume: [],
      imageLoading: false,
      episodes: [],
      searchEpisode: "",
      eloading: false,
    };
  },
  methods: {
    async getAllData() {
      this.imageLoading = true;
      const mid = this.$route.params.mid;
      await axios.get(`/admin/getalldata/${mid}`).then((resp) => {
        this.allData = resp.data;
        this.imageLoading = false;
      });
    },
    async getVolume() {
      const id = this.$route.params.id;
      await axios.get(`/admin/getVolume/${id}`).then((resp) => {
        this.volume=resp.data[0];
      });
    },
    async getEpisode() {
      const id = this.$route.params.id;
      this.eloading = true;
      await axios
        .get(
          `/admin/manga/setting/episode/save/${id}?search=${this.searchEpisode}`
        )
        .then((resp) => {
          this.eloading = false;
          this.episodes = resp.data;
        });
    },
    async deleteEpisode(id) {
      var formData = new FormData();
      formData.append("_method", "DELETE");
      await axios
        .post(`/admin/manga/setting/episode/save/${id}`, formData)
        .then((resp) => {
          this.getEpisode();
        });
    },
  },
  mounted() {
    this.getAllData();
    this.getVolume();
    this.getEpisode();
    eventBus.$on("addEpisode", () => {
      this.getEpisode();
    });
    eventBus.$on("updateEpisode", () => {
      this.getEpisode();
    });
  },
};
</script>

<style lang="scss" scoped>
.v-list {
  max-height: 300px;
  overflow-y: auto;
}
.eframe {
  width: 100%;
  height: 100%;
  justify-content: center;
  align-items: center;
  display: flex;
}
.img {
  width: 200px;
  height: 300px !important;
  margin-right: 50px;
  border: 1px solid cyan;
}
::v-deep .v-skeleton-loader.v-skeleton-loader--is-loading {
  .v-skeleton-loader__image {
    height: 300px;
  }
  @media only screen and(max-width: 600px) {
    .v-skeleton-loader__image {
      width: 335px;
      height: 435px;
      border: 1px solid cyan;
      margin-right: 0px;
    }
  }
}
@media only screen and(max-width: 600px) {
  .img {
    border: 1px solid cyan;
    width: 335px;
    height: 435px !important;
    margin-right: 0px;
  }
  .v-application .text-center {
    text-align: center !important;
  }
}
</style>