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
                  src="../assets/asli.png"
                  alt="logo"
                  height="300px"
                  class="center"
                />
              </div>
              <v-divider class="mx-2" vertical></v-divider>
              <div class="right-half">
                <v-card-title class="blue lighten-4 justify-center">
                    <span class="headline justify-center">Register Form</span>
                </v-card-title>
                      
                <v-form v-model="valid" ref="form">
                <br>
                 <v-text-field label="Nama" v-model="form.nama_customer" :rules="rules.nama_customer" required outlined dense ></v-text-field>
                 <v-text-field label="Alamat" v-model="form.alamat_customer" :rules="rules.alamat_customer" required outlined dense ></v-text-field>
                 <v-text-field v-model="form.tanggal_lahir" type="date" label="Tanggal Lahir" :rules="rules.tanggal_lahir" required outlined dense></v-text-field>
                 <v-select
                      v-model="form.jenis_kelamin_customer"
                      :items="['Pria', 'Wanita']"
                      label="Jenis Kelamin"
                      :rules="rules.jenis_kelamin_customer"
                      outlined dense 
                      required
                ></v-select>
                <v-text-field label="No Telp" v-model="form.no_telp_customer" :rules="rules.no_telp_customer" required outlined dense ></v-text-field>
                 <v-file-input
                      v-model="form.foto_customer"
                      accept="image/png, image/jpeg, image/bmp, pdf"
                      placeholder="Pilih Foto Anda"
                      label="Foto Customer"
                      outlined dense
                ></v-file-input>
                <v-file-input
                      v-model="form.ktp_customer"
                      accept="image/png, image/jpeg, image/bmp, pdf"
                      placeholder="Pilih Foto Anda"
                      label="KTP Customer / Kartu Pelajar"
                      outlined dense
                ></v-file-input>
                <v-file-input
                      v-model="form.sim_customer"
                      accept="image/png, image/jpeg, image/bmp, pdf"
                      placeholder="Pilih Foto Anda"
                      label="SIM Customer"
                      outlined dense
                ></v-file-input>

                <v-text-field label="Email" v-model="form.email" :rules="rules.email" required outlined dense ></v-text-field>

                  <v-layout justify-center>
                    <v-btn @click="clear" class="blue darken-3 white--text" style="margin-end:20px">Clear</v-btn>
                    <v-btn class="mr-2" @click="submit" :class="{'grey darken-1 white--text': valid, disabled: !valid,}">Submit</v-btn>
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
  left: 0px;
  right: 0px;
  font-family: "Montserrat", sans-serif;
  background-color: #B0C4DE;
 

}

.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  margin-top: 230px;
}
</style>

 <script>
export default {
  name: "RegisterCustomer",
  data() {
    return {
      load: false,
      snackbar: false,
      error_message: "",
      color: "",
      valid: false,
      rules: {
              nama_customer  : [
                v => !!v || 'Nama is required',
              ],
              alamat_customer  : [
                v => !!v || 'Alamat is required',
              ],
              tanggal_lahir: [
                v => !!v || 'Tanggal Lahir is required',
              ],
              jenis_kelamin_customer : [
                v => !!v || 'Jenis Kelamin is required',
              ],
              no_telp_customer : [
                v => !!v || 'Jenis Kelamin is required',
              ],
              email : [
                v => !!v || 'Email is required',
              ],
            },

            // mencoba : smua v-model kasih form.
            customer: new FormData,
            customers: [],
            form: {
                nama_customer: null,
                alamat_customer: null,
                tanggal_lahir: null,
                jenis_kelamin_customer:null,
                no_telp_customer:null,
                foto_customer:null,
                ktp_customer:null,
                sim_customer:null,
                email:null,
                // id_role:null,
            },
    };
  },
  methods: {
    submit() {
      if (this.$refs.form.validate()) {
        //cek apakah data yang akan dikirim sudah valid

        this.customer.append('nama_customer', this.form.nama_customer);
        this.customer.append('alamat_customer', this.form.alamat_customer);
        this.customer.append('tanggal_lahir', this.form.tanggal_lahir);
        this.customer.append('jenis_kelamin_customer', this.form.jenis_kelamin_customer);
        this.customer.append('no_telp_customer', this.form.no_telp_customer);
        this.customer.append('foto_customer', this.form.foto_customer);
        this.customer.append('ktp_customer', this.form.ktp_customer);
        this.customer.append('sim_customer', this.form.sim_customer);
        this.customer.append('email', this.form.email);
        this.customer.append('status_customer', 'Belum Terverifikasi');

        var url = this.$api +'/customer'
        this.load = true;

       

        this.$http.post(url, this.customer, {
            nama_customer: this.nama_customer,
            alamat_customer: this.alamat_customer,
            tanggal_lahir: this.tanggal_lahir,
            jenis_kelamin_customer: this.jenis_kelamin_customer,
            no_telp_customer: this.no_telp_customer,
            foto_customer: this.foto_customer,
            ktp_customer: this.ktp_customer,
            sim_customer: this.sim_customer,
            email: this.email,
            id_role: this.id_role,
          })
          .then((response) => {
            this.error_message = response.data.message;
            this.color= "green";
            this.snackbar= true;
            this.load= false;
            this.clear();
            this.$router.push({
              name: 'Login',
            });
          }).catch((error) => {
            this.error_message = error.response.data.message;
            this.color = "red";
            this.snackbar = true;
            this.load= false;
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