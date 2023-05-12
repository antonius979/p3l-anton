<template>
    <v-main class="list">
         <h3 class="text-h4 font-weight-bold mb-8 text-center text-decoration-underline"> Jadwal Harian</h3>
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

                <!-- <v-btn color="success" dark @click="dialog = true"> Tambah </v-btn> -->

            </v-card-title>
            <v-data-table :headers="headers" :items="jadwal_harians" :search="search">

                <template v-slot:[`item.actions`]="{ item }"> 
                    <v-icon small class="mr-2" @click="editHandler(item)" color="primary">mdi-fountain-pen-tip</v-icon>
                    <!-- <v-icon small @click="deleteHandler(item.id_jadwal_harian)" color="error"> mdi-trash-can </v-icon> -->
                </template>
            </v-data-table>

        </v-card>


        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ formTitle}} Jadwal</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-text-field v-model="form.id_jadwal" :rules="rules.id_jadwal" outlined dense label="ID Jadwal" required></v-text-field>
                        <v-text-field v-model="form.id_instruktur" :rules="rules.id_instruktur" outlined dense label="ID Instruktur" required></v-text-field>
                        <v-text-field v-model="form.id_kelas" :rules="rules.id_kelas" outlined dense label="ID Kelas" required></v-text-field>
                        <v-select
                                v-model="form.hari_kerja"
                                :items="['Selasa I','Selasa II', 'Rabu I', 'Rabu II'
                                ,'Kamis I', 'Kamis II', 'Jumat I', 'Jumat II'
                                ,'Sabtu I', 'Sabtu II', 'Minggu I', 'Minggu II']"
                                label="Hari"
                                outlined dense
                                required
                            ></v-select>
                         <v-text-field v-model="form.jam" :rules="rules.jam" outlined dense label="Jam" required></v-text-field>
                         
                         <v-dialog ref="dialog" v-model="modal" :return-value.sync="date" persistent width="290px">
                                <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="form.tanggal" label="Tanggal" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" :rules="rules.tanggal" outlined dense></v-text-field>
                                </template>
                                <v-date-picker v-model="form.tanggal" scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="modal = false"> Cancel </v-btn>
                                <v-btn text color="primary" @click="$refs.dialog.save(form.tanggal)"> OK </v-btn>
                                </v-date-picker>
                         </v-dialog>

                         <v-text-field v-model="form.keterangan" :rules="rules.keterangan" outlined dense label="Keterangan" required></v-text-field>
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
                <v-card-text>Yakin menghapus data jadwal harian yang dipilih?</v-card-text>
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
    name: "JadwalHarian",
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
            headers: [
                { text: "Nama Instruktur", align: "start", sortable: true, value: 'nama_instruktur'},
                { text: "Nama Kelas", value: 'nama_kelas'},
                { text: "Hari Kerja",  value: "hari_kerja"},
                { text: "Tanggal", value: 'tanggal'},
                { text: "Jam", value: 'jam'},
                { text: "Keterangan", value: 'keterangan'},
                { text: "Actions", value: 'actions'},
            ],
            //
            rules: {
            id_jadwal : [
                v => !!v || 'ID Jadwal is required',
              ],
              id_instruktur : [
                v => !!v || 'ID Instruktur is required',
              ],
              id_kelas : [
                v => !!v || 'ID Kelas is required',
              ],
              hari_kerja  : [
                v => !!v || 'Hari Kerja is required',
              ],
              tanggal : [
                v => !!v || 'Tanggal is required',
              ],
              keterangan : [
                v => !!v || 'Keterangan is required',
              ],
              jam : [
                v => !!v || 'Jam is required',
              ],
            },

            jadwalHarian: new FormData,
            jadwal_harians: [],
            form: {
                id_instruktur: null,
                id_kelas: null,
                hari_kerja: null,
                tanggal: null,
                jam: null,
                keterangan: null,
            },
            deleteId: '',
            editId: ''
        };
    },

    methods: {
        // setForm(){
        //     if(this.inputType !== 'Tambah'){
        //         this.update();
        //     }else{
        //         this.save();
        //     }
        // },
        setForm() {
        if (this.$refs.form.validate()) {
            if (this.inputType !== "Tambah") {
            this.update();
            } else {
            this.save();
            }
        }
        },
      
        readData() {
            var url = this.$api + '/jadwalHarian';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.jadwal_harians = response.data.data;
            })
        },
     
        save() {
            this.jadwal_harian.append('id_jadwal', this.form.id_jadwal);
            this.jadwal_harian.append('id_instruktur', this.form.id_instruktur);
            this.jadwal_harian.append('id_kelas', this.form.id_kelas);
            this.jadwal_harian.append('tanggal', this.form.tanggal);
            this.jadwal_harian.append('hari_kerja', this.form.hari_kerja);
            this.jadwal_harian.append('jam', this.form.jam);
            this.jadwal_harian.append('keterangan', this.form.keterangan);

            this.jadwal_harian.append('id_role', 'JadwalHarian');
            
            var url = this.$api +'/jadwalHarian'
            
            this.load = true;
            this.$http.post(url, this.jadwalHarian, {
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
                 // baca data
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
                id_instruktur : this.form.id_instruktur,
                id_kelas : this.form.id_kelas,
                hari_kerja : this.form.hari_kerja,
                tanggal: this.form.tanggal,
                keterangan: this.form.keterangan,
                jam: this.form.jam,

                id_role: 'JadwalHarian'
            };
            var url = this.$api + '/jadwalHarian/' + this.editId;
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
                // baca data
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
            var url = this.$api + '/jadwalHarian/' + this.deleteId;
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
            this.editId = item.id_jadwal;
            this.editId = item.id_instruktur;
            this.editId = item.id_kelas;
            this.form.hari_kerja = item.hari_kerja;
            this.form.tanggal = item.tanggal;
            this.form.jam = item.jam;
            this.form.keterangan = item.keterangan;
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
            
        },
        cancel() {
            this.resetForm();
            this.readData();
            
            this.dialog = false;
            this.dialogConfirmUpdate= false,
            this.dialogConfirm  = false;
            this.inputType = 'Tambah';
        },
        resetForm() {
            this.form = { 
                id_instruktur: null,
                id_kelas: null,
                hari_kerja: null,
                jam: null,
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
