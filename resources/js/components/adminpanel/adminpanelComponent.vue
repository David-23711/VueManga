<template>
  <div>
    <v-app class="background">
        <Navcomponent/>
        <v-main class="topadmin">
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
import { mapGetters } from 'vuex';
import { eventBus } from '../../app';
export default {
components:{
    Navcomponent,
    FooterComponent
},
  data() {
    return {
      page:1,
      wide:false,
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
  },
  computed:{
    ...mapGetters(['adminData'])
  },
};
</script>

<style>
.background{
  
 background-color: rgb(30, 30, 30,1) !important;
}
.light{
  background-color:#3a547b  !important ;
}
</style>