<template>
  <div>
    <v-container>
      <v-card>
        <v-toolbar>
          <v-toolbar-title>
            <v-btn @click="goBack">
              <v-icon>arrow_back</v-icon>
            </v-btn>
            <span class="subtitle-1">Image Uploading</span>
          </v-toolbar-title>
          <v-spacer></v-spacer>
          <v-row>
            <v-col cols="8" md="8" class="mt-5">
              <v-form id="form" ref="form">
                <v-file-input
                  id="image"
                  :clearable="false"
                  multiple
                  label="image"
                  @change="imageSelect"
                  v-model="inputs"
                  hide-input
                  prepend-icon="none"
                >
                </v-file-input>
                <!-- <input type="file" id="image" multiple hidden @change="imageSelect"> -->
              </v-form>
            </v-col>
            <v-col cols="4" md="4" class="mt-5">
              <v-btn @click="clickImage">
                <span>Upload</span>
                <v-icon>upload</v-icon>
              </v-btn>
            </v-col>
          </v-row>
        </v-toolbar>
        <v-card-text>
          <v-row id="container" class="justify-center"> 
    
          </v-row>
        </v-card-text>
        <v-card-actions class="justify-end">
          <v-btn :loading="loading" small class="cyan" dark @click="uploadImages">Upload</v-btn>
        </v-card-actions>
      </v-card>
    </v-container>
  </div>
</template>

<script>
export default {
  data() {
    return {
      inputs: [],
      images: [],
      files:[],
      loading:false,
    };
  },
  methods: {
    clickImage() {
      document.getElementById("image").click();
    },
    imageSelect() {
      let image = this.inputs;
      for (var i = 0; i < image.length; i++) {
        this.images.push({
          name: image[i].name,
          url: URL.createObjectURL(image[i]),
          file: image[i],
        });
       
      } 
      for (let i = 0; i < this.inputs.length; i++) {
          this.files.push(this.inputs[i]);
        }
      console.log(this.files);
      document.getElementById("form").reset();
      document.getElementById("container").innerHTML = this.image_show();
    },
    image_show() {
      var image = "";
      this.images.forEach((i) => {
        image +=
          `<div class="img_container">
                <img src="` +
          i.url +
          `" alt="" />
                <span onclick="delete_image(` +
          this.images.indexOf(i) +
          `)">&times</span>
              </div>`;
      });
      return image;
    },
    delete_image(e) {
      this.images.splice(e, 1);
      document.getElementById("container").innerHTML = this.image_show();
    },
    goBack()
    {
      this.$router.back();
    },
    async uploadImages() {
      this.loading=true;
      let eid = this.$route.params.eid;
      let mid = this.$route.params.mid;
      let vid = this.$route.params.vid;
      var formData = new FormData();
      formData.append("episode_id", eid);
      formData.append("manga_information_id", mid);
      formData.append("volume_id", vid);
      for (let i = 0; i < this.files.length; i++) {
        formData.append("multi_images[]", this.files[i]);
      }
        const config = {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        };

      await axios
        .post("/admin/manga/volume/episodes/insertImage", formData, config)
        .then((resp) => {
          alert("Success");
          this.$refs.form.reset();
          this.images=[];
          this.files=[];
          this.loading=false;
        });
    },
  },
  created() {
    window.delete_image = this.delete_image;
  },
};
</script>

<style lang="scss" scoped>
::v-deep .img_container {
  height: 300px;
  width: 200px;
  border-radius: 6px;
  overflow: hidden;
  margin: 10px;
}
::v-deep .img_container img {
  height: 300px;
  width: 200px;
  object-fit: cover;
}
::v-deep .img_container span {
  position: relative;
  top: -285px;
  right: -165px;
  font-size: 28px;
  font-weight: normal;
  cursor: pointer;
  color: red;
}
@media only screen and(max-width:600px) {
  .img_container {
    height: 400px;
    width: 300px;
    border-radius: 6px;
    overflow: hidden;
  }
  .img_container img {
    height: 400px;
    width: 300px;
    object-fit: cover;
  }
}
</style>