<template>
  <div class="frame">
    <v-container>
      <v-row>
        <v-col cols="12" md="6" offset-md="3" sm="8" offset-sm="2">
          <v-card class="blue darken-4" dark>
            <v-card-title>
              {{ currentTitle }}
              <v-spacer> </v-spacer>
              <v-chip class="white blue--text">{{ this.step }}</v-chip>
            </v-card-title>
            <v-card-text>
              <v-form ref="form">
                <v-window v-model="step">
                  <v-window-item :value="1">
                    <v-text-field
                      filled
                      v-model="fName"
                      :rules="fNameRule"
                      label="First Name"
                    >
                    </v-text-field>
                    <v-text-field
                      filled
                      v-model="lName"
                      :rules="lNameRule"
                      label="Last Name"
                    >
                    </v-text-field>
                    <v-text-field
                      filled
                      v-model="email"
                      :rules="emailRule"
                      label="Email"
                    >
                    </v-text-field>
                  </v-window-item>
                  <v-window-item :value="2">
                    <v-text-field
                      filled
                      v-model="pass"
                      :rules="passwordRule"
                      :type="isHide ? 'text' : 'password'"
                      :append-icon="isHide ? 'mdi-eye' : 'mdi-eye-off'"
                      label="Password"
                      @click:append="isHide = !isHide"
                      value=" "
                    >
                    </v-text-field>
                    <v-text-field
                      filled
                      v-model="cpass"
                      :type="isHide1 ? 'text' : 'password'"
                      :append-icon="isHide1 ? 'mdi-eye' : 'mdi-eye-off'"
                      label="Confirm Password"
                      @click:append="isHide1 = !isHide1"
                      :rules="cpasswordRule"
                      value=" "
                    >
                    </v-text-field>
                  </v-window-item>
                  <v-window-item :value="3">
                    <v-file-input
                      @change="previewImage()"
                      placeholder="choose avatar"
                      filled
                      v-model="avatar"
                    >
                    </v-file-input>
                    <v-row class="justify-center mb-6">
                      <v-avatar size="100">
                        <img id="img" src="/manga/user.png" alt="" />
                      </v-avatar>
                    </v-row>
                  </v-window-item>
                  <v-window-item :value="4">
                    <v-card class="ma-5">
                      <span class="headline">Please Login To Continue...</span>
                    </v-card>
                  </v-window-item>
                </v-window>
              </v-form>
            </v-card-text>
            <v-card-actions>
              <v-btn class="blue darken-2">Back</v-btn>
              <v-spacer></v-spacer>
              <v-btn
                class="blue darken-2"
                :loading="loading"
                @click="step == 4 ? goLogin() : next()"
                >{{ step == 4 ? "Login" : "Next" }}</v-btn
              >
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
export default {
  data() {
    return {
      step: 1,
      fName: "",
      lName: "",
      email: "",
      pass: "",
      cpass: "",
      avatar: [],
      isHide: false,
      isHide1: false,
      loading: false,
      fNameRule: [(v) => !!v || "First Name is require"],
      lNameRule: [(v) => !!v || "Last Name is require"],
      emailRule: [
        (v) =>
          !!v ||
          /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
          "E-mail must be valid",
      ],
      passwordRule: [
        (v) => !!v || "Password is required!",
        (v) => v.length >= 4 || "Password must be greater than 4",
      ],
      cpasswordRule: [
        (v) => !!v || "Confirm Password is required!",
        (v) => v === this.pass || "Confirm Password is not match",
        (v) => v.length >= 4 || "Confirm Password must be greater than 4",
      ],
    };
  },
  computed: {
    currentTitle() {
      switch (this.step) {
        case 1:
          return "Enter Name And Email";
        case 2:
          return "Enter Password";
        case 3:
          return "Enter Avatar or Skip";
        default:
          return "Registeration Successful";
      }
    },
  },
  methods: {
    previewImage() {
      let file = this.avatar;
      if (file == null) {
        document.getElementById("img").src = "/manga/user.png";
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
    async next() {
      if (this.$refs.form.validate()) {
        this.loading = true;
        this.step++;
        this.loading = false;
        if (this.step == 4) {
          this.loading = true;
          var formData = new FormData();
          formData.append("first_name", this.fName);
          formData.append("last_name", this.lName);
          formData.append("email", this.email);
          formData.append("password", this.pass);
          formData.append("avatar", this.avatar);
          await axios
            .post("/user/index/register", formData)
            .then((resp) => {
              this.loading = false;
            })
            .catch((error) => {
              alert(error.response.data.errors.email);
            });
        }
      }
    },
    goLogin() {
      this.$router.push("/user/index/login");
    },
  },
};
</script>

<style lang="scss" scoped>
.frame {
  width: 100%;
  height: 100%;
  justify-content: center;
  align-items: center;
  display: flex;
}
</style>