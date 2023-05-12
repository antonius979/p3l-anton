<template>
    <v-main class="list">
          <h3 class="text-h4 font-weight-bold mb-8 text-center text-decoration-underline"> Data Deposit Kelas </h3>

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

                <v-btn color="success" dark @click="dialog = true"> Tambah Deposit Kelas </v-btn>

            </v-card-title>
            <v-data-table :headers="headers" :items="aktivasi_tahunans" :search="search">

            </v-data-table>
        </v-card>

        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>

                <v-card-title class="blue lighten-4 justify-center">
                    <span class="headline justify-center">{{ formTitle }} Deposit Kelas</span>
                </v-card-title>

                <v-card-text>
                    <v-container >
                        <!-- untuk validasi -->
                        <v-form v-model="valid" ref="form"> 
                            
                            <v-text-field v-model="form.id_member" :rules="rules.id_member" outlined dense label="Member" required></v-text-field>
                            <v-text-field v-model="form.id_pegawai " :rules="rules.id_pegawai " outlined dense label="Pegawai" required></v-text-field>
                            <v-text-field v-model="form.id_kelas " :rules="rules.id_kelas " outlined dense label="Kelas" required></v-text-field>

                            <v-dialog
                                ref="dialog"
                                v-model="modal"
                                :return-value.sync="date"
                                persistent
                                width="290px"
                                >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                    v-model="form.berlaku"
                                    label="Berlaku"
                                    prepend-icon="mdi-calendar"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    :rules="rules.berlaku"
                                    outlined dense 
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="form.berlaku"
                                    scrollable
                                >
                                    <v-spacer></v-spacer>
                                    <v-btn
                                    text
                                    color="primary"
                                    @click="modal = false"
                                    >
                                    Cancel
                                    </v-btn>
                                    <v-btn
                                    text
                                    color="primary"
                                    @click="$refs.dialog.save(form.berlaku)"
                                    >
                                    OK
                                    </v-btn>
                                </v-date-picker>
                            </v-dialog>

                            <!-- <v-dialog
                                ref="dialog"
                                v-model="modal"
                                :return-value.sync="date"
                                persistent
                                width="290px"
                                >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                    v-model="form.masa_aktif"
                                    label="Masa Aktif"
                                    prepend-icon="mdi-calendar"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    :rules="rules.masa_aktif"
                                    outlined dense 
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="form.masa_aktif"
                                    scrollable
                                >
                                    <v-spacer></v-spacer>
                                    <v-btn
                                    text
                                    color="primary"
                                    @click="modal = false"
                                    >
                                    Cancel
                                    </v-btn>
                                    <v-btn
                                    text
                                    color="primary"
                                    @click="$refs.dialog.save(form.masa_aktif)"
                                    >
                                    OK
                                    </v-btn>
                                </v-date-picker>
                            </v-dialog> -->

                            <!-- <v-select
                                v-model="form.jenis_kelamin_driver"
                                :items="['Pria', 'Wanita']"
                                label="Jenis Kelamin"
                                :rules="rules.jenis_kelamin_driver"
                                outlined dense 
                                required
                            ></v-select> -->

                            <v-text-field v-model="form.deposit" :rules="rules.deposit" outlined dense label="Deposit Kelas" required></v-text-field>
                            <v-text-field v-model="form.total_deposit" :rules="rules.total_deposit" outlined dense label="Total Deposit" required></v-text-field>
                            

                              
                        </v-form>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancel"> Batal </v-btn>
                    <v-btn color="blue darken-1" text @click="dialogConfirmUpdate=true"> Simpan </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>


        <!-- <v-dialog v-model="dialogConfirm" persistent max-width="500px">
            <v-card>
                <v-card-title class="red accent-10 justify-center">
                    <span>PERHATIAN!</span>
                </v-card-title>
                <v-card-text style="margin-top:5%">
                    Yakin ingin menghapus akti ini?
                </v-card-text>
                
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="dialogConfirm = false">
                        Batal
                    </v-btn>
                    <v-btn color="red darken-1" text @click="deleteData">
                        Hapus
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog> -->

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
    name: "DepositKelas",
    data() {
        return {
            inputType: 'Tambah',
            load: false,
            snackbar: false,
            error_message: '',
            color: '',
            search: null,
            dialog: false,
            dialogConfirm: false,
            dialogConfirmUpdate: false,
            valid:false,
            headers: [
                { text: "ID Deposit Kelas", value: 'id_aktivasi_tahunan '},
                { text: "Nama", value: 'nama_member' , align: "start",sortable: true,},
                { text: "Nama", value: 'nama_pegawai' , align: "start",sortable: true,},
                { text: "Berlaku", value: 'tanggal_transaksi' },
                { text: "Masa Aktif", value: 'masa_aktif'},
                { text: "Deposit Kelas", value: 'deposit'},
                { text: "Total Deposit", value: 'total_deposit'},
            ],
            //
            rules: {
              id_member  : [
                v => !!v || 'Nama Member is required',
              ],
              id_pegawai   : [
                v => !!v || 'Nama Pegawai is required',
              ],
              tanggal_transaksi: [
                v => !!v || 'Tanggal is required',
              ],
            //   masa_aktif : [
            //     v => !!v || 'Masa Aktif is required',
            //   ],
              aktivasi_tahunan : [
                v => !!v || 'Aktivasi Tahunan is required',
              ],
            },
         
            depositKelas: new FormData,
            deposit_kelas: [],
            form: {
                id_member: null,
                id_pegawai: null,
                id_kelas: null,
                berlaku: null,
                deposit: null,
                total_deposit: null,
            },

            // untuk tanggal
            modal:false,
            tanggal_transaksi: new Date().toISOString().substr(0, 10),
            masa_aktif: new Date().toISOString().substr(0, 10),
            deleteId: '',
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
            var url = this.$api + '/depositKelas';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.deposit_kelas = response.data.data;
            })
        },
       
        save() {
            this.depositKelas.append('id_member', this.form.id_member);
            this.depositKelas.append('id_kelas', this.form.id_kelas);
            this.depositKelas.append('id_pegawai ', this.form.id_pegawai );
            this.depositKelas.append('deposit', this.form.deposit);
            // this.aktivasiTahunan.append('masa_aktif', this.form.masa_aktif);
            this.depositKelas.append('total_deposit', this.form.total_deposit);
            this.depositKelas.append('berlaku', this.form.berlaku);

            this.depositKelas.append('id_role', 'DepositKelas');

            var url = this.$api +'/depositKelas'
            
            this.load = true;
            this.$http.post(url, this.driver, {
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
                id_member : this.form.id_member,
                id_pegawai : this.form.id_pegawai,
                id_kelas : this.form.id_kelas,
                berlaku: this.form.berlaku,
                // masa_aktif: this.form.masa_aktif,
                deposit: this.form.deposit,
                total_deposit: this.form.total_deposit,

                id_role: 'AktivasiTahunan'
            };
            var url = this.$api + '/depositKelas/' + this.editId;
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
            })
        },
        deleteData() {
            //menghapus data
            var url = this.$api + '/depositKelas/' + this.deleteId;
            this.load = true;
            this.$http.delete(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.error_message = response.data.message;
                this.color = "green";
                this.snackbar = true;
                this.load = false;
                this.close();
                this.readData(); // baca data
                this.resetForm();
                this.inputType = 'Tambah';
            }).catch(error => {
                this.error_message = error.response.data.message;
                this.color = "red";
                this.snackbar = true;
                this.load = false;
            });
        },
        editHandler(item) {
            this.inputType = 'Ubah';
            this.editId = item.id_aktivasi_tahunan ;
            this.form.id_member  = item.id_member ;
            this.form.id_pegawai  = item.id_pegawai ;
            this.form.tanggal_transaksi = item.tanggal_transaksi;
            // this.form.masa_aktif= item.masa_aktif;
            this.form.aktivasi_tahunan = item.aktivasi_tahunan;

            this.dialog = true;
            
        },

        deleteHandler(id) {
            this.deleteId = id;
            this.dialogConfirm = true;
        },

        close() {
            this.dialog = false;
            this.inputType = 'Tambah';

            this.dialogConfirmUpdate= false;
            this.dialogConfirm = false;
            this.readData();
        },
        cancel() {
            this.resetForm();
            this.readData();
            this.dialog = false;

            this.dialogConfirmUpdate= false;
            this.dialogConfirm  = false;
            this.inputType = 'Tambah';
        },
        resetForm() {
            this.form = { 
                id_member : null,
                id_pegawai : null,
                tanggal_transaksi: null,
                masa_aktif: null,
                aktivasi_tahunan: null,
                id_role: null,
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
    },
};
</script>
