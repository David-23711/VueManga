<template>
  <div class="sframe">
    <v-container v-if="mangaInfos==0">
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
    <v-container v-if="mangaInfos!=0">
      <v-row>
        <v-col cols="12" sm="10" md="8" offset-md="2" offset-sm="1">
          <v-card v-for="manga in mangaInfos" :key="manga.id" :loading="cardLoading">
            <v-toolbar flat dark class="cyan" floating>
              <v-btn class="cyan" text to="/admin/manga">
                <v-icon>arrow_back</v-icon> 
              </v-btn>
            </v-toolbar>
            <v-card-title>
              <v-row>
                <v-col md="4" cols="12" sm="5" class="text-center">
                  <img
                  v-if="imageLoading==false"
                    :src="`/manga/${manga.visual_key}`"
                    class="img"
                 />
                    <v-skeleton-loader
                        type="image"
                        v-if="imageLoading==true"
                      >
                      </v-skeleton-loader>
                
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
                  <v-col cols="12" md="6" sm="12">
                     <span class="subtitle-1">Volumes</span>
                     <v-list>
                       <v-list-item v-for="volume in volumes" :key="volume.id">
                         <v-list-item-icon>
                              <v-icon>class</v-icon>
                       </v-list-item-icon>
                       <v-list-item-content>
                           <v-list-item-title class="subtitle-2">
                                  <span>{{volume.volume}}</span>
                           </v-list-item-title>
                       </v-list-item-content>
                       <v-list-item-action>
                         <v-btn :loading="loading" outlined color="red" text @click="deleteVolume(volume.id)">
                           <v-icon color="red">delete</v-icon>
                         </v-btn>
                       </v-list-item-action>
                       <v-list-item-action>
                          <v-btn outlined color="blue"  text :to="`/admin/manga/volume/episodes/${volume.id}/${manga.id}`">
                           <v-icon color="blue">input</v-icon> 
                         </v-btn>
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
      cardLoading:false,
      genres:[],
      volumes:[],
      loading:false,
      imageLoading:false,
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
      this.imageLoading=true;
      const aid = this.$route.params.aid;
      const id = this.$route.params.id;
      await axios.get(`/admin/manga/setting/${aid}/${id}`).then((resp) => {
        this.mangaInfos = resp.data;
        this.imageLoading=false;
      })
      .catch((error)=>{
        this.imageLoading=false;
      })
    },
    async getGenres()
    {
      this.cardLoading=true;
      const id = this.$route.params.id;
      await axios.get(`/admin/manga/getGenre/${id}`)
      .then((resp)=>{
        this.genres = resp.data;
        this.cardLoading=false;
      })
    },
    async deleteGenre(id)
    {
      this.cardLoading=true;
      let formData = new FormData();
      formData.append('_method','DELETE');
      await axios.post(`/admin/manga/getGenre/delete/${id}`,formData)
      .then((resp)=>{
        this.getGenres();
        this.cardLoading=false;
      })
      .catch((error)=>{
       this.cardLoading=false;
      })
    },
    async getVolume()
    {
      const id = this.$route.params.id;
      await axios.get(`/admin/manga/getVolume/${id}`)
      .then((resp)=>{
        this.volumes=resp.data;
      })
    },
    async deleteVolume(id)
    {
       this.cardLoading=true;
       let formData = new FormData;
       formData.append("_method","DELETE");
       await axios.post(`/admin/manga/getVolume/${id}/${this.$route.params.id}`,formData)
       .then((resp)=>{
         this.getVolume();
         this.cardLoading=false;
       })
       .catch((error)=>{
         this.cardLoading=false;
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
  height: 300px !important;
  margin-right: 50px;
  border: 1px solid cyan;
}
.sframe{
  width:100%;
  height: 100%;
  justify-content: center;
  align-items: center;
  display: flex;
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