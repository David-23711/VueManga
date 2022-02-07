<template>
  <div>
    <v-app class="background">
      <div class="frame">
        <v-container>
          <v-row>
            <v-col cols="12" md="12">
              <v-card dark class="gradient">
                <v-card-title class="ml-5">
                  <h2 data-aos="fade-down" data-aos-duration="2000">
                    Hello, I'm AMG
                  </h2>
                  <v-spacer></v-spacer>
                  <div
                    v-for="(icon, index) in icons"
                    :key="index"
                    data-aos="fade-right"
                    data-aos-duration="2000"
                  >
                    <img
                      :src="`/manga/${icon.path}`"
                      :height="icon.height"
                      class="ml-3"
                    />
                  </div>
                </v-card-title>
                <v-card-text class="ml-5">
                  <h2
                    data-aos="fade-in"
                    data-aos-offset="300"
                    data-aos-easing="ease-in-sine"
                    data-aos-duration="2000"
                  >
                    I'm a Web Developer and<br />
                    designer from Yangon.<br />I can create websites<br />
                    to help businesses do better.
                  </h2>
                </v-card-text>
              </v-card>
            </v-col>
            <v-col cols="12" md="12">
              <v-card class="gradient" dark>
                <v-card-title class="justify-center">
                  <h2 data-aos="fade-right" data-aos-duration="2000">
                    My Experience
                  </h2>
                </v-card-title>
                <v-card-text class="text-center">
                  <h3
                    data-aos="fade-in"
                    data-aos-offset="300"
                    data-aos-easing="ease-in-sine"
                    data-aos-duration="2000"
                  >
                    Learning programming by myself since 2019.Now, I can write
                    many business projects and some personal projects(eg.movie
                    website,manga website and live chat).Laravel, Vue js and
                    Mysql are mostly use in many projects. I have also learned
                    Vuex and Vuetify to good UI performance for my projects.
                  </h3>
                </v-card-text>
                <v-card-actions> </v-card-actions>
              </v-card>
            </v-col>
            <v-col cols="12" md="12">
              <v-card dark class="gradient">
                <v-card-text class="text-center">
                  <v-dialog max-width="600">
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn outlined v-on="on" v-bind="attrs">About Me</v-btn>
                    </template>
                    <template v-slot:default="dialog">
                      <v-card dark class="gradient">
                        <v-card-title class="justify-center">
                          <v-avatar size="150">
                            <img src="/manga/avatar6.png" alt="" />
                          </v-avatar>
                        </v-card-title>
                        <v-card-text>
                          <v-list
                            class="gradient"
                            v-for="(about, index) in abouts"
                            :key="index"
                          >
                            <v-list-item>
                              <v-list-item-icon>
                                <v-icon>{{ about.icon }}</v-icon>
                              </v-list-item-icon>
                              <v-list-item-content>
                                <v-list-item-title>
                                  <span class="subtitle-2">{{
                                    about.title
                                  }}</span>
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                  <span class="subtitle-2">{{
                                    about.value
                                  }}</span>
                                </v-list-item-subtitle>
                              </v-list-item-content>
                              <v-list-item-action v-if="about.img">
                                <v-btn :href="about.link">
                                  <v-icon color="red">{{ about.img }}</v-icon>
                                </v-btn>
                              </v-list-item-action>
                            </v-list-item>
                          </v-list>
                        </v-card-text>
                        <v-card-actions class="justify-end">
                          <v-btn
                            outlined
                            class="red white--text"
                            @click="dialog.value = false"
                          >
                            Close
                          </v-btn>
                        </v-card-actions>
                      </v-card>
                    </template>
                  </v-dialog>
                  <v-dialog max-width="900">
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn outlined v-on="on" v-bind="attrs">Skills</v-btn>
                    </template>
                    <template v-slot:default="dialog1">
                      <v-card class="gradient">
                        <v-card-title class="justify-center">
                          <h3 class="white--text">
                            Hover Image To See Effect<br />
                            For Mobile Touch Image
                          </h3>
                        </v-card-title>
                        <v-card-text>
                          <v-row>
                            <v-col
                              v-for="(skill, index) in icons"
                              :key="index"
                              cols="12"
                              md="6"
                            >
                              <v-hover v-slot="{ hover }" close-delay="200">
                                <v-card class="gradient" dark>
                                  <v-card-title class="justify-center">
                                    <v-img
                                      :src="`/manga/${skill.path}`"
                                      :height="skill.skillHeight"
                                      :width="skill.skillWidth"
                                      contain
                                      alt=""
                                      style="cursor: pointer"
                                    >
                                      <v-expand-transition>
                                        <div
                                          v-if="hover"
                                          class="
                                            d-flex
                                            transition-fast-in-fast-out
                                            red
                                            darken-2
                                            v-card--reveal
                                            text-h2
                                            white--text
                                            justify-center
                                            align-center
                                          "
                                          style="height: 100%"
                                        >
                                          <v-progress-circular
                                            :rotate="360"
                                            :size="100"
                                            :width="15"
                                            :value="skill.value"
                                            :color="skill.color"
                                          >
                                            {{ skill.value }}
                                          </v-progress-circular>
                                        </div>
                                      </v-expand-transition>
                                    </v-img>
                                  </v-card-title>

                                  <v-card-text class="text-center">
                                    <h3>{{ skill.name }}</h3>
                                  </v-card-text>
                                </v-card>
                              </v-hover>
                            </v-col>
                          </v-row>
                        </v-card-text>
                        <v-card-actions class="justify-end">
                          <v-btn
                            outlined
                            class="white--text"
                            @click="dialog1.value = false"
                            >Close</v-btn
                          >
                        </v-card-actions>
                      </v-card>
                    </template>
                  </v-dialog>
                  <v-btn
                    outlined
                    href="http://manga-app23711.herokuapp.com/user"
                    >Website</v-btn
                  >
                </v-card-text>
                <v-card-actions> </v-card-actions>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </div>
    </v-app>
  </div>
</template>

<script>
export default {
  data() {
    return {
      icons: [
        {
          path: "html.png",
          height: "70",
          value: "60",
          name: "Html",
          color: "orange darken-4",
          skillHeight: "200",
          skillWidth: "150",
        },
        {
          path: "css.png",
          height: "80",
          value: "30",
          name: "Css",
          color: "blue",
          skillHeight: "200",
          skillWidth: "200",
        },
        {
          path: "js.png",
          height: "50",
          value: "60",
          name: "Javascript",
          color: "yellow",
          skillHeight: "200",
          skillWidth: "200",
        },
        {
          path: "vue.png",
          height: "50",
          value: "70",
          name: "Vue Js",
          color: "teal lighten-1",
          skillHeight: "200",
          skillWidth: "200",
        },
        {
          path: "vuetify.png",
          height: "50",
          value: "60",
          name: "Vuetify",
          color: "light-blue lighten-1",
          skillHeight: "200",
          skillWidth: "150",
        },
        {
          path: "php.png",
          height: "50",
          value: "30",
          name: "PHP",
          color: "blue darken-3",
          skillHeight: "200",
          skillWidth: "300",
        },
        {
          path: "laravel.png",
          height: "70",
          value: "60",
          name: "Laravel",
          color: "red",
          skillHeight: "200",
          skillWidth: "150",
        },
        {
          path: "mysql.png",
          height: "50",
          value: "60",
          name: "Mysql",
          color: "orange",
          skillHeight: "200",
          skillWidth: "200",
        },
      ],
      abouts: [
        { title: "Name", value: "Aung Myint Myat", icon: "person" },
        { title: "Age", value: "20", icon: "money" },
        {
          title: "Email",
          value: "ammgyi@gmail.com",
          icon: "mail",
          link: "mailto:ammgyi@gmail.com",
          img: "mail",
        },
        { title: "Address", value: "North Okkalapa,Yangon", icon: "place" },
        { title: "Phone", value: "09254973900", icon: "phone" },
        {
          title: "Github",
          value: "https://github.com/Aungmyat23711",
          icon: "local_activity",
          link: "https://github.com/Aungmyat23711?tab=repositories",
          img: "input",
        },
      ],
    };
  },
  methods: {},
};
</script>

<style lang="scss" scoped>
.background {
  background: url("/manga/portwall.jpg");
  background-size: 100% 100%;
  width: 100%;
  height: 100%;
}
.frame {
  display: flex;
  width: 100%;
  height: 100%;
  justify-content: center;
  align-items: center;
}
.gradient {
  background: linear-gradient(to right, black, rgb(243, 12, 12));
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