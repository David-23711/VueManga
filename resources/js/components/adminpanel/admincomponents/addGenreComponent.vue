<template>
  <div>
    <v-dialog max-width="600">
      <template v-slot:activator="{ on, attrs }">
        <v-btn fab small v-on="on" v-bind="attrs" :loading='loading'>
          <v-icon>add</v-icon>
        </v-btn>
      </template>
      <template v-slot:default="dialog">
        <v-card>
          <v-toolbar class="cyan" dark flat>
            <v-toolbar-title>
              <span>Add Genres</span>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn outlined dark @click="dialog.value = false">
              <v-icon color="red">clear</v-icon>
            </v-btn>
          </v-toolbar>
          <v-card-text height="400" v-scroll.self="onScroll">
            <v-row>
              <v-col cols="12" md="12" sm="12" style="padding-top:90px;">
               <v-toolbar class="field" flat>
                   <v-textarea
                  :value="genre"
                  filled
                  readonly
                  fixed
                  placeholder="Please Check Box"
                >
                </v-textarea>
               </v-toolbar>
              </v-col>
              <v-col cols="12" md="12" sm="12">
                    <v-row>
                  <v-col
                    cols="4"
                    sm="3"
                    md="3"
                    v-for="cat in allCategory"
                    :key="cat.id"
                    class="ml-5"
                    max-height="400"
                  >
                    <v-checkbox
                      v-model="genre"
                      :label="cat.category"
                      :value="cat.category"
                    >
                    </v-checkbox>
                  </v-col>
                </v-row>
                
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions class="justify-end">
            <v-btn dark class="cyan" @click="addGenre(dialog)">
              <v-icon>add</v-icon>
              <span>Add</span>
            </v-btn>
          </v-card-actions>
        </v-card>
      </template>
    </v-dialog>
  </div>
</template>

<script>
import axios from 'axios';
import { eventBus } from '../../../app';
export default {
  data() {
    return {
      allCategory: [],
      genre: [],
      scrollInvoked: 0,
      loading:false,
    };
  },
  props:['id'],
  methods: {
    async getAllCategory() {
      await axios.get("/admin/category/post").then((resp) => {
        this.allCategory = resp.data;
      });
    },
     onScroll () {
        this.scrollInvoked++
      },
      async addGenre(dialog)
      {
        this.loading=true;
        await axios.post("/admin/manga/setting/addgenre",{
          mangaInfoId : this.id,
          genre : this.genre
        })
        .then((resp)=>{
          dialog.value = false;
          eventBus.$emit('addGenre');
        })
        .then((resp)=>{
          this.loading=false;
        })
        .catch((error)=>{
          this.loading=false;
        })
      }
  },
  mounted() {
    this.getAllCategory();
  },
};
</script>

<style lang="scss" scoped>


</style>