<template>
  <div>
     <v-dialog max-width="600" transition="dialog-top-transition">
        <template v-slot:activator='{on,attrs}'>
             <v-btn text color='blue' v-on="on" v-bind="attrs" @click="showEdit">
               <v-icon>edit</v-icon>
             </v-btn>
        </template>
        <template v-slot:default='dialog'>
            <v-card>
                <v-toolbar flat class="indigo" dark>
                    <span>Edit Category</span>
                    <v-spacer></v-spacer>
                    <v-btn outlined dark color="red" @click="dialog.value = false">
                        <v-icon>clear</v-icon>
                    </v-btn>
                </v-toolbar>
                <v-card-text class="pt-2">
                   <v-form ref="form">
                          <v-text-field
                          label="Edit Category"
                    v-model="editCategory"
                    filled
                    required
                    :rules="editCategoryRules"
                    :append-icon="editCategory.length == 0 ? ' ':'clear'"
                    @click:append='editCategory=""'
                    >

                    </v-text-field>
                   </v-form>
                </v-card-text>
                <v-card-actions class="justify-end">
                   <v-btn dark class="indigo" @click="updateCategory(dialog)" :loading='loading'>Update</v-btn>
                </v-card-actions>
            </v-card>
        </template>
     </v-dialog>
  </div>
</template>

<script>
import axios from 'axios';
import {eventBus} from '../../../app'
export default {
data(){
    return{
        loading:false,
     editCategory:'',
     editCategoryRules:[
         v=>!!v || 'Category is required',
     ]
    }
},
props:['category'],
methods:{
    showEdit()
    {
        this.editCategory=this.category.category;
    },
    async updateCategory(dialog)
    {
       if(this.$refs.form.validate())
       {
           
            this.loading=true;
        let formData = new FormData;
        formData.append('editCategory',this.editCategory);
        formData.append('_method',"PUT");
        await axios.post(`/admin/category/post/${this.category.id}`,formData)
        .then((resp)=>{
            this.loading=false;
            dialog.value = false;
            eventBus.$emit('updateCategory');
            const Toast =Swal.mixin({
              toast:true,
              color:'white',
              iconColor:'white',
              background:'green',
              showConfirmButton:false,
              timer:1500,
              timerProgressBar:true,
            })
            Toast.fire({
                title:resp.data.message,
                icon:'success'
            })
        })
        .catch((error)=>{
         if(error)
         {
              this.loading=false;
           const Toast =Swal.mixin({
              toast:true,
              color:'white',
              iconColor:'white',
              background:'red',
              showConfirmButton:false,
              timer:1500,
              timerProgressBar:true,
            })
            Toast.fire({
                title:error,
                icon:'error'
            })
         }
        })
       }
    }
},
mounted()
{
    this.showEdit();
}
}
</script>

<style>

</style>