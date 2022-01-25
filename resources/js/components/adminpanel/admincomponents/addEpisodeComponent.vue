<template>
  <div>
   <v-dialog max-width="600">
        <template v-slot:activator="{on,attrs}">
             <v-btn v-on="on" v-bind="attrs"> Add Episode </v-btn>
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
                            <v-text-field v-model="episode" filled label="episode">
                                   
                            </v-text-field>
                        </v-card-text>
                        <v-card-actions class="justify-end">
                               <v-btn :loading="loading" dark class="indigo" @click="saveEpisode(dialog)">Save</v-btn>
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
            episode:'Episode ',
            loading:false,
        }
    },
    methods:{
        async saveEpisode(dialog)
        {
            this.loading=true;
            const volumeid = this.$route.params.id;
            const mangaid = this.$route.params.mid;
            await axios.post('/admin/manga/setting/episode/save',{
                volume_id:volumeid,
                manga_information_id:mangaid,
                episode_name:this.episode
            })
            .then((resp)=>{
                dialog.value = false;
                this.loading=false;
                eventBus.$emit('addEpisode');
            }) 
            .catch((error)=>{
                const Toast = Swal.mixin({
                    toast:true,
                    position:'top-right',
                    color:'white',
                    background:'red',
                    showConfirmButton:false,
                    timer:500,
                    timerProgressBar:true,
                });
                    Toast.fire({
                        title:error.response.data.errors.episode_name
                    })
                    this.loading=false;
            })

        }
    }
};
</script>

<style>
</style>