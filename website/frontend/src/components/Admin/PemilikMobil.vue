<template>
    <v-main class="list">
         <h3 class="text-h4 font-weight-bold mb-8 text-center text-decoration-underline"> Data Pemilik Mobil </h3>
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

                <v-btn color="success" dark @click="dialog = true"> Tambah </v-btn>

            </v-card-title>
            <v-data-table :headers="headers" :items="pemilik_mobils" :search="search">

                <template v-slot:[`item.actions`]="{ item }"> 
                    <v-icon small class="mr-2" @click="editHandler(item)" color="primary">mdi-fountain-pen-tip</v-icon>
                    <v-icon small @click="deleteHandler(item.id_pemilik_mobil)" color="error"> mdi-trash-can </v-icon>
                </template>
            </v-data-table>
        </v-card>

        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ formTitle}} Pemilik Mobil</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-text-field v-model="form.nama_pemilik_mobil" :rules="rules.nama_pemilik_mobil" outlined dense label="Nama Pemilik Mobil" required></v-text-field>
                        <v-text-field v-model="form.no_ktp" :rules="rules.no_ktp" outlined dense label="No KTP" required></v-text-field>
                        <v-textarea label="Alamat Pemilik Mobil" :rules="rules.alamat_pemilik_mobil"  dense  auto-grow outlined rows="1" row-height="15"  v-model="form.alamat_pemilik_mobil" required></v-textarea>
                        <v-text-field v-model="form.no_telp_pemilik_mobil" :rules="rules.no_telp_pemilik_mobil" outlined dense label="No Telp Pemilik" required></v-text-field>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancel"> Cancel </v-btn>
                    <v-btn color="blue darken-1" text @click="dialogConfirmUpdate=true"> Save </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="dialogConfirm" persistent max-width="400px">
            <v-card>
                <v-card-title>
                    <span class="headline">Warning!</span>
                </v-card-title>
                <v-card-text>Are you sure to DELETE this pemilik mobil?</v-card-text>
                <v-card-action>
                    <v-spacer></v-spacer>
                     <v-btn style="justify-end" color="blue darken-1" text @click="dialogConfirm = false" > Cancel </v-btn>
                    <v-btn color="blue darken-1" text @click="deleteData"> Delete </v-btn>
                </v-card-action>
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
    name: "PemilikMobil",
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
            headers: [
                { text: "ID", value: 'id_pemilik_mobil'},
                { text: "Nama", align: "start", sortable: true, value: "nama_pemilik_mobil"},
                { text: "No KTP", value: 'no_ktp'},
                { text: "Alamat", value: 'alamat_pemilik_mobil'},
                { text: "No Telp", value: 'no_telp_pemilik_mobil'},
                { text: "Actions", value: 'actions'},
            ],
            //
            rules: {
              nama_pemilik_mobil  : [
                v => !!v || 'Nama Pemilik Mobil is required',
              ],
              no_ktp  : [
                v => !!v || 'No KTP is required',
              ],
              alamat_pemilik_mobil  : [
                v => !!v || 'Alamat Pemilik Mobil is required',
              ],
              no_telp_pemilik_mobil  : [
                v => !!v || 'No Telp Pemilik Mobil is required',
              ],
            },

            pemilik_mobil: new FormData,
            pemilik_mobils: [],
            form: {
                nama_pemilik_mobil: null,
                no_ktp: null,
                alamat_pemilik_mobil: null,
                no_telp_pemilik_mobil: null,
            },
            deleteId: '',
            editId: ''
        };
    },

    methods: {
        setForm(){
            if(this.inputType !== 'Tambah'){
                this.update();
            }else{
                this.save();
            }
        },
       
        readData() {
            var url = this.$api + '/pemilikMobil';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.pemilik_mobils = response.data.data;
            })
        },
       
        save() {
           
            this.pemilik_mobil.append('nama_pemilik_mobil', this.form.nama_pemilik_mobil);
            this.pemilik_mobil.append('no_ktp', this.form.no_ktp);
            this.pemilik_mobil.append('alamat_pemilik_mobil', this.form.alamat_pemilik_mobil);
            this.pemilik_mobil.append('no_telp_pemilik_mobil', this.form.no_telp_pemilik_mobil);
            var url = this.$api +'/pemilikMobil'
            
            this.load = true;
            this.$http.post(url, this.pemilik_mobil, {
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
                nama_pemilik_mobil : this.form.nama_pemilik_mobil,
                no_ktp: this.form.no_ktp,
                alamat_pemilik_mobil: this.form.alamat_pemilik_mobil,
                no_telp_pemilik_mobil: this.form.no_telp_pemilik_mobil,
            };
            var url = this.$api + '/pemilikMobil/' + this.editId;
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

            });
        },
        
        deleteData() {
            //menghapus data
            var url = this.$api + '/pemilikMobil/' + this.deleteId;
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
            this.editId = item.id_pemilik_mobil;
            this.form.nama_pemilik_mobil = item.nama_pemilik_mobil;
            this.form.no_ktp = item.no_ktp;
            this.form.alamat_pemilik_mobil = item.alamat_pemilik_mobil;
            this.form.no_telp_pemilik_mobil = item.no_telp_pemilik_mobil;
            this.dialog = true;
        },

        deleteHandler(id) {
            this.deleteId = id;
            this.dialogConfirm = true;
        },

        close() {
            this.dialog = false;
            this.inputType = 'Tambah';
            this.dialogConfirm = false;
            this.dialogConfirmUpdate= false,
            this.readData();
        },
        cancel() {
            this.resetForm();
            this.readData();
            this.dialog = false;
            this.dialogConfirm  = false;
            this.dialogConfirmUpdate= false,
            this.inputType = 'Tambah';
        },
        resetForm() {
            this.form = { 
                nama_pemilik_mobil: null, 
                no_ktp: null,
                alamat_pemilik_mobil: null,
                no_telp_pemilik_mobil: null,
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
