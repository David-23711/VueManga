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
              <v-row>
                <v-col cols="12" md="12">
                  <v-text-field
                    solo
                    prepend-inner-icon="person"
                    v-model="email"
                    placeholder="USER EMAIL"
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
                  >
                  </v-text-field>
                  <v-row class="pa-3">
                    <v-btn dark class="blue darken-3" @click="userSignIn"
                      >Sing In</v-btn
                    >
                  </v-row>
                </v-col>
              </v-row>
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
    };
  },
  methods: {
    async userSignIn() {
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