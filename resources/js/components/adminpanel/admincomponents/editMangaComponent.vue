<template>
  <div>
    <v-dialog max-width="700">
      <template v-slot:activator="{ on, attrs }">
        <v-icon color="cyan" v-on="on" v-bind="attrs" @click="showEdit">
          edit
        </v-icon>
      </template>
      <template v-slot:default="dialog">
        <v-card style="border: 5px solid cyan">
          <v-toolbar class="cyan" dark>
            <span class="headline">Edit Manga</span>
            <v-spacer></v-spacer>
            
            <v-btn text outlined dark @click="cancelAdd(dialog)">
              <v-icon color="red">clear</v-icon>
            </v-btn>
          </v-toolbar>
          <v-card-text class="pt-5">
            <v-form ref="form">
              <v-row>
                <v-col cols="12" md="6" sm="6" lg="6">
                  <v-text-field
                    filled
                    label="Manga Name"
                    v-model="edit.mangaName"
                    required
                    prepend-icon="wysiwyg"
                    :rules="edit.mangaRules"
                  >
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="6" sm="6" lg="6">
                  <v-text-field
                    filled
                    label="Alternative Name"
                    v-model="edit.alterName"
                    required
                    :rules="edit.alterRules"
                    prepend-icon="event_note"
                  >
                  </v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="6" sm="6" lg="6">
                  <v-file-input
                    filled
                    prepend-icon="image"
                    v-model="edit.visualKey"
                    placeholder="Insert Image Here"
                    @change="showImage"
                  >
                  </v-file-input>
                   <img
                    :src="`/manga/${edit.image}`"
                    id="img"
                    width="175"
                    height="250"
                    style="border: 1px solid cyan;margin-left:30px;"
                  />
                </v-col>
                <v-col cols="12" md="6" sm="6" lg="6">
                  <v-text-field
                   label="Author"
                    filled
                    v-model="edit.author"
                    :rules="edit.authorRules"
                    prepend-icon="face"
                  >

                  </v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="6" sm="6">
                  <v-text-field
                    label="Release Date"
                    filled
                    v-model="edit.date"
                    :rules="edit.dateRules"
                    prepend-icon="event"
                  >
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="6" sm="6">
                  <v-select
                    :items="statusData"
                    filled
                    label="choose one"
                    v-model="edit.status"
                    :rules="edit.statusRules"
                    prepend-icon="verified"
                  >
                  </v-select>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="12" sm="12">
                  <v-textarea
                    prepend-icon="description"
                    placeholder="Write descriptions"
                    v-model="edit.description"
                    filled
                    :rules="edit.dRules"
                  ></v-textarea>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
          <v-card-actions class="justify-end">
            <v-btn :loading="loading" dark class="cyan" @click="updateManga(dialog)"> 
                Update
            </v-btn>
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
      edit: {
          id:"",
        mangaName: "",
        alterName: "",
        author:"",
        status: "",
        visualKey: [],
        image: "",
        date: "",
        loading:false,
        description: "",
        currentKey:"",
        file:null,
        mangaRules: [(v) => !!v || "Manga Name is require!"],
        alterRules: [(v) => !!v || "Alter Name is require!"],
        dateRules: [(v) => !!v || "Date is require!"],
        statusRules: [(v) => !!v || "Status is require!"],
        dRules: [(v) => !!v || "Description is require!"],
      },
      statusData: ["ongoing", "complete"],
    };
  },
  props: ["manga"],
  methods: {
    showEdit() {
      this.edit.mangaName = this.manga.manga_name;
      this.edit.alterName = this.manga.alternative_name;
      this.edit.author = this.manga.author;
      this.edit.status = this.manga.status;
      this.edit.date = this.manga.release_date;
      this.edit.image = this.manga.visual_key;
      this.edit.description = this.manga.description;
      this.edit.id = this.manga.id;
      this.edit.currentKey = this.manga.visual_key;
    },
    showImage() {
      if (this.edit.visualKey == null) {
        img.src = "";
      } else {
        this.file = this.edit.visualKey;
        let reader = new FileReader();
        reader.onload = () => {
          let result = reader.result;
          let img = document.getElementById("img");
          img.src = result;
        };
        reader.readAsDataURL(this.file);
      }
    },
    cancelAdd(dialog) {
      this.$refs.form.reset();
      dialog.value = false;
    },
    async updateManga(dialog)
    {
         this.loading=true;
        let formData = new FormData();
        formData.append("manga_name", this.edit.mangaName);
        formData.append("alternative_name", this.edit.alterName);
        formData.append("author", this.edit.author);
        formData.append("visual_key", this.edit.visualKey);
        formData.append("current_key",this.edit.currentKey)
        formData.append("release_date", this.edit.date);
        formData.append("status", this.edit.status);
        formData.append("description",this.edit.description);
        formData.append('_method',"PUT");
        await axios.post(`/admin/manga/post/${this.edit.id}`,formData)
        .then((resp)=>{
            eventBus.$emit("editManga");
            this.loading=false;
            dialog.value = false;
            const Toast = Swal.mixin({
                toast : true,
                color:'white',
                iconColor:'white',
                background:'green',
                timer:1500,
                showConfirmButton:false,
                timerProgressBar: true,
                position:'top-right'
            })
            Toast.fire({
                title:'Updated',
                icon:'success',
            })
            .catch((error)=>{
              this.loading=false;
            })
        })
    }
  },
};
</script>

<style lang="scss" scoped>
.img{
    border: 1px solid cyan;
    border-radius:20px ;
}
</style>