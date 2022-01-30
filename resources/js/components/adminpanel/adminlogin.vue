<template>
  <div class="lframe">
    <v-row>
      <v-col cols="12" md="4" offset-md="4">
        <v-card class="bgColor pa-5 rounded-lg" :rounded="true" dark>
          <v-card-title class="justify-center">
            <h4>Login Form</h4>
          </v-card-title>
          <v-card-text>
            <v-form ref="form">
              <v-text-field
                filled
                label="Email"
                v-model="admin.email"
                color="yellow"
                required
                :rules="emailRules"
              >
              </v-text-field>
              <v-text-field
                filled
                label="Password"
                v-model="admin.password"
                color="yellow"
                :rules="passRules"
                value=""
                :type="isClick ? 'text' : 'password'"
                :append-icon="isClick ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append="isClick = !isClick"
                @keyup.enter="signIn"
              >
              </v-text-field>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-row class="text-center pa-5">
              <v-col cols="12" class="pb-5">
                <v-row>
                  <v-btn
                    outlined
                    color="yellow"
                    @click="signIn"
                    :loading="loading1"
                    >Sign In</v-btn
                  >
                </v-row>
              </v-col>
              <v-col cols="12" class="pb-5">
                <v-row>
                  <span>If you don't have account,</span>
                </v-row>
              </v-col>
              <v-col cols="12">
                <v-row>
                  <v-btn class="rColor" to="/admin/register">Register</v-btn>
                </v-row>
              </v-col>
              <v-col cols="12" class="pb-5">
                <v-row class="pt-2">
                  <v-dialog
                    transition="dialog-bottom-transition"
                    max-width="600"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn text class="blue--text" v-on="on" v-bind="attrs"
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
              </v-col> </v-row
            ><br />
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      step: 1,
      isClick: false,
      loading1: false,
      isicon: false,
      isicon2: false,
      valid: null,
      adminId: null,
      admin: {
        email: "",
        password: "",
      },
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
  methods: {
    async next() {
      var formData = new FormData();
      formData.append("forgetPass", this.forgetPass);
      formData.append("forgetCpass", this.forgetCpass);
      formData.append("_method", "PUT");
      await axios
        .post(`/admin/login/putPassword/${this.adminId}`, formData)
        .then((resp) => {
          this.step = this.step + 1;
        });
    },
    async check() {
      var formData = new FormData();
      formData.append("forgetEmail", this.forgetEmail);
      await axios
        .post("/admin/login/checkEmail", formData)
        .then((resp) => {
          this.valid = resp.data.count;
          this.adminId = resp.data.data[0];
        })
        .then((resp) => {
          if (this.valid == 0) {
            alert("Email is not valid");
          } else {
            this.step = this.step + 1;
          }
        });
    },
    async signIn() {
      if (this.$refs.form.validate()) {
        this.loading1 = true;
        var formData = new FormData();
        formData.append("email", this.admin.email);
        formData.append("password", this.admin.password);
        await axios
          .post("/admin/login/accept", formData)
          .then((resp) => {
            this.loading1 = false;
            this.$store.dispatch("setAdminData", resp.data);
            const Toast = Swal.mixin({
              position: "top-right",
              toast: true,
              iconColor: "white",
              background: "#34cb5d",
              color: "white",
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true,
            });
            Toast.fire({
              title: "Success",
              icon: "success",
            });
          })
          .then((resp) => {
            this.$router.push("/admin/home");
          })
          .catch((error) => {
            console.log(error.response.status);
            if (error.response.status == 500) {
              this.loading1 = false;
              let Toast = Swal.mixin({
                position: "top-right",
                toast: true,
                iconColor: "white",
                background: "#f2210d",
                color: "white",
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
              });
              Toast.fire({
                title: "Something Went Wrong (Status Code 500)",
                icon: "error",
              });
            }
          });
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.lframe {
  justify-content: center;
  align-items: center;
  display: flex;
  width: 100%;
  height: 100%;
}
.bgColor {
  background: linear-gradient(rgb(22, 22, 22), rgb(0, 0, 0));
  color: white;
}
.rColor {
  background: linear-gradient(rgb(255, 136, 0), gold) !important;
}
</style>