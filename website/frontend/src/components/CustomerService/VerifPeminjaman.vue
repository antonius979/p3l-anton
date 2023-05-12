<template>
    <v-main class="list">
          <h3 class="text-h4 font-weight-bold mb-8 text-center text-decoration-underline"> Verifikasi Peminjaman </h3>

        <v-card>
            <v-card-title>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details>
                </v-text-field>

                <v-spacer></v-spacer>


            </v-card-title>
            <v-data-table :headers="headers" :items="peminjamans" :search="search">
                 

                <template v-slot:[`item.actions`]="{ item }"> 
                    <v-icon small class="mr-2" @click="editHandler(item)" color="primary">mdi-fountain-pen-tip</v-icon>
                </template>

            </v-data-table>
        </v-card>

        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>

                <v-card-title class="red lighten-4 justify-center">
                    <span class="headline justify-center">{{ formTitle }} Peminjaman</span>
                </v-card-title>

                <v-card-text>
                    <v-container >
                        <!-- untuk validasi -->
                        <v-form v-model="valid" ref="form"> 

                               <v-text-field v-model="form.nama_pegawai" outlined dense label="Nama Pegawai" required readonly></v-text-field>

                               <v-text-field v-model="form.nama_customer" outlined dense label="Nama Customer" required readonly></v-text-field>

                               <v-select v-model="form.jenis_peminjaman" :items="itemsJenis" item-text="text" item-value="value" label="Jenis Peminjaman" outlined dense persistent-hint return-object single-line readonly></v-select>

                               <v-select v-model="form.nama_mobil" :items="itemsMobil" item-text="nama_mobil" item-value="id_mobil" label="Nama Mobil" outlined dense persistent-hint return-object single-line readonly></v-select>

                               <v-select v-model="form.nama_driver" v-if="form.jenis_peminjaman == 'Mobil + Driver'" :items="itemsDriver" item-text="nama_driver" item-value="id_driver" label="Nama Driver" outlined dense persistent-hint return-object single-line></v-select>

                               <v-text-field v-model="form.tanggal_transaksi" type="datetime-local" label="Tanggal Transaksi"  outlined dense readonly></v-text-field>

                               <v-text-field v-model="form.tanggal_mulai_sewa
                               " type="datetime-local" label="Tanggal Mulai Sewa"  outlined dense readonly></v-text-field>

                               <v-text-field v-model="form.tanggal_selesai_sewa" type="datetime-local" label="Tanggal Selesai Sewa"  outlined dense readonly></v-text-field>

                               <v-select
                                    v-model="form.status"
                                    :items="['Belum Terverifikasi', 'Sudah Terverifikasi']"
                                    label="Status"
                                    :rules="rules.status"
                                    outlined dense
                                    required
                               ></v-select>
                              
                        </v-form>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancel"> Cancel </v-btn>
                    <v-btn color="blue darken-1" text @click="dialogConfirmUpdate=true"> Save </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

         <v-dialog v-model="dialogConfirmUpdate" persistent max-width="500px">
            <v-card>
                <v-card-title class="blue lighten-4 justify-center">
                    <span>PERHATIAN!</span>
                </v-card-title>
                <v-card-text style="margin-top:5%">
                    Anda yakin menyimpan data ini?
                </v-card-text>
                
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="dialogConfirmUpdate = false">
                        Tidak
                    </v-btn>
                    <v-btn color="red darken-1" text @click="setForm">
                        Ya
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>


        <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>{{ error_message }}</v-snackbar>
    </v-main>
</template>

<script>
export default {
    name: "Peminjaman",
    data() {
        return {
            inputType: 'Tambah',
            load: false,
            snackbar: false,
            error_message: '',
            color: '',
            search: null,
            dialog: false,
            dialogConfirmUpdate: false,
            dialogConfirm: false,
            valid:false,
            itemsMobil: [],
            itemsDriver: [],
            headers: [
                { text: "#", value: 'id_transaksi'},
                { text: "Nama", value: 'customer.nama_customer'},
                { text: "Nama Mobil", value: 'mobil.nama_mobil' , align: "start",sortable: true,},
                { text: "Jenis Peminjaman", value: 'jenis_peminjaman'},
                { text: "Nama Driver", value: 'driver.nama_driver'},
                { text: "Tanggal Transaksi", value: 'tanggal_transaksi'},
                { text: "Tanggal Mulai Sewa", value: 'tanggal_mulai_sewa' },
                { text: "Tanggal Akhir Sewa", value: 'tanggal_selesai_sewa'},
                { text: "Status Transaksi", value: 'status_transaksi'},
                { text: "Actions", value: 'actions'},
            ],
            //
            rules: {
              status  : [
                v => !!v || 'Status tidak boleh kosong',
              ],
              nama_pegawai  : [
                v => !!v || 'Nama Pegawai  tidak boleh kosong',
              ],
              nama_customer  : [
                v => !!v || 'Nama Customer tidak boleh kosong',
              ],
              nama_mobil  : [
                v => !!v || 'Nama Mobil tidak boleh kosong',
              ],
              jenis_peminjaman  : [
                v => !!v || 'Jenis Peminjaman tidak boleh kosong',
              ],
              
            },

            itemsJenis: [
                {
                    text: "Mobil",
                    value: "Mobil",
                },
                {
                    text: "Mobil + Driver",
                    value: "Mobil + Driver",
                }
            ],
         
            peminjaman: new FormData,
            peminjamans: [],
            form: {
                nama_pegawai : localStorage.getItem('nama_pegawai'),
                nama_customer : '',
                jenis_peminjaman : '',
                nama_mobil : '',
                id_driver : '',
                nama_driver : '',
                tanggal_transaksi : '',
                tanggal_mulai_sewa : '',
                tanggal_selesai_sewa: '',
                status : '',
            },
            editId: '',
        };
    },

    methods: {
        setForm(){
        if(this.$refs.form.validate()){
            if(this.inputType !== 'Tambah'){
                this.update();
            }else{
                this.save();
            }
        }
            
        },
      
        readData() {
            var url = this.$api + '/transaksiVerifPinjam';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.peminjamans = response.data.data;
            })
        },


        readDataMobil() {
            var url = this.$api + '/mobil';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.itemsMobil = response.data.data;
            })
        },

        readDataDriver() {
           var url = this.$api + '/getDriver';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.itemsDriver = response.data.data;
            }) 
        },
      
        save() {
            this.peminjaman.append('status', this.form.status);

            var url = this.$api +'/transaksiPeminjaman'
            
            this.load = true;
            this.$http.post(url, this.peminjaman, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token'),
                }
            }).then(response=> {
                this.error_message = response.data.message;
                this.color = "green";
                this.snackbar= true;
                this.load= true;
                this.close();
                this.readData(); // baca data
                this.resetForm();
            }).catch(error => {
                this.error_message = error.response.data.message;
                this.color= "red";
                this.snackbar= true;
                this.load = false;
            });
        },
     
        update() {

            let newData = {
                id_pegawai: localStorage.getItem('id_pegawai'),                
                id_mobil : this.form.nama_mobil.id_mobil ?? '',
                jenis_peminjaman : this.form.jenis_peminjaman,
                id_driver : this.form.nama_driver.id_driver ?? '',
                tanggal_transaksi : this.form.tanggal_transaksi,
                tanggal_mulai_sewa : this.form.tanggal_mulai_sewa,
                tanggal_selesai_sewa : this.form.tanggal_selesai_sewa,
                status_transaksi: this.form.status,
            };
            var url = this.$api + '/transaksi/' + this.editId;
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
                this.close();
                this.readData(); // baca data
                this.resetForm();
                this.inputType = 'Tambah';
            }).catch(error => {
                this.error_message = error.response.data.message;
                this.color= 'red';
                this.snackbar = true;
                this.load = false;
                this.close();
                this.readData(); // baca data
                this.resetForm();
            })
        },
        
        editHandler(item) {
            this.inputType = 'Ubah';
            this.editId = item.id_transaksi;
            this.form.nama_pegawai = localStorage.getItem('nama_pegawai');
            this.form.nama_customer = item.customer.nama_customer;
            this.form.nama_mobil = {
                id_mobil : item.mobil.id_mobil,
                nama_mobil : item.mobil.nama_mobil,
            },
            this.form.jenis_peminjaman = item.jenis_peminjaman;
            if(item.driver !== null) {
                this.form.nama_driver = {
                    id_driver : item.driver.id_driver,
                    nama_driver : item.driver.nama_driver,
                };
            }
            this.form.tanggal_transaksi = item.tanggal_transaksi;
            this.form.tanggal_mulai_sewa = item.tanggal_mulai_sewa;
            this,this.form.tanggal_selesai_sewa = item.tanggal_selesai_sewa;
            this.form.status = item.status_transaksi;
            this.dialog = true;
        },

        close() {
            this.dialog = false;
            this.inputType = 'Tambah';
            this.dialogConfirmUpdate = false,
            this.dialogConfirm = false;
            this.readData();
        },
        cancel() {
            this.resetForm();
            this.readData();
            this.dialog = false;
            this.dialogConfirmUpdate =false,
            this.dialogConfirm  = false;
            this.inputType = 'Tambah';
        },
        resetForm() {
            this.form = { 
                id_customer: null,
                status:null,
            };
        },

    },
    computed: {
        formTitle() {
            return this.inputType;
        },
    },
    mounted() {
        this.readData();
        this.readDataMobil();
        this.readDataDriver();
    },
};
</script>
