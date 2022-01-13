<template>
  <div>
      <div class="dframe" v-if="!adminData">
           <v-container >
          <v-row>
              <v-col cols="12" md="6" offset-md="3">
                  <v-card>
                      <v-card-text>
                          <h4>Please Login To Continue...</h4><br>
                          <v-btn dark to="/admin/login">
                              <span>Login</span>
                              <v-icon>login</v-icon>
                          </v-btn>
                      </v-card-text>
                  </v-card>
              </v-col>
          </v-row>
      </v-container>
      </div>
      <v-container v-if="adminData">
          <v-row>
             <v-col cols="12" md="6" sm="6">
                 <v-row>
                     <v-col cols="6" md="6" sm="6">
                          <v-card to="#" justify-center>
                              <v-card-text>
                                  <v-btn text>
                                      <span class="mr-3">Total User</span>
                                      <v-badge content="0" class="mt-3"></v-badge>
                                  </v-btn>
                              </v-card-text>
                          </v-card>
                     </v-col>
                     <v-col cols="6" md="6" sm="6">
                            <v-card to="#1">
                              <v-card-text>
                                  <v-btn text>
                                      <span class="mr-3">Total Project</span>
                                      <v-badge content="0" class="mt-3"></v-badge>
                                  </v-btn>
                              </v-card-text>
                          </v-card>
                     </v-col>
                     <v-col cols="12" md="12" sm="12">
                         <v-card>
                             <v-card-text>
                                <h1>Hello World</h1>
                             </v-card-text>
                         </v-card>
                     </v-col>
                     <v-col cols="12" md="6" sm="6">
                          <v-card to="#" justify-center>
                              <v-card-text>
                                  <h4>Hello World</h4>
                              </v-card-text>
                          </v-card>
                     </v-col>
                     <v-col cols="12" md="6" sm="6">
                            <v-card>
                              <v-card-text>
                                  <h4>Hello World</h4>
                              </v-card-text>
                          </v-card>
                     </v-col>
                     <v-col cols="12" md="12" sm="12">
                        <v-carousel v-model="model" height="160">
    <v-carousel-item
      v-for="(color, i) in colors"
      :key="color"
      round
     
    >
      <v-sheet
        :color="color"
        height="100%"
        tile
        elevation="12"
       
      >
      
        <v-row
          class="fill-height text-center"
          align="center"
          justify="center"
        >
          <div class="text-h2">
            Slide {{ i + 1 }}
          </div>
        </v-row>
      </v-sheet>
    </v-carousel-item>
  </v-carousel>
                     </v-col>
                 </v-row>
             </v-col>
              <v-col cols="12" md="6" sm="6">
                 <v-card height="450">
                     <v-card-text>
                         <h2>Hello World</h2>
                     </v-card-text>
                 </v-card>
             </v-col>
          </v-row>
      </v-container>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
data()
{
    return {
         model:0,
         colors:[
             'red',
             'green',
             'blue',
             'pink',
             'yellow',
             'black'
         ],
    }
},
computed:{
    ...mapGetters(['adminData']),
}
}
</script>

<style lang="scss" scoped>
.dframe{
   padding-top: 200px;
   text-align: center;
}
</style>