<template>
  <div class="mframe">
    <v-container v-if="!adminData">
      <v-row class="text-center">
        <v-col cols="12" md="6" offset-md="3">
          <v-card>
            <v-card-text>
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
        <v-col md="12" sm="12" cols="12">
          <v-card :loading="loading">
            <v-toolbar class="cyan" flat dark>
              <v-toolbar-title>
                <span class="overline hidden-md-and-down"
                  ><h5>Manga List</h5></span
                >
              </v-toolbar-title>
              <v-spacer></v-spacer>
              <v-row>
                <v-col cols="8" md="8" sm="8">
                  <v-text-field
                    placeholder="Search Manga"
                    dark
                    prepend-icon="search"
                    v-model="searchName"
                    @keyup.enter="getMangaInfo"
                    clearable
                  >
                  </v-text-field>
                </v-col>
                <v-col cols="4" md="4" sm="4">
                  <select
                    name=""
                    id=""
                    class="form-control"
                    v-model="byRelease"
                    @change="getByRelease"
                  >
                    <option value="All" selected>All</option>
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
              </v-row>
            </v-toolbar>
            <v-card-text>
              <v-responsive>
                <v-simple-table height="382" fixed-header>
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Visual Key</th>
                      <th>Manga Name</th>
                      <th>Alternative Name</th>
                      <th>Release Date</th>
                      <th>status</th>
                      <th>Actions</th>
                      <th>Setting</th>
                    </tr>
                  </thead>
                  <tbody v-if="error500 == false">
                    <tr
                      v-for="(manga, index) in mangaInformations.data"
                      :key="manga.id"
                    >
                      <td class="text-left">
                        <span class="overline">{{ index + 1 }}</span>
                      </td>
                      <td class="text-left pt-2">
                        <v-img
                          :id="index"
                          @loadstart="imgLoading = true"
                          @load="imgLoading = false"
                          :hidden="imgLoading == true"
                          :src="`/manga/${manga.visual_key}`"
                          alt=""
                          width="100"
                          height="150"
                          class="img"
                        >
                        </v-img>
                        <v-skeleton-loader
                          v-if="imgLoading == true"
                          type="image"
                          width="100"
                          height="150"
                          class="img"
                        >
                        </v-skeleton-loader>
                      </td>
                      <td class="text-left">
                        <span class="overline">{{ manga.manga_name }}</span>
                      </td>
                      <td>
                        <span class="overline">{{
                          manga.alternative_name
                        }}</span>
                      </td>
                      <td>
                        <span class="subtitle-2">{{ manga.release_date }}</span>
                      </td>
                      <td>
                        <span
                          class="subtitle-2"
                          :class="
                            manga.status == 'ongoing'
                              ? 'orange--text'
                              : 'green--text'
                          "
                          >{{ manga.status }}</span
                        >
                      </td>
                      <td>
                        <tr>
                          <td>
                            <edit-manga-component
                              :manga="manga"
                            ></edit-manga-component>
                          </td>
                          <td class="pa-2">||</td>
                          <td>
                            <v-icon color="red" @click="deleteData(manga)"
                              >delete</v-icon
                            >
                          </td>
                        </tr>
                      </td>
                      <td>
                        <v-btn
                          outlined
                          :to="`/admin/manga/setting/${manga.id}/admin/${manga.admin_id}`"
                        >
                          <v-icon>settings</v-icon>
                        </v-btn>
                      </td>
                    </tr>
                  </tbody>
                  <tbody v-if="error500 == true">
                    <tr>
                      <td colspan="8" align="center">
                        <span class="subtitle-2">Something Went Wrong</span>
                      </td>
                    </tr>
                  </tbody>
                  <tbody v-if="mangaInformations == 0">
                    <tr>
                      <td colspan="8" align="center">
                        <span class="subtitle-2">Result Not Found</span>
                      </td>
                    </tr>
                  </tbody>
                  <tbody v-if="mainLoading">
                    <tr>
                      <td colspan="8" align="center">
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
                      </td>
                    </tr>
                  </tbody>
                </v-simple-table>
              </v-responsive>
            </v-card-text>
            <v-card-actions class="justify-center">
              <v-spacer></v-spacer>
              <v-pagination
                v-model="pagination.current"
                :length="pagination.total"
                @input="onPageChange"
                prev-icon="mdi-menu-left"
                next-icon="mdi-menu-right"
              ></v-pagination>
              <v-spacer></v-spacer>
              <add-manga-component></add-manga-component>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { eventBus } from "../../app";
import addMangaComponent from "./admincomponents/addMangaComponent.vue";
import EditMangaComponent from "./admincomponents/editMangaComponent.vue";
export default {
  components: { addMangaComponent, EditMangaComponent },
  data() {
    return {
      page: 1,
      mangaInformations: {},
      error500: false,
      loading: false,
      mainLoading: false,
      imgLoading: false,
      releaseDates: [],
      searchName: "",
      byRelease: "All",
      pagination: {
        current: 1,
        total: 0,
      },
      options: [
        { name: "Aung Aung", age: "12" },
        { name: "Maung Maung", age: "13" },
        { name: "Lin Lin", age: "14" },
        { name: "Mya Mya", age: "15" },
        { name: "Hla Hla", age: "16" },
        { name: "Aung Lin", age: "17" },
      ],
    };
  },
  computed: {
    ...mapGetters(["adminData"]),
  },
  methods: {
    async getMangaInfo() {
      this.loading = true;
      this.mainLoading = true;
      await axios
        .get(
          `/admin/manga/post?search=${this.searchName} && page=${this.pagination.current}`
        )
        .then((resp) => {
          this.mangaInformations = resp.data;
          this.loading = false;
          this.mainLoading = false;
          this.imgLoading = false;
          this.pagination.current = resp.data.current_page;
          this.pagination.total = resp.data.last_page;
        })
        .catch((error) => {
          this.loading = false;
          this.mainLoading = false;
          this.imgLoading = false;
          if (error.response.status == 500) {
            this.error500 = true;
          } else {
            this.error500 = false;
          }
        });
    },
    onPageChange() {
      this.getMangaInfo();
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
          this.mangaInformations = resp.data;
        });
    },
    async deleteData(manga) {
      var formData = new FormData();
      formData.append("current_key", manga.visual_key);
      formData.append("_method", "DELETE");
      await axios
        .post(`/admin/manga/post/${manga.id}`, formData)
        .then((resp) => {
          this.getMangaInfo();
          const Toast = Swal.mixin({
            toast: true,
            iconColor: "white",
            position: "top-right",
            color: "white",
            background: "red",
            timer: 500,
            showConfirmButton: false,
            timerProgressBar: true,
          });
          Toast.fire({
            title: "Deleted",
            icon: "success",
          });
        });
    },
  },
  mounted() {
    this.getMangaInfo();
    eventBus.$on("addManga", () => {
      this.getMangaInfo();
    });
    eventBus.$on("editManga", () => {
      this.getMangaInfo();
    });
    this.getReleaseDates();
  },
};
</script>

<style lang="scss" scoped>
.img {
  border: 1px solid cyan;
  border-radius: 10px;
}
.mframe {
  display: flex;
  width: 100%;
  height: 100%;
  justify-content: center;
  align-items: center;
}
</style>
