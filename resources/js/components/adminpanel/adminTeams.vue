<template>
  <div>
     <v-container>
         <v-row>
             <v-col cols="6" md="3" sm="4"  v-for="(admin,index) in allAdmin" :key="admin.id">
                <v-card dark :class="index%2==0 ? 'primary':'success'">
                        <v-card-title class="justify-center">
                            <v-avatar size="150">
                               <img :src="`/manga/${admin.avatar}`" alt="">
                            </v-avatar>
                        </v-card-title>
                    <v-card-text class="text-center">
                        <v-list :class="index%2==0 ? 'primary':'success'">
                            <v-list-item>
                                <v-list-item-content>
                                     <v-list-item-title>
                                       <span>{{admin.admin}}</span>
                                    </v-list-item-title>
                                    <v-list-item-title>
                                       <span>{{admin.email}}</span>
                                    </v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>
                    </v-card-text>
                </v-card>
             </v-col>
         </v-row>
     </v-container>
  </div>
</template>

<script>
export default {
data()
{
    return {
        allAdmin:[],
    }
},
methods:{
    async getAllAdmin()
    {
       await axios.get('/admin/team/getAdmin')
       .then((resp)=>{
           this.allAdmin=resp.data;
       })
    }
},
mounted()
{
    this.getAllAdmin();
}
}
</script>

<style>

</style>