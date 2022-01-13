<template>
  <div>
      <vue-dropzone
    ref="myVueDropzone"
    id="dropzone"
    :options="dropzoneOptions"
    @vdropzone-removed-file="vremove"
  ></vue-dropzone>
  <v-btn @click="vremove = true">Remove</v-btn>
  </div>
</template>
  
<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";

export default {
  components: {
    vueDropzone: vue2Dropzone,
  },
  data() {
    return {
        vremove:false,
      dropzoneOptions: {
        url: "https://httpbin.org/post",
        thumbnailWidth: 150,
        maxFilesize: 0.5,
        headers: { "My-Awesome-Header": "header value" },
      },
    };
  },
  mounted() {
    console.log("Component mounted.");
  },
};
</script>