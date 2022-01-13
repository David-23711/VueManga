<template>
  <div>
    <v-app class="background">
        <Navcomponent/>
        <v-main>
          <router-view></router-view>
        </v-main>
        <v-footer padless class="light" dark>
           <FooterComponent/>
        </v-footer>
    </v-app>
  </div>
</template>

<script>
import Navcomponent from './admincomponents/navcomponent.vue'
import FooterComponent from './admincomponents/footerComponent.vue'
export default {
components:{
    Navcomponent,
    FooterComponent
},
  data() {
    return {
      page:1,
    };
  },
  methods:{
      next()
      {
          this.page++;
      },
      pre()
      {
          this.page--;
      }
  }
};
</script>

<style>
.background{
  
 background-color: rgb(63, 59, 110) !important;
}
.light{
  background-color:#3a547b  !important ;
}
</style>