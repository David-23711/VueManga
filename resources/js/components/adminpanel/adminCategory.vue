<template>
  <div class="tframe">
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
        <v-col cols="12" md="8" offset-md="2" sm="12">
          <v-sheet>
            <v-card :loading="categoriesData ? false : true">
              <v-toolbar flat class="indigo">
                <span class="white--text"><h5>Categories List</h5></span>
                <v-spacer></v-spacer>
                <v-text-field
                dark
                prepend-icon="search"
                v-model="searchName"
                placeholder="Seach Category"
                :append-icon="searchName.length == 0 ? ' ' : 'clear'"
                @click:append="searchName = ''"
                @keyup.enter="getCategory()"
              >
              </v-text-field>
                <!-- <multiselect
                  v-if="categoriesData != null"
                  v-model="searchName"
                  :options="categoriesData"
                  append-icon="clear"
                  placeholder="Select one"
                  :custom-label="nameWithLang"
                  label="name"
                  track-by="name"
                  style="z-index:1;"
                 
                ></multiselect> -->
              </v-toolbar>
              <v-card-text>
                <v-simple-table height="300">
                  <thead>
                    <tr>
                      <th class="text-left"><h6>Id</h6></th>
                      <th class="text-left"><h6>Categories</h6></th>
                      <th class="pl-5"><h6>Actions</h6></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="category in categoriesData" :key="category.id">
                      <td>{{ category.id }}</td>
                      <td>{{ category.category }}</td>
                      <td>
                        <tr>
                          <td>
                            <edit-category-component
                              :category="category"
                            ></edit-category-component>
                          </td>
                          <td class="pl-2 pr-2">||</td>
                          <td>
                            <v-btn
                              text
                              @click="deleteCategory(category.id)"
                              style="z-index: 0"
                            >
                              <v-icon class="delete" color="red">delete</v-icon>
                            </v-btn>
                          </td>
                        </tr>
                      </td>
                    </tr>
                    <tr v-if="terror == true">
                      <td colspan="3" class="text-center">
                        Something Went Wrong
                      </td>
                    </tr>
                    <tr v-if="categoriesData == 0">
                      <td colspan="3" class="text-center">
                        Result Not Found
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
              </v-card-text>
              <v-card-actions class="justify-end">
                <add-category-component></add-category-component>
              </v-card-actions>
            </v-card>
          </v-sheet>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { eventBus } from "../../app";
import addCategoryComponent from "./admincomponents/addCategoryComponent.vue";
import EditCategoryComponent from "./admincomponents/editCategoryComponent.vue";
export default {
  data() {
    return {
      terror: false,
      searchName: "",
      categoriesData: null,
      mainLoading:false,
    };
  },
  components: { addCategoryComponent, EditCategoryComponent },
  computed: {
    ...mapGetters(["adminData"]),
  },
  methods: {
    nameWithLang({ category }) {
      return `${category}`;
    },
    async getCategory() {
      this.mainLoading = true;
      await axios
        .get(`/admin/category/post?search=${this.searchName}`)
        .then((resp) => {
          this.terror = false;
          this.mainLoading = false;
          this.categoriesData = resp.data;
        })
        .catch((error) => {
          this.mainLoading=false;
          if (error.response.status == 500) {
            this.terror = true;
            const Toast = Swal.mixin({
              toast: true,
              iconColor: "white",
              color: "white",
              background: "red",
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true,
              position: "top-right",
            });
            Toast.fire({
              title: "Something Went Wrong(error code 500)",
              icon: "error",
            });
          }
        });
    },
    async deleteCategory(id) {
      let formData = new FormData();
      formData.append("_method", "DELETE");
      await axios.post(`/admin/category/post/${id}`, formData).then((resp) => {
        this.getCategory();
        const Toast = Swal.mixin({
          toast: true,
          color: "white",
          background: "green",
          timer: 500,
          showConfirmButton: false,
          timerProgressBar: true,
          position: "top-right",
        });
        Toast.fire({
          title: "Deleted",
        });
      });
    },
  },
  mounted() {
    this.getCategory();
    eventBus.$on("callCategory", () => {
      this.getCategory();
    });
    eventBus.$on("updateCategory", () => {
      this.getCategory();
    });
  },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style lang="scss" scoped>
.tframe {
  width: 100%;
  height: 100%;
  justify-content: center;
  align-items: center;
  display: flex;
}
.delete {
  z-index: 0;
}
</style>