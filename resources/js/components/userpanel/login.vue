<template>
  <div class="frame">
    <v-container>
      <v-row>
        <v-col cols="12" md="4" offset-md="4">
          <v-card class="blue darken-4">
            <v-card-title class="justify-center">
              <v-avatar size="100">
                <img src="/manga/user.png" alt="" />
              </v-avatar>
            </v-card-title>
            <v-card-text class="text-center">
              <h2 class="white--text">Login</h2>
              <v-form ref="form">
                <v-row>
                  <v-col cols="12" md="12">
                    <v-text-field
                      solo
                      prepend-inner-icon="person"
                      v-model="email"
                      placeholder="USER EMAIL"
                      :rules="emailRules"
                    >
                    </v-text-field>
                    <v-text-field
                      solo
                      prepend-inner-icon="lock"
                      v-model="password"
                      placeholder="USER PASSWORD"
                      :append-icon="isClick ? 'mdi-eye' : 'mdi-eye-off'"
                      :type="isClick ? 'text' : 'password'"
                      @click:append="isClick = !isClick"
                      :rules="passRules"
                    >
                    </v-text-field>
                    <v-row class="pa-3">
                      <v-btn dark class="blue darken-3" @click="userSignIn"
                        >Sing In</v-btn
                      >
                      <v-dialog
                        transition="dialog-bottom-transition"
                        max-width="600"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <v-btn
                            text
                            class="blue--text"
                            v-on="on"
                            v-bind="attrs"
                            >Forget password ?</v-btn
                          >
                        </template>
                        <template v-slot:default="dialog">
                          <v-card class="black" dark>
                            <v-toolbar class="indigo">
                              <v-toolbar-title dark>
                                <span class="headline white--text">{{
                                  currentTitle
                                }}</span>
                              </v-toolbar-title>
                              <v-spacer></v-spacer>
                              <v-chip>{{ step }}</v-chip>
                            </v-toolbar>
                            <v-card-text class="pt-5">
                              <v-form ref="form">
                                <v-window v-model="step">
                                  <v-window-item :value="1">
                                    <v-text-field
                                      label="Email"
                                      v-model="forgetEmail"
                                      required
                                      :rules="forgetEmailRules"
                                      filled
                                      dark
                                    >
                                    </v-text-field>
                                  </v-window-item>
                                  <v-window-item :value="2">
                                    <v-text-field
                                      label="Password"
                                      required
                                      :rules="forgetpassRules"
                                      @click:append="isicon = !isicon"
                                      filled
                                      dark
                                      value=" "
                                      v-model="forgetPass"
                                      :type="isicon ? 'text' : 'password'"
                                      :append-icon="
                                        isicon ? 'mdi-eye' : 'mdi-eye-off'
                                      "
                                    >
                                    </v-text-field>
                                    <v-text-field
                                      label="Confirm Password"
                                      required
                                      :rules="forgetcpassRules"
                                      filled
                                      dark
                                      @click:append="isicon2 = !isicon2"
                                      v-model="forgetCpass"
                                      value=" "
                                      :type="isicon2 ? 'text' : 'password'"
                                      :append-icon="
                                        isicon2 ? 'mdi-eye' : 'mdi-eye-off'
                                      "
                                    >
                                    </v-text-field>
                                  </v-window-item>
                                  <v-window-item :value="3">
                                    <v-card class="color pa-10" flat>
                                      <v-row class="text-center">
                                        <v-col cols="12" md="12" sm="12">
                                          <span
                                            class="
                                              headline
                                              yellow--text
                                              font-weight-bold
                                            "
                                            >Password Change Success</span
                                          ><br />
                                          <span
                                            class="
                                              subheading
                                              white--text
                                              font-weight-bold
                                            "
                                            >Please Login To Continue</span
                                          >
                                        </v-col>
                                      </v-row>
                                    </v-card>
                                  </v-window-item>
                                </v-window>
                              </v-form>
                            </v-card-text>
                            <v-card-actions>
                              <v-btn @click="dialog.value = false">Close</v-btn>
                              <v-spacer></v-spacer>
                              <v-btn
                                v-if="step != 3"
                                :disabled="step == 1 ? true : false"
                                @click="step = step - 1"
                                >Back</v-btn
                              >
                              <v-btn
                                v-if="step != 3"
                                @click="step == 1 ? check() : next()"
                                >Next</v-btn
                              >
                            </v-card-actions>
                          </v-card>
                        </template>
                      </v-dialog>
                    </v-row>
                  </v-col>
                </v-row>
              </v-form>
            </v-card-text>
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
      email: "",
      password: "",
      isClick: false,
      isicon: false,
      isicon2: false,
      step: 1,
      userId: "",
      valid: null,
      forgetEmail: "",
      forgetPass: "",
      forgetCpass: "",
      emailRules: [(v) => !!v || "Email is required"],
      passRules: [
        (v) => !!v || "Password is required",
        (v) => v.length > 4 || "Characters must be greater than 4",
      ],
      forgetEmailRules: [
        (v) => !!v || "Email is required",
        (v) =>
          !v ||
          /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
          "E-mail must be valid",
      ],
      forgetcpassRules: [
        (v) => !!v || "Confirm Password is required",
        (v) => v.length >= 4 || "Confirm Password must be greater than 4",
      ],
      forgetpassRules: [
        (v) => !!v || "Password is required",
        (v) => v === this.forgetPass || "Confirm Password is not match",
        (v) => v.length >= 4 || "Confirm Password must be greater than 4",
      ],
    };
  },
  methods: {
    async next() {
      var formData = new FormData();
      formData.append("forgetPass", this.forgetPass);
      formData.append("forgetCpass", this.forgetCpass);
      formData.append("_method", "PUT");
      await axios
        .post(`/user/login/putPassword/${this.userId}`, formData)
        .then((resp) => {
          this.step = this.step + 1;
        });
    },
    async check() {
      var formData = new FormData();
      formData.append("forgetEmail", this.forgetEmail);
      await axios
        .post("/user/login/checkEmail", formData)
        .then((resp) => {
          this.valid = resp.data.count;
          this.userId = resp.data.data[0];
        })
        .then((resp) => {
          if (this.valid == 0) {
            alert("Email is not valid");
          } else {
            this.step = this.step + 1;
          }
        });
    },
    async userSignIn() {
      if (this.$refs.form.validate()) {
        await axios
          .post("/index/login/singIn", {
            email: this.email,
            password: this.password,
          })
          .then((resp) => {
            if (resp.data.message) {
              const Toast = Swal.mixin({
                toast: true,
                position: "top-right",
                color: "white",
                background: "red",
                timer: 1500,
                timerProgressBar: true,
                showConfirmButton: false,
              });
              Toast.fire({
                icon: "error",
                title: resp.data.message,
              });
            } else {
              this.$store.dispatch("setUser", resp.data);
              this.$router.back();
              const Toast = Swal.mixin({
                toast: true,
                position: "top-right",
                color: "white",
                background: "green",
                timer: 1500,
                timerProgressBar: true,
                showConfirmButton: false,
              });
              Toast.fire({
                icon: "success",
                title: "Thank For Sign Up",
              });
            }
          });
      }
    },
  },
  computed: {
    currentTitle() {
      switch (this.step) {
        case 1:
          return "Enter Your Email";
        case 2:
          return "Enter New Password";
        default:
          return "Success";
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.frame {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>