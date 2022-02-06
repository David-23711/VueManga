<template>
  <div class="dframe">
    <v-container v-if="!adminData">
      <v-row>
        <v-col cols="12" md="6" offset-md="3">
          <v-card>
            <v-card-text class="text-center">
              <h4>Please Login To Continue...</h4>
              <br />
              <v-btn dark to="/admin/login">
                <span>Login</span>
                <v-icon>login</v-icon>
              </v-btn>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <v-container v-if="adminData">
      <v-row>
        <v-col cols="12" md="6" sm="6">
          <v-row>
            <v-col cols="12" md="6" sm="12">
              <v-card to="/admin/manga" justify-center>
                <v-card-text>
                  <v-btn text>
                    <span class="mr-3">Total Project</span>
                    <v-chip>{{ this.project }}</v-chip>
                  </v-btn>
                </v-card-text>
              </v-card>
            </v-col>
            <v-col cols="12" md="6" sm="12">
              <v-card to="#1">
                <v-card-text>
                  <v-btn text to="/admin/category">
                    <span class="mr-3">Total Category</span>
                    <v-chip>{{ this.category }}</v-chip>
                  </v-btn>
                </v-card-text>
              </v-card>
            </v-col>
            <v-col cols="12" md="12" sm="12">
              <v-card>
                <v-card-text>
                  <h1>Hello World</h1>
                </v-card-text>
              </v-card>
            </v-col>
            <v-col cols="12" md="6" sm="12">
              <v-card to="#" justify-center>
                <v-card-text>
                  <h4>Hello World</h4>
                </v-card-text>
              </v-card>
            </v-col>
            <v-col cols="12" md="6" sm="12">
              <v-card>
                <v-card-text>
                  <h4>Hello World</h4>
                </v-card-text>
              </v-card>
            </v-col>
            <v-col cols="12" md="12" sm="12">
              <v-carousel v-model="model" height="160">
                <v-carousel-item
                  v-for="(color, i) in colors"
                  :key="color"
                  round
                >
                  <v-sheet :color="color" height="100%" tile elevation="12">
                    <v-row
                      class="fill-height text-center"
                      align="center"
                      justify="center"
                    >
                      <div class="text-h2">Slide {{ i + 1 }}</div>
                    </v-row>
                  </v-sheet>
                </v-carousel-item>
              </v-carousel>
            </v-col>
          </v-row>
        </v-col>
        <v-col cols="12" md="6" sm="12">
          <v-card height="450">
            <v-card-text>
              <div class="cframe" v-if="hide == false">
                <v-progress-circular
                  :hidden="hide"
                  indeterminate
                  color="primary"
                ></v-progress-circular>
              </div>
              <div class="outer-border">
                <div class="inner-border">
                  <v-list :hidden="hide == false" class="content">
                    <v-list-item v-for="item in allProject" :key="item.id">
                      <v-list-item-icon>
                        <span class="green--text">Latest</span>
                      </v-list-item-icon>
                      <v-list-item-content>
                        <v-list-item-title>
                          <span>{{ item.manga_name }}</span>
                        </v-list-item-title>
                        <v-list-item-subtitle>
                          <span>{{ item.alternative_name }}</span>
                        </v-list-item-subtitle>
                      </v-list-item-content>
                      <v-list-item-action>
                        <v-btn
                          :to="`/admin/manga/setting/${item.id}/admin/${adminData.id}`"
                        >
                          <v-icon>input</v-icon>
                        </v-btn>
                      </v-list-item-action>
                    </v-list-item>
                  </v-list>
                </div>
              </div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      model: 0,
      colors: ["red", "green", "blue", "pink", "yellow", "black"],
      project: 0,
      category: 0,
      allProject: {},
      hide: true,
    };
  },
  computed: {
    ...mapGetters(["adminData"]),
  },
  methods: {
    async getTotalProject() {
      await axios.get("/admin/home/dashboard/projectcount").then((resp) => {
        this.project = resp.data;
      });
    },
    async getTotalCategory() {
      await axios.get("/admin/home/dashboard/categorycount").then((resp) => {
        this.category = resp.data;
      });
    },
    async getAllProject() {
      this.hide = false;
      await axios
        .get(`/admin/manga/dashboard`)
        .then((resp) => {
          this.allProject = resp.data;
          this.hide = true;
        })
        .catch((resp) => {
          this.hide = false;
        });
    },
  },
  mounted() {
    this.getTotalProject();
    this.getTotalCategory();
    this.getAllProject();
  },
};
</script>

<style lang="scss" scoped>
.dframe {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}
.cframe {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  padding-top: 190px;
}
.content,
.outer-border {
  height: 400px;
}
.outer-border {
  position: relative;
  overflow: hidden;
}
.inner-border {
  position: absolute;
  left: 0;
  overflow-x: hidden;
  overflow-y: scroll;
}
.inner-border::-webkit-scrollbar {
  display: none;
}
</style>