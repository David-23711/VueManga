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
      <v-toolbar class="mb-4">
        <v-spacer></v-spacer>
        <span class="headline">Newest Manga</span>
        <v-spacer></v-spacer>
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
                            class="font"
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
                            class="font"
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
                          <span class="font">{{ data.release_date }}</span>
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
      <v-toolbar class="mt-3">
        <v-spacer></v-spacer>
        <v-pagination
          v-model="pagination.current"
          :length="pagination.total"
          prev-icon="mdi-menu-left"
          next-icon="mdi-menu-right"
          @input="onchangePage(pagination.current, pagination.total)"
        ></v-pagination>
        <v-spacer></v-spacer>
      </v-toolbar>
    </v-container>
  </div>
</template>

<script>
export default {
  data() {
    return {
      datas: [],
      length: 5,
      value: 0,
      pagination: {
        current: this.$route.params.current
          ? JSON.parse(this.$route.params.current)
          : 1,
        total: this.$route.params.total
          ? JSON.parse(this.$route.params.total)
          : 0,
      },
    };
  },
  methods: {
    async getDatas() {
      await axios
        .get(`/newest/getNewestManga?page=${this.pagination.current}`)
        .then((resp) => {
          this.datas = resp.data.data;
          this.pagination.current = resp.data.current_page;
          this.pagination.total = resp.data.last_page;
        });
    },
    onchangePage(current, total) {
      this.$router.push(`/newest/pagination/${current}/${total}`);
      this.getDatas();
    },
  },
  mounted() {
    this.getDatas();
  },
};
</script>

<style>
</style>