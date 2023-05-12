<template>
  <v-main>
    <v-container>
      <v-container>
        <!-- Customer -->
        <v-row >
          <div class="kotak_kartu">
            <p class="txtJudul">PROFIL CUSTOMER</p>
            <br>
            <v-row style="padding:0 100px 0 20px">
              <v-col md="7">
                <p class="txtnama">{{ customer.nama_customer }}</p>
                <p class="txtcustomer">CUSTOMER</p>
                <p class="txtidcustomer">{{ customer.id_customer }}</p>
                <p class="txtnotelp">No HP : {{ customer.no_telp_customer }}</p>
                <p class="txtalamat">Alamat : {{ customer.alamat_customer }}</p>
                <p class="txtemail">Email : {{ customer.email }}</p>
                <br>
                    <v-btn class="mr-2" @click="editHandler(customer)" style="color: rgb(90, 58, 160); font-weight: 700 ">Edit</v-btn>
              </v-col>
              <v-col md="5">
                <img class="rounded-circle" :src=" $image + '/source_fotoCustomer/' + customer.foto_customer" width="250" height="250">
              </v-col>
            </v-row>
          </div>
        </v-row>
      </v-container>
    </v-container>


     <v-dialog v-model="dialog" persistent max-width="600px">
          <v-card>

                <v-card-title class="red lighten-4 justify-center">
                    <span class="headline justify-center">Update Profil</span>
                </v-card-title>

                <v-card-text>
                    <v-container >
                        <!-- untuk validasi -->
                        <v-form v-model="valid" ref="form"> 

                    <v-text-field filled v-model="form.nama_customer" label="Nama" outlined dense required></v-text-field>
                    <v-text-field filled v-model="form.email" label="Email"  outlined dense required></v-text-field>
                    <v-text-field filled v-model="form.alamat_customer" label="Alamat"  outlined dense required></v-text-field>
                    <v-text-field type="date" filled v-model="form.tanggal_lahir_customer" label="Tanggal Lahir"  outlined dense required></v-text-field>
                    <v-select filled :items="jenisKelamin" v-model="form.jenis_kelamin_customer"
                        label="Jenis Kelamin" item-value="value" item-text="text"  outlined dense required>
                    </v-select>
                    <v-text-field filled v-model="form.no_telp_customer" label="Nomor Telepon"  outlined dense required></v-text-field>
                    <v-text-field filled type="password" v-model="form.password" label="Password" outlined dense required></v-text-field>
                     <v-file-input
                                v-model="form.foto_customer"
                                accept="image/png, image/jpeg, image/bmp, pdf"
                                placeholder="Masukan foto"
                                label="Foto"
                                outlined dense
                    ></v-file-input>
                    <v-select filled v-model="selectStatusCustomer"
                        :items="itemsStatusCustomer" item-text="text" item-value="value" label="Status Customer"
                        persistent-hint return-object single-line readonly outlined dense >
                    </v-select>
                              
                        </v-form>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancel">Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="setForm">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

  </v-main>

</template>
<script>
  export default {
    data() {
      return {
        customer: '',
         selectStatusCustomer: '',
                form: {
                    nama_customer: '',
                    email: '',
                    alamat_customer: '',
                    tanggal_lahir_customer: '',
                    jenis_kelamin_customer: '',
                    no_telp_customer: '',
                    password: '',
                    foto_customer: '',
                },
                jenisKelamin: [{
                        text: "Pria",
                        value: "Pria"
                    },
                    {
                        text: "Wanita",
                        value: "Wanita"
                    },
                ],
                itemsStatusCustomer: [{
                        text: "Belum Terverifikasi",
                        value: "Belum Terverifikasi"
                    },
                    {
                        text: "Sudah Terverifikasi",
                        value: "Sudah Terverifikasi"
                    }
                ],
                load: false,
                snackbar: false,
                error_message: '',
                color: '',
                dialog: false,
                isDisabled: false,
                deleteId: '',
                editId: ''
      };
    },

    methods : {

        setForm() {
          if(this.$refs.form.validate()){
            if(this.inputType !== 'Tambah') {
              this.update();
            } else {
              this.save();
            }
          }
        },

        save() {
          this.customer.append('nama_customer', this.form.nama_customer);
          this.customer.append('jenis_kelamin_customer', this.form.jenis_kelamin_customer
          );
          this.customer.append('tanggal_lahir', this.form.tanggal_lahir_customer);
          this.customer.append('email', this.form.email);
          this.customer.append('no_telp_customer', this.customer.no_telp_customer);
          this.customer.append('alamat_customer', this.form.alamat_customer);
          this.customer.append('password', this.form.password);

          var url = this.$api + '/customer';
          this.load = true;
          this.$http.post(url, this.customer, {
             headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token'),
                }
          }).then(response => {
            this.error_message = response.data.message;
            this.color = "green";
            this.snackbar = true;
            this.load = true;
            this.close();
            this.readData();
            this.resetForm();
          }).catch(error => {
            this.error_message = error.response.data.message;
            this.color = "red";
            this.snackbar = true;
            this.load = false;
          });
        },

        readData() {
          var url =  this.$api + '/customer/' + localStorage.getItem('id_customer');
          this.load = true;
          this.$http.get(url, {
             headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
             }
          }).then(response => {
            this.customer = response.data.data;
          })
        },

        update() {
               let newData = {
                nama_customer : this.form.nama_customer,
                email: this.form.email,
                alamat_customer: this.form.alamat_customer,
                tanggal_lahir: this.form.tanggal_lahir_customer,
                jenis_kelamin_customer: this.form.jenis_kelamin_customer,
                no_telp_customer: this.form.no_telp_customer,
                password: this.form.password,                

            };
            var url = this.$api + '/customer/' + localStorage.getItem('id_customer');
            this.load = true;
            this.$http.put(url, newData, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.error_message = response.data.message;
                this.color = 'green';
                this.snackbar = true;
                this.load = false;
                this.readData(); //mengambil data
                this.close();
                this.inputType = 'Tambah';
            }).catch(error => {
                this.error_message = error.response.data.message;
                this.color= 'red';
                this.snackbar = true;
                this.load = false;
            })
            // khusus gambar
         if(this.form.foto_customer!=null){
                let item = new FormData();
                item.append('foto_customer',this.form.foto_customer);
                url = this.$api + '/updateFotoCustomer/' + localStorage.getItem('id_customer');
                this.load = true
                this.$http.post(url, item, {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                }).then(response => {
                    this.error_message=response.data.message;
                    this.color="green"
                    this.snackbar=true;
                    this.close();
                    this.readData(); //mengambil data
                    this.resetForm();
                }).catch(error => {
                    this.error_message=error.response.data.message;
                    this.color="red"
                    this.snackbar=true;
                    this.load = false;
                })
            }
        },
            editHandler(item) {
                this.editId = item.id_customer;
                this.form.nama_customer = item.nama_customer;
                this.form.email = item.email;
                this.form.alamat_customer = item.alamat_customer;
                this.form.tanggal_lahir_customer = item.tanggal_lahir;
                this.form.jenis_kelamin_customer = item.jenis_kelamin_customer;
                this.form.no_telp_customer = item.no_telp_customer;
                this.selectStatusCustomer = item.status_customer;
                this.dialog = true;
                this.inputType = 'Ubah';
            },
            close() {
                this.dialog = false;
                this.form.nama_customer = this.customers.nama_customer;
                this.form.alamat_customer = this.customers.alamat_customer;
                this.form.tanggal_lahir_customer = this.customers.tanggal_lahir;
                this.form.jenis_kelamin_customer = this.customers.jenis_kelamin_customer;
                this.form.no_telp_customer = this.customers.no_telp_customer;
                this.form.password = this.customers.password;
            },
            cancel() {
                this.dialog = false;
            }
        },

    mounted() {
      if(localStorage.getItem('id_customer') != null) {
        this.$http.get(this.$api + '/customer/' + localStorage.getItem('id_customer'))
          .then(response => {
            this.customer = response.data.data;
          }).catch(error => {
            console.log(error)
          })
      } 
    }
    
  }
</script>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@800&family=Poppins:wght@700&display=swap');
  @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@300&display=swap');

  .txtnama {
    font-family: 'Manrope', sans-serif;
    font-size: 17px;
    color: rgb(90, 58, 160);;
    text-align: left;
    margin-top: 20px;
    text-transform: uppercase;
    font-weight: 800;
  }

  .txtcustomer {
    font-family: 'Manrope', sans-serif;
    font-size: 15px;
    color: rgb(90, 58, 160);;
    text-align: left;
    margin-top: 20px;
    text-transform: uppercase;
    font-weight: 800;
  }

  .txtidcustomer {
    font-family: 'Manrope', sans-serif;
    font-size: 17px;
    color: rgb(90, 58, 160);;
    text-align: left;
    text-transform: uppercase;
    font-weight: 800;
  }

  .txtJudul {
    font-family: 'Manrope', sans-serif;
    font-size: 20px;
    color: rgb(90, 58, 160);;
    padding-top: 20px;
    text-align: center;
    font-weight: 800;
  }

  .txtnotelp {
    font-family: 'Manrope', sans-serif;
    font-size: 15px;
    color: rgb(90, 58, 160);;
    text-align: left;
    margin-top: 20px;
    font-weight: 800;
  }

  .txtalamat {
    font-family: 'Manrope', sans-serif;
    font-size: 15px;
    color: rgb(90, 58, 160);
    text-align: left;
    font-weight: 800;
  }

  .txtemail {
    font-family: 'Manrope', sans-serif;
    font-size: 15px;
    color: rgb(90, 58, 160);;
    text-align: left;
    font-weight: 800;
  }

  .txtDashboard {
    font-family: 'Poppins', sans-serif;
    font-size: 60px;
    margin-top: -50px;
  }

  .kotak_kartu {
    width: 600px;
    height: 380px;
    background-color:  #B0C4DE;
    border-radius: 20px;
  }

  .kotaklenght p:first-child {
    font-family: 'Manrope', sans-serif;
    color: #f0a500;
  }

  .hiasanKiri {
    position: fixed;
    bottom: 0;
    margin-left: -30px;

  }

  .v-application p {
    margin-bottom: 0 !important;
  }
</style>