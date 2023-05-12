<template>
    <v-main class="list">
         <h3 class="text-h4 font-weight-bold mb-8 text-center text-decoration-underline"> Jadwal Pegawai </h3>
         <h4 class="mb-5">Jadwal Admin</h4>
        <v-card>
            <v-card-title >
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
            <v-data-table :headers="headers" :items="detail_jadwals_admin" :search="search">

                <template v-slot:[`item.actions`]="{ item }"> 
                    <v-icon small class="mr-2" @click="editHandler(item)" color="primary">mdi-fountain-pen-tip</v-icon>
                    <v-icon small @click="deleteHandler(item.id_detail_jadwal)" color="error"> mdi-trash-can </v-icon>
                </template>
            </v-data-table>

        </v-card>
        <div class="mb-5"></div>
        <h4 class="mb-5">Jadwal CS</h4>
        <v-card>
            <v-card-title >
                <v-text-field
                    v-model="search2"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details>
                </v-text-field>


            </v-card-title>

            <v-data-table :headers="headers" :items="detail_jadwals_cs" :search="search2">

                <template v-slot:[`item.actions`]="{ item }"> 
                    <v-icon small class="mr-2" @click="editHandler(item)" color="primary">mdi-fountain-pen-tip</v-icon>
                    <v-icon small @click="deleteHandler(item.id_detail_jadwal)" color="error"> mdi-trash-can </v-icon>
                </template>
            </v-data-table>
        </v-card>


        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ formTitle}} Jadwal Pegawai</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-text-field v-model="form.id_pegawai" :rules="rules.id_pegawai" outlined dense label="ID Pegawai" required></v-text-field>
                        <v-select
                                v-model="form.hari_kerja"
                                :items="['Selasa I','Selasa II', 'Rabu I', 'Rabu II'
                                ,'Kamis I', 'Kamis II', 'Jumat I', 'Jumat II'
                                ,'Sabtu I', 'Sabtu II', 'Minggu I', 'Minggu II']"
                                label="Jadwal"
                                outlined dense
                                required
                            ></v-select>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancel"> Cancel </v-btn>
                    <v-btn color="blue darken-1" text @click="dialogConfirmUpdate = true"> Save </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="dialogConfirm" persistent max-width="400px">
            <v-card>
                <v-card-title>
                    <span class="headline">Warning!</span>
                </v-card-title>
                <v-card-text>Yakin menghapus data jadwal pegawai yang dipilih?</v-card-text>
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
    name: "JadwalPegawai",
    data() {
        return {
            inputType: 'Tambah',
            load: false,
            snackbar: false,
            error_message: '',
            color: '',
            search: null,
            search2:null,
            dialog: false,
            dialogConfirmUpdate: false,
            dialogConfirm: false,
            headers: [
                { text: "Nama Role", value: 'nama_role'},
                { text: "Nama Pegawai", align: "start", sortable: true, value: 'nama_pegawai'},
                { text: "Hari Kerja",  value: "hari_kerja"},
                { text: "Shift", value: 'shift'},
                { text: "Actions", value: 'actions'},
            ],
            //
            rules: {
              id_pegawai  : [
                v => !!v || 'ID Pegawai is required',
              ],
              id_jadwal_pegawai : [
                v => !!v || 'ID Jadwal is required',
              ],
            },

            detail_jadwal: new FormData,
            detail_jadwals_admin: [],
            detail_jadwals_cs: [],
            form: {
                id_pegawai: null,
                hari_kerja: null,

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
            var url = this.$api + '/detailJadwalAdmin';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.detail_jadwals_admin = response.data.data;
            })
        },

        readDataCS() {
            var url = this.$api + '/detailJadwalCS';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.detail_jadwals_cs = response.data.data;
            })
        },
     
        save() {
            this.detail_jadwal.append('id_pegawai', this.form.id_pegawai);

            if(this.form.hari_kerja == 'Selasa I'){
                this.detail_jadwal.append('id_jadwal_pegawai', 1);
            }else if(this.form.hari_kerja == 'Selasa II'){
                this.detail_jadwal.append('id_jadwal_pegawai', 2);
            }else if(this.form.hari_kerja == 'Rabu I'){
                this.detail_jadwal.append('id_jadwal_pegawai', 3);
            }else if(this.form.hari_kerja == 'Rabu II'){
                this.detail_jadwal.append('id_jadwal_pegawai', 4);
            }else if(this.form.hari_kerja == 'Kamis I'){
                this.detail_jadwal.append('id_jadwal_pegawai', 5);
            }else if(this.form.hari_kerja == 'Kamis II'){
                this.detail_jadwal.append('id_jadwal_pegawai', 6);
            }else if(this.form.hari_kerja == 'Jumat I'){
                this.detail_jadwal.append('id_jadwal_pegawai', 7);
            }else if(this.form.hari_kerja == 'Jumat II'){
                this.detail_jadwal.append('id_jadwal_pegawai', 8);
            }else if(this.form.hari_kerja == 'Sabtu I'){
                this.detail_jadwal.append('id_jadwal_pegawai', 9);
            }else if(this.form.hari_kerja == 'Sabtu II'){
                this.detail_jadwal.append('id_jadwal_pegawai', 10);
            }else if(this.form.hari_kerja == 'Minggu I'){
                this.detail_jadwal.append('id_jadwal_pegawai', 11);
            }else if(this.form.hari_kerja == 'Minguu II'){
                this.detail_jadwal.append('id_jadwal_pegawai', 12);
            }
            
            var url = this.$api +'/detailJadwal'
            
            this.load = true;
            this.$http.post(url, this.detail_jadwal, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token'),
                }
            }).then(response=> {
                this.error_message = response.data.message;
                this.color = "green";
                this.snackbar= true;
                this.load= true;
                this.close();
                this.readData();
                this.readDataCS();  // baca data
                this.resetForm();
            }).catch(error => {
                this.error_message = error.response.data.message;
                this.color= "red";
                this.snackbar= true;
                this.load = false;
            });
           
        
        },
       
        update() {
            var  new_id_jadwal_pegawai;

             if(this.form.hari_kerja == 'Selasa I'){
                new_id_jadwal_pegawai = 1;
            }else if(this.form.hari_kerja == 'Selasa II'){
                new_id_jadwal_pegawai = 2;
            }else if(this.form.hari_kerja == 'Rabu I'){
                new_id_jadwal_pegawai = 3;
            }else if(this.form.hari_kerja == 'Rabu II'){
                new_id_jadwal_pegawai = 4;
            }else if(this.form.hari_kerja == 'Kamis I'){
                new_id_jadwal_pegawai = 5;
            }else if(this.form.hari_kerja == 'Kamis II'){
                new_id_jadwal_pegawai = 6;
            }else if(this.form.hari_kerja == 'Jumat I'){
                new_id_jadwal_pegawai = 7;
            }else if(this.form.hari_kerja == 'Jumat II'){
                new_id_jadwal_pegawai = 8;
            }else if(this.form.hari_kerja == 'Sabtu I'){
                new_id_jadwal_pegawai = 9;
            }else if(this.form.hari_kerja == 'Sabtu II'){
                new_id_jadwal_pegawai = 10;
            }else if(this.form.hari_kerja == 'Minggu I'){
                new_id_jadwal_pegawai = 11;
            }else if(this.form.hari_kerja == 'Minguu II'){
                new_id_jadwal_pegawai = 12;
            }

            let newData = {
                id_pegawai : this.form.id_pegawai,
                id_jadwal_pegawai: new_id_jadwal_pegawai,
            };
            var url = this.$api + '/detailJadwal/' + this.editId;
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
                this.readData(); 
                this.readDataCS();// baca data
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
            var url = this.$api + '/detailJadwal/' + this.deleteId;
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
                this.readDataCS();
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
            this.editId = item.id_detail_jadwal;
            this.form.id_pegawai = item.id_pegawai;
            this.form.id_jadwal_pegawai = item.id_jadwal_pegawai;
            this.dialog = true;
        },

        deleteHandler(id) {
            this.deleteId = id;
            this.dialogConfirm = true;
        },

        close() {
            this.dialog = false;
            this.inputType = 'Tambah';
            this.dialogConfirmUpdate = false,
            this.dialogConfirm = false;
            this.readData();
            this.readDataCS();
        },
        cancel() {
            this.resetForm();
            this.readData();
            this.readDataCS();
            this.dialog = false;
            this.dialogConfirmUpdate= false,
            this.dialogConfirm  = false;
            this.inputType = 'Tambah';
        },
        resetForm() {
            this.form = { 
                hari_kerja: null, 
                shift: null,
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
        this.readDataCS();
    },
};
</script>
