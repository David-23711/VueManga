<template>
  <div class="rframe">
    <v-container class="ritem">
      <v-row>
        <v-col cols="12" md="6" offset-md="3">
          <v-form ref="form">
            <v-card class="color darken-3 pa-6">
              <v-card-title>
                <h4 class="yellow--text">{{ currentTitle }}</h4>
                <v-spacer></v-spacer>
                <v-chip>{{ step }}</v-chip>
              </v-card-title>
              <v-window v-model="step">
                <v-window-item :value="1">
                  <v-text-field
                    label="Name"
                    v-model="form.name"
                    prepend-icon="assignment_ind"
                    color="yellow"
                    required
                    :rules="errors.nameError"
                    dark
                  >
                  </v-text-field>
                  <v-text-field
                    label="Email"
                    v-model="form.email"
                    prepend-icon="mail"
                    color="yellow"
                    required
                    :rules="errors.emailError"
                    dark
                  >
                  </v-text-field>
                </v-window-item>
                <v-window-item :value="2">
                  <v-text-field
                    v-model="form.pass"
                    dark
                    label="Password"
                    :type="isClick ? 'text' : 'password'"
                    :append-icon="isClick ? 'mdi-eye' : 'mdi-eye-off'"
                    prepend-icon="password"
                    @click:append="isClick = !isClick"
                    color="yellow"
                    value=""
                    required
                    :rules="errors.passError"
                  >
                  </v-text-field>
                  <v-text-field
                    v-model="form.cpass"
                    dark
                    label="Confirm_Password"
                    :type="isClick2 ? 'text' : 'password'"
                    :append-icon="isClick2 ? 'mdi-eye' : 'mdi-eye-off'"
                    prepend-icon="password"
                    @click:append="isClick2 = !isClick2"
                    color="yellow"
                    value=""
                    required
                    :rules="errors.cpassError"
                  >
                  </v-text-field>
                </v-window-item>
                <v-window-item :value="3">
                  <v-file-input
                    prepend-icon="account_circle"
                    label="Choose Avatar"
                    @change="showimg"
                    v-model="form.input"
                    color="yellow"
                    dark
                  >
                  </v-file-input>
                  <v-row justify="center" align="center" class="pa-5">
                    <v-avatar size="100">
                      <img src="/manga/user.png" alt="" id="img" />
                    </v-avatar>
                  </v-row>
                </v-window-item>

                <v-window-item :value="4">
                  <v-text-field
                    label="Address"
                    color="yellow"
                    dark
                    v-model="form.address"
                    required
                    :rules="errors.addressError"
                  >
                  </v-text-field>
                  <v-text-field
                    label="Phone"
                    color="yellow"
                    dark
                    v-model="form.phone"
                    required
                    :rules="errors.phoneError"
                  >
                  </v-text-field>
                </v-window-item>
                <v-window-item :value="5">
                  <v-card class="color pa-10" flat>
                    <v-row class="text-center">
                      <v-col cols="12" md="12" sm="12">
                        <span class="headline yellow--text font-weight-bold"
                          >Account Created Successfully</span
                        ><br />
                        <span class="subheading white--text font-weight-bold"
                          >Please Login To Continue</span
                        >
                      </v-col>
                    </v-row>
                  </v-card>
                </v-window-item>
              </v-window>

              <v-card-actions>
                <v-btn
                  text
                  class="pr-5"
                  dark
                  @click="step--"
                  :disabled="step == 1"
                >
                  <v-icon> chevron_left </v-icon>
                  <span>Back</span>
                </v-btn>
                <v-btn
                  text
                  dark
                  @click="step == 5 ? goLogin() : nextStep()"
                  v-if="step != 4"
                >
                  <span>{{ step == 5 ? "Login" : "Continue" }}</span>
                  <v-icon> {{ step == 5 ? "login" : "chevron_right" }} </v-icon>
                </v-btn>
                <v-btn
                  :loading="loading"
                  v-if="step == 4"
                  text
                  @click="insertAdmin"
                  dark
                >
                  <span>Continue</span>
                  <v-icon>chevron_right</v-icon>
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-form>
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
      isClick: false,
      isClick2: false,
      isCreated: false,
      loading: false,
      file: null,
      form: {
        name: "",
        email: "",
        pass: "",
        cpass: "",
        input: [],
        phone: "",
        address: "",
      },
      errors: {
        nameError: [(v) => !!v || "Name is required!"],
        emailError: [
          (v) => !!v || "Email is required!",
          (v) =>
            !v ||
            /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
            "E-mail must be valid",
        ],
        passError: [
          (v) => !!v || "Password is required!",
          (v) => v.length >= 4 || "Password must be greater than 4",
        ],
        cpassError: [
          (v) => !!v || "Confirm Password is required!",
          (v) => v === this.form.pass || "Confirm Password is not match",
          (v) => v.length >= 4 || "Confirm Password must be greater than 4",
        ],
        phoneError: [(v) => !!v || "Phone is required"],
        addressError: [(v) => !!v || "Address is required"],
      },
    };
  },
  computed: {
    //for switch title when active window to next
    currentTitle() {
      switch (this.step) {
        case 1:
          return "Sign up";
        case 2:
          return "Choose Password";
        case 3:
          return "Choose Avatar";
        case 4:
          return "Address and Phone";
        case 5:
          return "Account Created";
        default:
          return "Account Created";
      }
    },
  },
  methods: {
    //for show image
    showimg() {
      this.file = this.form.input;
      if (this.file == null) {
        img.src = "/manga/user.png";
      } else {
        var reader = new FileReader();
        reader.onload = (e) => {
          var result = reader.result;
          var img = document.getElementById("img");
          img.src = result;
        };
        reader.readAsDataURL(this.file);
      }
    },
    //for navigate to login page
    goLogin() {
      this.$router.push("/admin/login");
    },
    //for activate next window
    nextStep() {
      // if(this.$refs.form.validate())
      // {
      //     this.step=this.step+1;
      // }
      this.step = this.step + 1;
    },
    //for insert admin to database
    async insertAdmin() {
      if (this.$refs.form.validate()) {
        this.loading = true;
        var formData = new FormData();
        formData.append("name", this.form.name);
        formData.append("email", this.form.email);
        formData.append("password", this.form.pass);
        formData.append("avatar", this.form.input);
        formData.append("phone", this.form.phone);
        formData.append("address", this.form.address);
        await axios.post("/admin/register/addAdmin", formData).then((resp) => {
          this.loading = false;
          this.step++;
        });
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.rframe {
  display: flex;
  width: 100%;
  height: 100%;
  justify-content: center;
  align-items: center;
  background: url("/manga/wall.jpg");
  background-size: 100% 100%;
  background-repeat: no-repeat;
}
.color {
  background: linear-gradient(rgb(110, 107, 107), rgb(31, 31, 87));
}
</style>