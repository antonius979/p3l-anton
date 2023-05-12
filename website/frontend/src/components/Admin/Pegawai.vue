<template>
    <v-main class="list">
          <h3 class="text-h4 font-weight-bold mb-8 text-center text-decoration-underline"> Data Pegawai </h3>

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

                <v-btn color="success" dark @click="dialog = true"> Tambah Pegawai </v-btn>

            </v-card-title>
            <v-data-table :headers="headers" :items="pegawais" :search="search">
                 

                <template v-slot:[`item.actions`]="{ item }"> 
                    <v-icon small class="mr-2" @click="editHandler(item)" color="primary">mdi-fountain-pen-tip</v-icon>
                    <v-icon small @click="deleteHandler(item.id_pegawai)" color="error"> mdi-trash-can </v-icon>
                </template>

                <!-- Untuk gambar -->
                <template v-slot:[`item.foto_pegawai`]="{ item }">
                    <td>
                    <img :src=" $image + '/source_imagePegawai/' + item.foto_pegawai" width="150">
                    </td>
                </template>

            </v-data-table>
        </v-card>

        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>

                <v-card-title class="red lighten-4 justify-center">
                    <span class="headline justify-center">{{ formTitle }} Pegawai</span>
                </v-card-title>

                <v-card-text>
                    <v-container >
                        <!-- untuk validasi -->
                        <v-form v-model="valid" ref="form"> 
                             <v-select
                                v-model="form.nama_role"
                                :items="['Manager', 'Admin', 'Customer Service']"
                                label="Nama Role"
                                :rules="rules.id_role"
                                outlined dense
                                required
                            ></v-select>

                        
                            <!-- Untuk input file gambar -->
                             <v-file-input
                                v-if="inputType=='Tambah'"
                                v-model="form.foto_pegawai"
                                :rules="foto_pegawai"
                                accept="image/png, image/jpeg, image/bmp"
                                placeholder="Pilih foto pegawai yang diinginkan"
                                label="Foto Pegawai"
                                prepend-icon="mdi-camera"
                                src="../assets/logoAJR.png"
                            ></v-file-input>

                            <!-- Waktu Update -->
                             <v-file-input
                                v-else
                                v-model="form.foto_pegawai"
                                accept="image/png, image/jpeg, image/bmp"
                                placeholder="Pilih foto pegawai yang diinginkan"
                                label="Foto Pegawai"
                                prepend-icon="mdi-camera"
                            ></v-file-input>

                            <v-text-field v-model="form.nama_pegawai" :rules="rules.nama_pegawai" outlined dense label="Nama" required></v-text-field>

                            <v-dialog
                                ref="dialog"
                                v-model="modal"
                                :return-value.sync="date"
                                persistent
                                width="290px"
                                >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                    v-model="form.tanggal_lahir_pegawai"
                                    label="Tanggal Lahir"
                                    prepend-icon="mdi-calendar"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="form.tanggal_lahir_pegawai"
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
                                    @click="$refs.dialog.save(form.tanggal_lahir_pegawai)"
                                    >
                                    OK
                                    </v-btn>
                                </v-date-picker>
                                </v-dialog>

                              <v-select
                                v-model="form.jenis_kelamin_pegawai"
                                :items="['Pria', 'Wanita']"
                                label="Jenis Kelamin"
                                :rules="rules.jenis_kelamin_pegawai"
                                outlined dense 
                                required
                            ></v-select>

                            <v-text-field v-model="form.alamat_pegawai" :rules="rules.alamat_pegawai" outlined dense label="Alamat" required></v-text-field>
                            <v-text-field v-model="form.no_telp_pegawai" :rules="rules.no_telp_pegawai" outlined dense label="No Telp" required></v-text-field>
                            <v-text-field v-model="form.email" :rules="rules.email" outlined dense label="Email" required></v-text-field>

                              
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

        <v-dialog v-model="dialogConfirm" persistent max-width="400px">
            <v-card>
                <v-card-title>
                    <span class="headline">Warning!</span>
                </v-card-title>
                <v-card-text>Are you sure to DELETE this pegawai?</v-card-text>
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
    name: "Pegawai",
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
                { text: "ID Pegawai", value: 'id_pegawai'},
                { text: "Foto Pegawai", value: 'foto_pegawai'},
                { text: "Nama Role", value: 'nama_role'},
                { text: "Nama", value: 'nama_pegawai' , align: "start",sortable: true,},
                { text: "Tanggal Lahir", value: 'tanggal_lahir_pegawai'},
                { text: "Jenis Kelamin", value: 'jenis_kelamin_pegawai'},
                { text: "Alamat", value: 'alamat_pegawai'},
                { text: "No Telp", value: 'no_telp_pegawai'},
                { text: "Email", value: 'email'},
                { text: "Actions", value: 'actions'},
            ],
            //
            rules: {
              id_role  : [
                v => !!v || 'ID Role is required',
              ],
              foto_pegawai  : [
                v => !!v || 'Foto Pegawai is required',
              ],
              nama_pegawai  : [
                v => !!v || 'Nama is required',
              ],
              tanggal_lahir_pegawai : [
                v => !!v || 'Tanggal Lahir is required',
              ],
              jenis_kelamin_pegawai : [
                v => !!v || 'Jenis Kelamin is required',
              ],
              alamat_pegawai : [
                v => !!v || 'Alamat is required',
              ],
              no_telp_pegawai : [
                v => !!v || 'No Telp is required',
              ],
              email : [
                v => !!v || 'Email is required',
              ],
            },
         
            pegawai: new FormData,
            pegawais: [],
            form: {
                id_role: null,
                foto_pegawai: '',
                nama_pegawai: null,
                tanggal_lahir_pegawai: null,
                jenis_kelamin_pegawai: null,
                alamat_pegawai: null,
                no_telp_pegawai: null,
                email: null,
            },

            // untuk tanggal
            modal:false,
            tanggal_lahir_pegawai: new Date().toISOString().substr(0, 10),
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
            var url = this.$api + '/pegawai';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.pegawais = response.data.data;
            })
        },
   
        save() {
            if(this.form.nama_role == 'Manager')
            {
                this.pegawai.append('id_role', 1);
            } 
            else if(this.form.nama_role == 'Admin')
            {
                this.pegawai.append('id_role', 2);
            } else if(this.form.nama_role == 'Customer Service')
            {
                this.pegawai.append('id_role', 3);
            }
          

            if(this.form.foto_pegawai == null)
            {
                this.pegawai.append('foto_pegawai', '../assets/logoAJR.png');
            }else{
                this.pegawai.append('foto_pegawai', this.form.foto_pegawai);
            }
            
            this.pegawai.append('nama_pegawai', this.form.nama_pegawai);
            this.pegawai.append('tanggal_lahir_pegawai', this.form.tanggal_lahir_pegawai);
            this.pegawai.append('jenis_kelamin_pegawai', this.form.jenis_kelamin_pegawai);
            this.pegawai.append('alamat_pegawai', this.form.alamat_pegawai);
            this.pegawai.append('no_telp_pegawai', this.form.no_telp_pegawai);
            this.pegawai.append('email', this.form.email);

            var url = this.$api +'/pegawai'
            
            this.load = true;
            this.$http.post(url, this.pegawai, {
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
            var  new_id_role;
            if(this.form.nama_role == 'Manager')
            {
               new_id_role = 1;
            } 
            else if(this.form.nama_role == 'Admin')
            {
                new_id_role = 2;
            } else if(this.form.nama_role == 'Customer Service')
            {
                new_id_role = 3;
            }

            let newData = {
                id_role : new_id_role,
                nama_pegawai: this.form.nama_pegawai,
                tanggal_lahir_pegawai: this.form.tanggal_lahir_pegawai,
                jenis_kelamin_pegawai: this.form.jenis_kelamin_pegawai,
                alamat_pegawai: this.form.alamat_pegawai,
                no_telp_pegawai: this.form.no_telp_pegawai,
                email: this.form.email,
            };
            var url = this.$api + '/pegawai/' + this.editId;
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
            // khusus gambar
         if(this.form.foto_pegawai!=null){
                let item = new FormData();
                item.append('foto_pegawai',this.form.foto_pegawai);
                url = this.$api + '/fotoPegawai/' + this.editId;
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
    
        deleteData() {
            //menghapus data
            var url = this.$api + '/pegawai/' + this.deleteId;
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
            this.editId = item.id_pegawai;
            this.form.nama_role = item.nama_role;
            this.form.nama_pegawai = item.nama_pegawai;
            this.form.tanggal_lahir_pegawai = item.tanggal_lahir_pegawai;
            this.form.jenis_kelamin_pegawai= item.jenis_kelamin_pegawai;
            this.form.alamat_pegawai = item.alamat_pegawai;
            this.form.no_telp_pegawai = item.no_telp_pegawai;
            this.form.email = item.email;
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
             this.dialogConfirmUpdate= false;
            this.readData();
        },
        cancel() {
            this.resetForm();
            this.readData();
            this.dialog = false;
            this.dialogConfirm  = false;
            this.dialogConfirmUpdate= false;
            this.inputType = 'Tambah';
        },
        resetForm() {
            this.form = { 
                id_role : null,
                nama_pegawai: null,
                tanggal_lahir_pegawai: null,
                jenis_kelamin_pegawai: null,
                alamat_pegawai: null,
                no_telp_pegawai: null,
                email: null,
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
