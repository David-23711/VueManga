<template>
  <div>
    <v-dialog max-width="600">
      <template v-slot:activator="{ on, attrs }">
        <v-btn outlined color="primary" v-on="on" v-bind="attrs">
          <span>add Volumes</span>
          <v-icon>add</v-icon>
        </v-btn>
      </template>
      <template v-slot:default="dialog">
        <v-card>
          <v-toolbar dark>
            <v-toolbar-title>
              <span class="headline">Adding Volume</span>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn outlined @click="dialog.value = false">
              <v-icon color="red">clear</v-icon>
            </v-btn>
          </v-toolbar>
          <v-card-text class="mt-3">
            <v-row>
              <v-col cols="8" offset="2">
                <v-form ref="form">
                  <v-text-field
                    :rules="volumeRules"
                    label="Add Volume"
                    v-model="volume"
                  >
                  </v-text-field>
                </v-form>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions class="justify-center">
            <v-btn :loading="loading" dark @click="postVolume(dialog)">Add</v-btn>
          </v-card-actions>
        </v-card>
      </template>
    </v-dialog>
  </div>
</template>

<script>
import { eventBus } from '../../../app';
export default {
  data() {
    return {
      volume: "Vol.",
      loading:false,
      volumeRules:[
        v=>!!v || 'Volume is require!'
      ]
    };
  },
  props:['id'],
  methods:{
    async postVolume(dialog)
    {
      this.loading=true
      await axios.post(`/admin/manga/setting/addvolume`,{
        volume:this.volume,
        mangaInfoId:this.id
      })
      .then((resp)=>{
        dialog.value=false;
         this.loading = false;
        eventBus.$emit('addVolume');
      })
      .catch((error)=>{
        this.loading = false;
      })
    }
  }
};
</script>

<style>
</style>