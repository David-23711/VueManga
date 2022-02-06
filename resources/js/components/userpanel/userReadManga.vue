<template>
  <div class="frame">
    <v-container>
      <v-row>
        <v-col cols="12" md="12" sm="12">
          <v-card dark ref="top">
            <v-toolbar>
              <v-btn @click="$router.go(-number)">
                <v-icon>arrow_back</v-icon>
              </v-btn>
              <v-spacer></v-spacer>

              <select
                v-model="byVolume"
                style="width: 100px"
                class="form-control"
                @change="volumeController()"
              >
                <option
                  v-for="volume in volumes"
                  :key="volume.id"
                  :value="volume.id"
                >
                  {{ volume.volume }}
                </option>
              </select>
              <v-spacer></v-spacer>
              <v-sheet>
                <v-btn
                  :to="`/user/readmanga/slideView/${eid}/${$route.params.mid}/${$route.params.vid}/${this.number}`"
                  >Slide View</v-btn
                >
              </v-sheet>
            </v-toolbar>
            <v-tabs
              class="primary"
              dark
              next-icon="mdi-arrow-right-bold-box-outline"
              prev-icon="mdi-arrow-left-bold-box-outline"
              show-arrows
              v-model="model"
            >
              <v-tabs-slider color="yellow"></v-tabs-slider>
              <v-tab
                v-for="i in allEpisodes"
                :key="i.id"
                :href="`#tab-${i.id}`"
                @click="getDynamicEpisode(i.id, i.volume_id)"
              >
                {{ i.episode_name }}
              </v-tab>
            </v-tabs>

            <v-card-text class="text-center">
              <span>Pages:{{ count }}</span>
              <div class="rtl">
                <v-btn
                  small
                  fixed
                  bottom
                  outlined
                  text
                  @click="scrollTop('top')"
                >
                  <v-icon color="blue">arrow_upward</v-icon>
                </v-btn>
              </div>
              <div>
                <div v-for="(img, index) in multiImages" :key="index">
                  <img
                    class="mt-3 img"
                    :src="`/manga/${$route.params.mid}/${$route.params.vid}/${eid}/${img}`"
                    alt=""
                  />
                  <v-divider></v-divider>
                </div>
              </div>
              <div v-if="loading">
                <v-progress-circular
                  :size="70"
                  :width="7"
                  color="blue"
                  :indeterminate="loading"
                ></v-progress-circular>
              </div>
            </v-card-text>
            <v-card-actions class="justify-end">
              <v-btn @click="scrollTop('top')">up</v-btn>
            </v-card-actions>
            <v-tabs
              class="primary"
              dark
              next-icon="mdi-arrow-right-bold-box-outline"
              prev-icon="mdi-arrow-left-bold-box-outline"
              show-arrows
              v-model="model"
            >
              <v-tabs-slider color="yellow"></v-tabs-slider>
              <v-tab
                v-for="i in allEpisodes"
                :key="i.id"
                :href="`#tab-${i.id}`"
                @click="getDynamicEpisode(i.id, i.volume_id)"
              >
                {{ i.episode_name }}
              </v-tab>
            </v-tabs>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import { eventBus } from "../../app";
export default {
  data() {
    return {
      allEpisodes: [],
      multiImages: [],
      eid: null,
      model: `tab-${this.$route.params.eid}`,
      count: 0,
      volumes: [],
      byVolume: "",
      byVolumeId: "",
      loading: false,
      number: JSON.parse(this.$route.params.number),
    };
  },
  methods: {
    async getEpisodeByVid() {
      let vid = this.$route.params.vid;
      await axios
        .get(`/admin/manga/volume/getEpisodeByVid/${vid}`)
        .then((resp) => {
          this.allEpisodes = resp.data;
        });
    },
    volumeController() {
      this.number = this.number + 1;
      this.$router.push(
        `/user/readmanga/${this.$route.params.mid}/${this.byVolume}/${this.$route.params.eid}/${this.number}`
      );
      this.getEpisodeByVid();
    },
    scrollTop(refName) {
      var element = this.$refs[refName];
      var top = element.offsetTop;
      window.scrollTo(0, top);
    },
    async getMultiImages() {
      let epid = this.$route.params.eid;
      this.loading = true;
      await axios
        .get(`/admin/manga/volume/multiImages/${epid}`)
        .then((resp) => {
          this.multiImages = resp.data.data;
          this.eid = JSON.parse(resp.data.id);
          this.count = resp.data.count;
          this.model = `tab-${this.eid}`;
          this.loading = false;
        });
    },
    async getDynamicEpisode(id, vid) {
      this.loading = true;
      this.number = this.number + 1;
      await axios
        .get(`/admin/manga/volume/dynamicImages/${id}`)
        .then((resp) => {
          this.multiImages = resp.data.data;
          this.eid = id;
          this.model = `tab-${this.eid}`;
          this.count = resp.data.count;
          this.loading = false;
          this.$router.push(
            `/user/readmanga/${this.$route.params.mid}/${vid}/${this.eid}/${this.number}`
          );
        });
    },
    async getVolume() {
      const id = this.$route.params.mid;
      await axios.get(`/admin/manga/getVolume/${id}`).then((resp) => {
        this.volumes = resp.data;
        let vid = this.$route.params.vid;
        let volumeData = this.volumes.filter(function (n) {
          return n.id == vid;
        });
        this.byVolume = volumeData[0].id;
      });
    },
  },
  mounted() {
    this.getEpisodeByVid();
    this.getMultiImages();
    this.getVolume();
    eventBus.$emit("hide");
  },
};
</script>

<style lang="scss" scoped>
.img {
  width: 728px;
  height: 1046px;
  cursor: pointer;
  border: 5px solid rgb(0, 0, 0);
}
.rtl {
  direction: rtl;
  margin-left: 1000px;
}
.rframe {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}
@media only screen and (max-width: 600px) {
  .img {
    max-width: 345px;
    max-height: 500px;
    cursor: pointer;
  }
  .rtl {
    direction: rtl;
    margin-left: 350px;
  }
}
@media only screen and (min-width: 750px) and (max-width: 950px) {
  .img {
    max-width: 550px;
    max-height: 700px;
    cursor: pointer;
  }
  .rtl {
    direction: rtl;
    margin-left: 750px;
  }
}
@media only screen and (min-width: 600px) and (max-width: 745px) {
  .img {
    max-width: 480px;
    max-height: 630px;
    cursor: pointer;
  }
  .rtl {
    direction: rtl;
    margin-left: 570px;
  }
}
@media only screen and (min-width: 350px) and (max-width: 380px) {
  .img {
    max-width: 300px;
    max-height: 450px;
    cursor: pointer;
  }
}
</style>