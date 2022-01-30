<template>
<div>
    <v-container>
       <v-tabs class="mb-5">
           <v-tabs-slider color="primary"></v-tabs-slider>
           <v-tab>Latest</v-tab>
           <v-tab v-for="genre in genres" :key="genre.id">
              {{genre.category}}
           </v-tab>
       </v-tabs>
       <v-toolbar class="mb-4">
           
       </v-toolbar>
      <v-row>
        <v-col cols="12" sm="6" md="4" v-for="data in datas" :key="data.id">
          <v-card>
            <v-card-text>
              <v-row>
                <v-col cols="5" md="5" sm="5">
                  <img class="img" :src="`/manga/${data.visual_key}`" alt="" />
                </v-col>
                <v-col cols="7" md="7" sm="7">
                  <v-list>
                    <v-list-item>
                      <v-list-item-content>
                        <v-list-item-subtitle> 
                           <span>Manga Name</span>
                        </v-list-item-subtitle>
                        <v-list-item-title>
                          <span style="cursor:pointer;" :title="data.manga_name" class="font">{{ data.manga_name }}</span>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-content>
                        <v-list-item-subtitle> 
                           <span>Alternative Name</span>
                        </v-list-item-subtitle>
                        <v-list-item-title>
                          <span style="cursor:pointer;" :title="data.alternative_name" class="font">{{ data.alternative_name }}</span>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-content>
                        <v-list-item-subtitle> 
                           <span>Release Date</span>
                        </v-list-item-subtitle>
                        <v-list-item-title>
                          <span class="font">{{ data.release_date}}</span>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-actions>
              <v-rating
                v-model="rating"
                :length="length"
                color="red lighten-3"
                background-color="grey lighten-1"
              ></v-rating>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
</div>
</template>

<script>
export default {

}
</script>

<style>

</style>