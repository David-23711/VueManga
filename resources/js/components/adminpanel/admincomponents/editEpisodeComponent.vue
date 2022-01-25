<template>
  <div>
      <v-dialog max-width="600">
        <template v-slot:activator="{on,attrs}">
             <v-btn v-on="on" v-bind="attrs" text> Edit </v-btn>
        </template>
        <template v-slot:default="dialog">
             <v-row>
                 <v-col cols="12">
                    <v-card>
                        <v-toolbar>
                            <v-toolbar-title>
                                <span class="headline">Adding Episode</span>
                            </v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn @click="dialog.value=false" outlined>
                                <v-icon color="red">clear</v-icon>
                            </v-btn>
                        </v-toolbar>
                        <v-card-text>
                            <v-text-field v-model="Editepisode" filled label="episode">
                                   
                            </v-text-field>
                        </v-card-text>
                        <v-card-actions class="justify-end">
                               <v-btn :loading="loading" dark class="indigo" @click="updateEpisode(dialog)">Update</v-btn>
                        </v-card-actions>
                    </v-card>
                 </v-col>
             </v-row>
        </template>
   </v-dialog>
  </div>
</template>

<script>
import axios from 'axios';
import { eventBus } from '../../../app';
export default {
  data()
  {
      return {
          loading:false,
          Editepisode:this.episode,
      }
  },
  props:['episode','id'],
  methods:{
      async updateEpisode(dialog)
      {   
          this.loading=true;
          var formData = new FormData;
          formData.append('episode_name',this.Editepisode);
          formData.append('_method',"PUT");
          await axios.post(`/admin/manga/setting/episode/update/${this.id}`,formData)
          .then((resp)=>{
            dialog.value=false;
            this.loading=false;
            eventBus.$emit('updateEpisode');
          })
      }
  }
}
</script>

<style>

</style>