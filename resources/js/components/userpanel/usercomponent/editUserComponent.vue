<template>
  <div>
    <v-dialog max-width="550">
      <template v-slot:activator="{ on, attrs }">
        <v-btn v-bind="attrs" v-on="on" class="primary" dark> Edit </v-btn>
      </template>
      <template v-slot:default="dialog">
        <v-card>
          <v-toolbar flat>
            <v-spacer></v-spacer>
            <v-btn class="pink" @click="dialog.value = false">
              <v-icon color="white">clear</v-icon>
            </v-btn>
          </v-toolbar>
          <v-card-text>
            <v-form ref="form">
              <v-row class="mt-5">
                <v-col cols="6" md="6" sm="6">
                  <v-text-field label="First Name" v-model="editFname">
                  </v-text-field>
                </v-col>
                <v-col cols="6" md="6" sm="6">
                  <v-text-field label="Last Name" v-model="editLname">
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="12" sm="12" class="text-center">
                  <v-file-input v-model="input" @change="showImage">
                  </v-file-input>
                  <v-avatar size="100">
                    <img
                      :src="
                        userImage != null
                          ? `/manga/${userData.avatar}`
                          : `/manga/user.png`
                      "
                      id="img"
                    />
                  </v-avatar>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-btn dark class="primary" @click="updateUser(dialog)"
              >Update</v-btn
            >
          </v-card-actions>
        </v-card>
      </template>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      editFname: "",
      editLname: "",
      input: [],
    };
  },
  computed: {
    ...mapGetters(["userData"]),
    userImage() {
      if (this.userData) {
        if (this.userData.avatar == null) {
          return null;
        } else {
          return this.userData.avatar;
        }
      }
      if (!this.userDara) {
        return null;
      }
    },
  },
  methods: {
    showImage() {
      let file = this.input;
      if (file == null) {
        document.getElementById("img").src = null;
      } else {
        let reader = new FileReader();
        reader.onload = () => {
          let result = reader.result;
          let img = document.getElementById("img");
          img.src = result;
        };
        reader.readAsDataURL(file);
      }
    },
    async updateUser(dialog) {
      let formData = new FormData();
      formData.append("first_name", this.editFname);
      formData.append("last_name", this.editLname);
      formData.append("avatar", this.input);
      formData.append("current_avatar", this.userData.avatar);
      formData.append("_method", "PUT");
      await axios
        .post(`/update/user/${this.userData.id}`, formData)
        .then((resp) => {
          this.$store.dispatch("setUser", resp.data);
          dialog.value = false;
        });
    },
  },
  mounted() {
    this.editFname = this.userData.first_name;
    this.editLname = this.userData.last_name;
  },
};
</script>

<style>
</style>