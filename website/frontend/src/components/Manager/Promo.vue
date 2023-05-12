<template>
    <v-main class="list">
         <h3 class="text-h4 font-weight-bold mb-8 text-center text-decoration-underline"> Data Promo </h3>
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
            <v-data-table :headers="headers" :items="promos" :search="search">
                 
                <!-- Untuk mengubah warna status -->
                 <template v-slot:[`item.status_promo`]="{ item }">
                    <v-chip
                        :color="getColor(item.status_promo)"
                        dark
                        outlined
                    >
                    {{ item.status_promo }}
                    </v-chip>
                </template>

                <template v-slot:[`item.actions`]="{ item }"> 
                    <v-icon small class="mr-2" @click="editHandler(item)" color="primary">mdi-fountain-pen-tip</v-icon>
                    <v-icon small @click="deleteHandler(item.id_promo)" color="error"> mdi-trash-can </v-icon>
                </template>
            </v-data-table>
        </v-card>

        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ formTitle}} Promo</span>
                </v-card-title>
                <v-card-text>
                    <v-container >
                        <v-form v-model="valid" ref="form"> 
                        <v-text-field v-model="form.kode_promo" :rules="rules.kode_promo" outlined dense label="Kode Promo" required></v-text-field>
                        <v-text-field v-model="form.jenis_promo" :rules="rules.jenis_promo" outlined dense label="Jenis Promo" required></v-text-field>
                        <v-textarea label="Keterangan Promo" :rules="rules.keterangan_promo"  dense  auto-grow outlined rows="1" row-height="15"  v-model="form.keterangan_promo" required></v-textarea>
                        <v-text-field v-model="form.diskon" :rules="rules.diskon" outlined dense label="Diskon" required></v-text-field>
                        <v-select v-model="form.status_promo" :rules="rules.status_promo" outlined dense :items="status_promo" label="Status Promo" required></v-select>
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

        <v-dialog v-model="dialogConfirm" persistent max-width="400px">
            <v-card>
                <v-card-title>
                    <span class="headline">Warning!</span>
                </v-card-title>
                <v-card-text>Anda yakin menghapus data promo ini?</v-card-text>
                <v-card-action>
                     <v-btn  color="blue darken-1" text @click="dialogConfirm = false"> Batal </v-btn>
                     <v-btn color="blue darken-1" text @click="deleteData"> Hapus </v-btn>
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
    name: "Promo",
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
                { text: "ID Promo", value: 'id_promo'},
                { text: "Kode Promo", align: "start", sortable: true, value: "kode_promo"},
                { text: "Jenis Promo", value: 'jenis_promo'},
                { text: "Keterangan Promo", value: 'keterangan_promo'},
                { text: "Diskon", value: 'diskon'},
                { text: "Status Promo", value: 'status_promo'},
                { text: "Actions", value: 'actions'},
            ],
            //
            rules: {
              kode_promo  : [
                v => !!v || 'Kode Promo tidak boleh kosong',
              ],
              jenis_promo  : [
                v => !!v || 'Jenis Promo tidak boleh kosong',
              ],
              keterangan_promo  : [
                v => !!v || 'Keterangan tidak boleh kosong',
              ],
              diskon  : [
                v => !!v || 'Diskon tidak boleh kosong',
              ],
              status_promo: [val => (val || '').length > 0 || 'This field is required'],
              
            },
            status_promo: ['Tersedia', 'Tidak Tersedia'],

            promo: new FormData,
            promos: [],
            form: {
                kode_promo: null,
                jenis_promo: null,
                keterangan_promo: null,
                diskon: null,
                status_promo: null,
            },
            deleteId: '',
            editId: ''
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
            var url = this.$api + '/promo';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.promos = response.data.data;
            })
        },
      
        save() {
           
            this.promo.append('kode_promo', this.form.kode_promo);
            this.promo.append('jenis_promo', this.form.jenis_promo);
            this.promo.append('keterangan_promo', this.form.keterangan_promo);
            this.promo.append('diskon', this.form.diskon);
            this.promo.append('status_promo', this.form.status_promo);
            var url = this.$api +'/promo'
            
            this.load = true;
            this.$http.post(url, this.promo, {
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
                kode_promo : this.form.kode_promo,
                jenis_promo: this.form.jenis_promo,
                keterangan_promo: this.form.keterangan_promo,
                diskon: this.form.diskon,
                status_promo: this.form.status_promo
            };
            var url = this.$api + '/promo/' + this.editId;
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
            var url = this.$api + '/promo/' + this.deleteId;
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
            this.editId = item.id_promo;
            this.form.kode_promo = item.kode_promo;
            this.form.jenis_promo = item.jenis_promo;
            this.form.keterangan_promo = item.keterangan_promo;
            this.form.diskon = item.diskon;
            this.form.status_promo = item.status_promo;
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
            this.dialogConfirmUpdate = false;
            this.readData();
        },
        cancel() {
            this.resetForm();
            this.readData();
            this.dialog = false;
            this.dialogConfirm  = false;
            this.dialogConfirmUpdate = false;
            this.inputType = 'Tambah';
        },
        resetForm() {
            this.form = { 
                kode_promo: null, 
                jenis_promo: null,
                keterangan_promo: null,
                diskon: null,
                status_promo: null,
            };
        },

        getColor(status_promo) {
            if(status_promo == 'Tersedia'){
                return 'green'
            }else if(status_promo == 'Tidak Tersedia'){
                return 'red'
            }
        }
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
