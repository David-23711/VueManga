<template>
  <v-row v-if="wide==false">
   
  <v-app-bar :hidden="wide">
    <v-spacer></v-spacer>
    <span>ammgyi@gmail.com</span>
    <v-spacer></v-spacer>
  </v-app-bar>
    
  </v-row>
</template>   
<script>
import { eventBus } from '../../../app';
export default {
  data() {
    return {
      btns: [
        { title: "Home", to: "/home" },
        { title: "Projects", to: "/admin/projects" },
        { title: "Add Project", to: "/admin/addProject" },
        { title: "Add Category", to: "/admin/addCategory" },
      ],
      wide:false,
    };
  },
  mounted()
  {
    eventBus.$on("wide",()=>{
      this.wide=true;
    })
    eventBus.$on("show",()=>{
      this.wide=false;
    })
  }
 
};
</script>

<style lang="scss" scoped>

</style>