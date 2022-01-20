<template>
  <div>
    <v-container>
      <v-row>
        <v-col cols="12" sm="10" md="8" offset-md="2" offset-sm="1">
          <v-card v-for="manga in mangaInfos" :key="manga.id">
            <v-toolbar flat dark class="cyan">
              <v-btn class="cyan" text to="/admin/manga">
                <v-icon>arrow_back</v-icon> 
              </v-btn>
            </v-toolbar>
            <v-card-title>
              <v-row>
                <v-col md="4" cols="12" sm="5" class="text-center">
                  <img
                    :src="`/manga/${manga.visual_key}`"
                  class="img"

                 />
                </v-col>
                <v-col md="8" cols="12" sm="7">
                  <v-simple-table>
                      <tbody>
                          <tr>
                              <td>Name:</td>
                              <td>{{manga.manga_name}}</td>
                          </tr>
                          <tr>
                              <td>Alternative:</td>
                              <td>{{manga.alternative_name}}</td>
                          </tr>
                          <tr>
                              <td>Author:</td>
                              <td>{{manga.author}}</td>
                          </tr>
                          <tr>
                              <td>Status:</td>
                              <td>{{manga.status}}</td>
                          </tr>
                          <tr>
                              <td width="150px">Release Date:</td>
                              <td>{{manga.release_date}}</td>
                          </tr>
                          <tr>
                              <td>Uploader:</td>
                              <td>{{adminName}}</td>
                          </tr>
                      </tbody>
                  </v-simple-table>
                </v-col>
              </v-row>
            </v-card-title>
            <v-card-text class="mt-2">
                <v-row>
                    <v-col cols="10" md="10" sm="10">
                         <v-row>
                           <span>Genres</span>
                           <v-col cols="6" md="3" sm="4" v-for="genre in genres" :key="genre.id">
                              <v-btn outlined color="" text small>
                                <span>{{genre.genre}}</span>
                                <v-icon  @click="deleteGenre(genre.id)" size="20" color="red">clear</v-icon>
                              </v-btn>
                           </v-col>
                         </v-row>
                    </v-col>
                    <v-col cols="2" md="2" sm="2">
                        <v-row>
                          <v-col cols="12">
                            <span>Add Genre</span><br>
                            <add-genre-component :id="$route.params.id"></add-genre-component>
                          </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <v-row>
                  <v-col cols="12" md="12" sm="12">
                       <span class="subtitle-1">Description</span><br>
                       <h6>
                         {{manga.description}}
                       </h6>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col cols="6" md="6" sm="6">
                     <span class="subtitle-1">Volumes</span>
                     <v-list>
                       <v-list-item v-for="volume in volumes" :key="volume.id">
                         <v-list-item-icon>
                              <v-icon>class</v-icon>
                       </v-list-item-icon>
                       <v-list-item-content>
                           <v-list-item-title class="subtitle-2">
                                  {{volume.volume}}
                           </v-list-item-title>
                       </v-list-item-content>
                       <v-list-item-action>
                         <v-icon>delete</v-icon>
                       </v-list-item-action>
                       </v-list-item>
                     </v-list>
                  </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions class="justify-center">
              <add-volume-component :id="$route.params.id"></add-volume-component>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import axios from "axios";
import addGenreComponent from './admincomponents/addGenreComponent.vue';
import { eventBus } from '../../app';
import AddVolumeComponent from './admincomponents/addVolumeComponent.vue';
export default {
  components: { addGenreComponent, AddVolumeComponent },
  data() {
    return {
      adminName: "",
      mangaInfos: [],
      genres:[],
      volumes:[],
    };
  },
  methods: {
    async getAdmin() {
      const aid = this.$route.params.aid;
      await axios.get(`/admin/manga/setting/${aid}`).then((resp) => {
        this.adminName = resp.data[0];
      });
    },
    async getInfos() {
      const aid = this.$route.params.aid;
      const id = this.$route.params.id;
      await axios.get(`/admin/manga/setting/${aid}/${id}`).then((resp) => {
        this.mangaInfos = resp.data;
      });
    },
    async getGenres()
    {
      const id = this.$route.params.id;
      await axios.get(`/admin/manga/getGenre/${id}`)
      .then((resp)=>{
        this.genres = resp.data;
      })
    },
    async deleteGenre(id)
    {
      let formData = new FormData();
      formData.append('_method','DELETE');
      await axios.post(`/admin/manga/getGenre/delete/${id}`,formData)
      .then((resp)=>{
        this.getGenres();
      })
    },
    async getVolume()
    {
      const id = this.$route.params.id;
      await axios.get(`/admin/manga/getVolume/${id}`)
      .then((resp)=>{
        this.volumes=resp.data;
      })
    }
  },
  mounted() {
    this.getAdmin();
    this.getInfos();
    this.getGenres();
    this.getVolume();
    eventBus.$on('addGenre',()=>{
      this.getGenres();
    })
    eventBus.$on('addVolume',()=>{
      this.getVolume();
    })
  },
};
</script>

<style lang="scss" scoped>
.img {
    width: 200px;
  height: 300px;
  margin-right: 50px;
}
.v-application .text-center {
    text-align: end !important;
}
@media only screen and(max-width: 600px) {
  .img {
    border: 1px solid cyan;
    height: auto;
    width: 335px;
    margin-right: 0px;
  }
  .v-application .text-center {
    text-align: center !important;
}
}
</style>