<template>
  <div class="wframe">
    <div class="rtl">
      <v-btn style="z-index: 5" fixed top outlined @click="goAndShow">
        <v-icon color="blue">arrow_left</v-icon>
      </v-btn>
    </div>
    <v-carousel hide-delimiters height="700" v-model="pages">
      <v-carousel-item class="text-center" v-for="(item, i) in items" :key="i">
        <v-row align="center" justify="center">
          <v-sheet width="500" height="680" dark>
            <img
              class="img"
              :src="`/manga/${$route.params.mid}/${$route.params.vid}/${$route.params.eid}/${item}`"
              alt=""
            />
          </v-sheet>
        </v-row>
        <div class="mt-2">
          <span>{{ pages }}</span>
        </div>
      </v-carousel-item>
    </v-carousel>
  </div>
</template>

<script>
import { eventBus } from "../../app";
export default {
  data() {
    return {
      items: [],
      pages: 0,
    };
  },
  methods: {
    async getMultiImages() {
      let eid = this.$route.params.eid;
      await axios.get(`/admin/manga/volume/multiImages/${eid}`).then((resp) => {
        this.items = resp.data.data;
      });
    },
    goAndShow() {
      this.$router.back();
    },
  },
  mounted() {
    this.getMultiImages();
    eventBus.$emit("hide");
  },
};
</script>

<style lang="scss" scoped>
.wframe {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.img {
  width: auto;
  height: 680px;
  border: 5px solid rgb(0, 0, 0);
}
.rtl {
  margin-left: 10px;
}
@media only screen and (max-width: 600px) {
  .img {
    width: 400px;
    height: 680px;
  }
}
</style>