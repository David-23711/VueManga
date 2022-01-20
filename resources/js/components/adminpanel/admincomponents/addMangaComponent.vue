<template>
  <div>
    <v-dialog transition="dialog-top-transition" max-width="800" :scrollable="true">
      <template v-slot:activator="{ on, attrs }">
        <v-fab-transition>
          <v-btn fab v-on="on" v-bind="attrs" dark class="cyan">
            <v-icon>add</v-icon>
          </v-btn>
        </v-fab-transition>
      </template>
      <template v-slot:default="dialog">
        <v-card style="border: 5px solid cyan">
          
            <v-toolbar class="cyan" dark >
            <span class="headline">Add Manga</span>
            <v-spacer></v-spacer>
            <v-btn text outlined dark @click="dialog.value = false">
              <v-icon color="white" size="30" class="pb-3">minimize</v-icon>
            </v-btn>
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
                    v-model="info.mangaName"
                    required
                    prepend-icon="wysiwyg"
                    :rules="info.mangaRules"
                  >
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="6" sm="6" lg="6">
                  <v-text-field
                    filled
                    label="Alternative Name"
                    v-model="info.alterName"
                    required
                    :rules="info.alterRules"
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
                    v-model="info.visualKey"
                    placeholder="Insert Image Here"
                    :rules="info.visualRules"
                    @change="showImage"
                  >
                  </v-file-input>
                  <img
                    src=""
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
                    v-model="info.author"
                    :rules="info.authorRules"
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
                    v-model="info.date"
                    :rules="info.dateRules"
                    prepend-icon="event"
                  >
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="6" sm="6">
                  <v-select
                    :items="statusData"
                    filled
                    label="choose one"
                    v-model="info.status"
                    :rules="info.statusRules"
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
                    v-model="info.description"
                    filled
                    :rules="info.dRules"
                  ></v-textarea>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
          <v-card-actions class="justify-end">
            <v-btn class="red" @click="cancelAdd(dialog)" dark>Cancel</v-btn>
            <v-btn class="cyan" dark @click="postManga(dialog)">Save</v-btn>
          </v-card-actions>
        </v-card>
      </template>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { eventBus } from '../../../app';
export default {
  data() {
    return {
      categoriesData: null,
      info: {
        mangaName: "",
        alterName: "",
        author:"",
        status: "",
        visualKey: [],
        date: "",
        description:'',
        mangaRules: [(v) => !!v || "Manga Name is require!"],
        alterRules: [(v) => !!v || "Alter Name is require!"],
        visualRules: [(v) => !!v || "Image is require!"],
        dateRules: [(v) => !!v || "Date is require!"],
        statusRules: [(v) => !!v || "Status is require!"],
        dRules:[(v)=> !!v || "Description is require!"],
        authorRules:[(v)=> !!v || "Author Name is require"]
      },
      statusData: ["ongoing", "complete"],
    };
  },
  computed: {
    ...mapGetters(["adminData"]),
  },
  methods: {
    showImage() {
      if (this.info.visualKey == null) {
        img.src = "";
      } else {
        let file = this.info.visualKey;
        let reader = new FileReader();
        reader.onload = () => {
          let result = reader.result;
          let img = document.getElementById("img");
          img.src = result;
        };
        reader.readAsDataURL(file);
      }
    },
    cancelAdd(dialog) {
      this.$refs.form.reset();
      dialog.value = false;
    },
    async postManga(dialog) {
     
      if (this.$refs.form.validate()) {
        let formData = new FormData();
        formData.append("manga_name", this.info.mangaName);
        formData.append("alternative_name", this.info.alterName);
        formData.append("author", this.info.author);
        formData.append("admin_id", this.adminData.id);
        formData.append("visual_key", this.info.visualKey);
        formData.append("release_date", this.info.date);
        formData.append("status", this.info.status);
        formData.append("description",this.info.description);
        await axios.post("/admin/manga/post", formData)
        .then((resp) => {
          this.$refs.form.reset();
         dialog.value = false;
          eventBus.$emit('addManga');
        })
        .then((resp)=>{
           const Toast = Swal.mixin({
           toast:true,
           color:'white',
           background:'green',
           position:'top-right',
           timer:1500,
           timerProgressBar:true,
           showConfirmButton:false,
         })
         Toast.fire({
           title:'Added',
           icon:'success',
         })  
        })
      }
    },
  },
  mounted() {
    
  },
};
</script>

<style>
</style>