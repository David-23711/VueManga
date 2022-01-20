<template>
  <div>
      <v-dialog transition="dialog-top-transition" max-width="600">
                <template v-slot:activator="{ on, attrs }">
                  <v-fab-transition>
                    <v-btn v-on="on" v-bind="attrs" color="indigo" dark fab>
                      <v-icon>mdi-plus</v-icon>
                    </v-btn>
                  </v-fab-transition>
                </template>
                <template v-slot:default="dialog">
                  <v-card>
                    <v-toolbar class="indigo" flat>
                      <span class="white--text">Adding Category</span>
                      <v-spacer></v-spacer>
                      <v-btn @click="dialog.value = false" dark outlined>
                        <v-icon color="red">clear</v-icon>
                      </v-btn>
                    </v-toolbar>
                    <v-card-text class="pt-2">
                      <v-form ref="form">
                         <v-text-field
                        label="Category"
                        v-model="category"
                        filled
                        :append-icon="category.length == 0 ? ' ' : 'clear'"
                        @click:append="category=''"
                        :rules="categoryRules"
                      >
                      </v-text-field>
                      </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                      <v-btn dark class="indigo" @click="postCategory(dialog)" :loading="loading">save</v-btn>
                    </v-card-actions>
                  </v-card>
                </template>
              </v-dialog>
  </div>
</template>

<script>
import {eventBus} from '../../../app'
export default {
data()
{
    return {
        loading:false,
     category: "",
      categoryRules:[
          v=>!!v || 'Category is require!'
      ]
    }
},
methods:{
     async postCategory(dialog)
      {
          this.loading=true;
          await axios.post('/admin/category/post',{
              category:this.category,
          })
          .then((resp)=>{
              this.loading=false;
            dialog.value = false;
              eventBus.$emit('callCategory');
              console.log(resp.data);
              const Toast = Swal.mixin({
               toast:true,
              
               color:'white',
               background:'green',
               position:'top-right',
               showConfirmButton:false,
               timer:500,
               timerProgressBar:true,
              });
              Toast.fire({
                  title:resp.data.message,
                  
              })
          })
          .catch((error)=>{
              this.loading=false;
             const Toast = Swal.mixin({
               toast:true,
              
               color:'white',
               background:'red',
               position:'top-right',
               showConfirmButton:false,
               timer:1500,
               timerProgressBar:true,
              });
              Toast.fire({
                  title:error.response.data.errors.category,
                  
              })
          });
      },
}
}
</script>

<style>

</style>