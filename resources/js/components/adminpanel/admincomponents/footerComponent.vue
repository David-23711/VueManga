<template>
  <v-row class="my-3" v-if="wide==false">
      <!-- <v-app-bar flat class="light hidden-md-and-down">
        <v-spacer></v-spacer>
           <v-btn
        v-for="btn in btns"
        :key="btn.title"
        text
        rounded
        :ripple="true"
        :to="btn.to"
      >
        {{ btn.title }}
      </v-btn>
      <v-spacer></v-spacer>     
      </v-app-bar> -->
    <v-col cols="12" class="text-center"> ammgyi@gmail.com </v-col>
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
      wide:true,
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