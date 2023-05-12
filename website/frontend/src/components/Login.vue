<template>
  <main>
    <v-container fluid fill-height class="posisinya gradienMerah2">
      <v-layout flex align-center justify-center>
        <v-card
          style="
            padding: 30px 40px 10px 0px;
            border-radius: 20px;
            border: transparent;
          "
          elevation="24"
        >
          <div class="centered">
            <div class="flexbox">
              <div class="left-half">
                <img
                  src="../assets/gofit.png"
                  alt="logo"
                  height="230px"
                  class="center"
                />
              </div>
              <v-divider class="mx-2" vertical></v-divider>
              <div class="right-half">
                <v-card-title class="blue lighten-4 justify-center">
                    <span class="headline justify-center">Login Form</span>
                </v-card-title>
               
                <br />
                <br/>
                      
                <v-form v-model="valid" ref="form">
                 <v-text-field prepend-inner-icon="mdi-account" label="Username" v-model="username" :rules="usernameRules" required ></v-text-field>
                  <v-text-field prepend-inner-icon="mdi-key" label="Password" v-model="password" :type="passwordShow?'text': 'password'" :rules="passwordRules" required
                  :append-icon="passwordShow ?'mdi-eye': 'mdi-eye-off'" @click:append="passwordShow = !passwordShow"></v-text-field>
                  <v-layout justify-center>
                    <v-btn @click="clear" class="blue darken-3 white--text" style="margin-end:20px">Clear</v-btn>
                    <v-btn class="mr-2" @click="login" :class="{'grey darken-1 white--text': valid, disabled: !valid,}">Login</v-btn>
                  </v-layout>
                </v-form>
              </div>
            </div>
          </div>
        </v-card>
      </v-layout>
      <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
        {{ error_message }}
      </v-snackbar>
    </v-container>
  </main>
</template>

 <style scoped>
.posisinya {
  position: absolute;
  left: 0px;
  right: 0px;
  font-family: "Montserrat", sans-serif;
  background-color: #B0C4DE;


}

.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  margin-top: 15px;
}
</style>

 <script>
export default {
  name: "Login",
  data() {
    return {
      load: false,
      snackbar: false,
      error_message: "",
      color: "",
      valid: false,
      passwordShow:false,
      password: "",
      posisi: "",
      passwordRules: [(v) => !!v || "Password tidak boleh kosong"],
      username: "",
      usernameRules: [(v) => !!v || "E-mail tidak boleh kosong"],
      
    };
  },
  methods: {
    login() {
      if (this.$refs.form.validate()) {
        //cek apakah data yang akan dikirim sudah valid
        this.load = true;
        this.$http.post(this.$api + "/login", {
            username: this.username,
            password: this.password,
          })
          .then((response) => {
            if(response.data.data.id_customer !=null){
              localStorage.setItem('id_customer', response.data.data.id_customer);
              localStorage.setItem('email', response.data.data.email);
              localStorage.setItem('nama_customer', response.data.data.nama_customer);
            }else if(response.data.data.id_pegawai !=null){
              localStorage.setItem('id_pegawai', response.data.data.id_pegawai);
              localStorage.setItem('username', response.data.data.username);
              localStorage.setItem('id_role', response.data.data.id_role);
               localStorage.setItem('nama_pegawai', response.data.data.nama_pegawai);
            }else{
              return false;
            }

            this.error_message = response.data.message;
            this.color = "green";
            this.snackbar = true;
            this.load = false;
            this.clear();
            if(localStorage.getItem('id_role') == 2){
                  this.$router.push({
                  name: 'DashboardLayoutAdmin',
              });
           }else if(localStorage.getItem('id_role') == 1){
                  this.$router.push({
                  name: 'DashboardLayoutManager',
          });
          }else if(localStorage.getItem('id_role') == 1){
                  this.$router.push({
                  name: 'DashboardLayoutKasir',
          });
          }else if(localStorage.getItem('id_role') == 3){
                  this.$router.push({
                  name: 'DashboardLayoutCS',
          });
          }else if(response.data.data.id_customer != null){
            this.$router.push({
                  name: 'DashboardLayoutCustomer',
          });
          }else{
            this.$router.push({
              name: 'Dashboard',
            })
          }
          }).catch((error) => {
            this.error_message = error.response.data.message;
            this.color = "red";
            this.snackbar = true;
            localStorage.removeItem("token");
            this.load = false;
          });
      }
    },

    clear() {
      this.$refs.form.reset()
    },
    
  },
};
</script> 

<style scoped>
.centered {
  display: grid;
  place-items: center;

  resize: both;
  overflow: auto;
}

.flexbox {
  display: flex;
  flex-direction: row;
  font-family: "Montserrat", sans-serif;
  width: 50vw;
}
.left-half {
  flex: 30%;
  padding: 1rem;
}

.right-half {
  flex: 70%;
  padding: 1rem;
}
</style>