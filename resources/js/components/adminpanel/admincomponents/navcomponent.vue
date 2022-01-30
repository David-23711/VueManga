<template>
  <div>
    <v-app-bar flat class="navColor" :hidden="wide" :hide-on-scroll="condition" >
       <v-app-bar-nav-icon
          class="hidden-md-and-up"
          @click="drawer = !drawer"
        ></v-app-bar-nav-icon>
      <v-toolbar-title>  
        <span class="headline font-weight-bold">Admin</span>
        <span class="headline font-weight-bold">Panel</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <span><div class="hidden-md-and-down">
           <span class="headline font-weight-bold">Admin</span>
        <span class="headline font-weight-bold">Panel</span>
       </div></span>
      <v-spacer></v-spacer>
       
      <v-btn
        v-if="!adminData"
        text
        to="/admin/register"
        class="hidden-md-and-down"
      >
        <span>Register</span>
        <v-icon>group</v-icon>
      </v-btn>
    </v-app-bar>
    <v-navigation-drawer v-if="wide==false" app v-model="drawer" class="drawerColor">
      <v-col class="text-center pt-4">
        <v-avatar size="100">
          <img
            :src="adminData ? `/manga/${adminData.avatar}` : '/manga/user.png'"
          />
        </v-avatar>
      </v-col>
      <v-col class="text-center">
        <span>{{ adminData ? adminData.email : "" }}</span
        ><br />
        <span>Welcome {{ adminData ? adminData.admin : "" }}</span
        ><br />
        <v-btn v-if="!adminData" text dark rounded to="/admin/login"
          >Login</v-btn
        >
        <v-row justify="space-around" v-if="adminData">
          <v-col cols="auto">
            <v-dialog transition="dialog-top-transition" max-width="600">
              <template v-slot:activator="{ on, attrs }">
                <v-btn text dark rounded v-on="on" v-bind="attrs">Edit</v-btn>
              </template>
              <template v-slot:default="dialog">
                <v-card>
                  <v-toolbar class="indigo" dark>
                    <v-toolbar-title> Edit Form </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn outlined @click="dialog.value = false">
                      <v-icon color="red">clear</v-icon>
                    </v-btn>
                  </v-toolbar>
                  <v-card-text class="pt-5">
                    <v-text-field
                      label="Name"
                      v-model="editName"
                      prepend-icon="people"
                    >
                    </v-text-field>

                    <v-file-input
                      label="Avatar"
                      v-model="editAvatar"
                      @change="showimg"
                    >
                    </v-file-input>

                    <v-row justify="center" align="center">
                      <v-avatar size="100">
                        <img :src="`/manga/${adminData.avatar}`" id="img" />
                      </v-avatar>
                    </v-row>
                  </v-card-text>
                  <v-card-actions class="justify-end">
                    <v-btn :loading="loading" class="indigo" dark @click="editAdmin(dialog)"
                      >Update</v-btn
                    >
                  </v-card-actions>
                </v-card>
              </template>
            </v-dialog>
          </v-col>
        </v-row>
      </v-col>
      <hr />
      <v-list dark>
        <v-list-item
          v-for="nav in mnavlinks"
          :key="nav.title"
          
          :to="nav.to"
        >
          <v-list-item-icon>
            <v-icon>{{ nav.icon }}</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title to="#">
              <span>{{ nav.title }}</span>
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item v-if="adminData" @click="logout">
          <v-list-item-icon>
            <v-icon>logout</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>
              <span>Logout</span>
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <v-list dark>
        <v-list-item
          to="/admin/register"
          class="hidden-md-and-up"
          v-if="!adminData"
        >
          <v-list-item-icon>
            <v-icon>group</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title to="#">
              <span>Register</span>
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { eventBus } from '../../../app';
export default {
  data() {
    return {
      dialog: false,
      drawer: true,
      subName: "",
      editName: "",
      editAvatar: [],
      wide:false,
      file:null,
      condition:true,
      loading:false,
      mnavlinks: [
        { icon: "dashboard", title: "Dashboard", to: "/admin/home" },
        { icon: "local_activity", title: "Projects", to: "/admin/manga" },
        { icon: "list", title: "Category", to: "/admin/category" },
         {
          icon: "groups",
          title: "Team",
          to: "/admin/team",
        },
      ],
    };
  },
  computed: {
    ...mapGetters(["adminData"]),
  },
  methods: {
    logout() {
      this.$store.dispatch("setAdminData", null);
    },
    showimg() {
      this.file = this.editAvatar;
      if (this.file == null) {
        img.src = `/manga/${this.adminData.avatar}`;
      } else {
        var reader = new FileReader();
        reader.onload = () => {
          var result = reader.result;
          var img = document.getElementById("img");
          img.src = result;
        };
       reader.readAsDataURL(this.file);
      }
       
    },
    async editAdmin(dialog) {
      if (this.editAvatar.length == 0) {
        this.loading=true;
        let formData = new FormData();
        formData.append("editName", this.editName);
        formData.append("_method", "PUT");
        await axios
          .post(`/admin/editdata/notavatar/${this.adminData.id}`, formData)
          .then((resp) => {
            this.$store.dispatch("setAdminData", resp.data);
            dialog.value = false;
            this.loading=false;
          });
      } else {
        this.loading=true;
        let formData = new FormData();
        formData.append("editName", this.editName);
        formData.append("editAvatar", this.editAvatar);
        formData.append("currentAvatar", this.adminData.avatar);
        formData.append("_method", "PUT");
        await axios
          .post(`/admin/editdata/withavatar/${this.adminData.id}`, formData)
          .then((resp) => {
            this.$store.dispatch("setAdminData", resp.data);
            dialog.value = false;
            this.loading=false;
          });
      }
    },
  },
  mounted() {
    if (this.adminData) {
      this.editName = this.adminData.admin;
    }
    eventBus.$on('nav',()=>{
      this.wide=true;
    })
    eventBus.$on("show",()=>{
      this.wide=false;
    })
  },
};
</script>

<style lang="scss" scoped>
.navColor {
  background-color: rgb(21, 110, 120) !important;
  color: rgb(9, 76, 107);
}
.drawerColor {
  background-color: #1a2639 !important;
  color: white;
}
</style>
