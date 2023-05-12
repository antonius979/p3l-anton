<template>
    <v-main class="list">
          <h3 class="text-h4 font-weight-bold mb-8 text-center text-decoration-underline"> Data Driver </h3>

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

                <v-btn color="success" dark @click="dialog = true"> Tambah Driver </v-btn>

            </v-card-title>
            <v-data-table :headers="headers" :items="drivers" :search="search">

                  
                <!-- Untuk mengubah warna status  -->
                <template v-slot:[`item.status_ketersediaan_driver`]="{ item }">
                    <v-chip
                        :color="getColor(item.status_ketersediaan_driver)"
                        dark
                        outlined
                    >
                    {{ item.status_ketersediaan_driver }}
                    </v-chip>
                </template>
                 

                <template v-slot:[`item.actions`]="{ item }"> 
                    <v-icon small class="mr-2" @click="editHandler(item)" color="primary">mdi-fountain-pen-tip</v-icon>
                    <v-icon small @click="deleteHandler(item.id_driver)" color="error"> mdi-trash-can </v-icon>
                </template>

                <!-- Untuk gambar -->
                <template v-slot:[`item.sim_driver`]="{ item }">
                    <td>
                    <img :src=" $image + '/source_simDriver/' + item.sim_driver" width="100">
                    </td>
                </template>

                 <template v-slot:[`item.surat_bebas_napza`]="{ item }">
                    <td>
                    <img :src=" $image + '/source_sbnDriver/' + item.surat_bebas_napza" width="70" height="100">
                    </td>
                </template>

                 <template v-slot:[`item.surat_kesehatan_jiwa`]="{ item }">
                    <td>
                    <img :src=" $image + '/source_skjiwaDriver/' + item.surat_kesehatan_jiwa" width="70" height="100">
                    </td>
                </template>

                 <template v-slot:[`item.surat_kesehatan_jasmani`]="{ item }">
                    <td>
                    <img :src=" $image + '/source_skjasmaniDriver/' + item.surat_kesehatan_jasmani" width="70" height="100">
                    </td>
                </template>

                <template v-slot:[`item.skck`]="{ item }">
                    <td>
                    <img :src=" $image + '/source_skckDriver/' + item.skck" width="70" height="100">
                    </td>
                </template>

                <template v-slot:[`item.foto_driver`]="{ item }">
                    <td>
                    <img :src=" $image + '/source_fotoDriver/' + item.foto_driver" width="100">
                    </td>
                </template>

            </v-data-table>
        </v-card>

        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>

                <v-card-title class="blue lighten-4 justify-center">
                    <span class="headline justify-center">{{ formTitle }} Driver</span>
                </v-card-title>

                <v-card-text>
                    <v-container >
                        <!-- untuk validasi -->
                        <v-form v-model="valid" ref="form"> 
                            
                            <v-text-field v-model="form.nama_driver" :rules="rules.nama_driver" outlined dense label="Nama" required></v-text-field>
                            <v-text-field v-model="form.alamat_driver" :rules="rules.alamat_driver" outlined dense label="Alamat" required></v-text-field>

                            <v-dialog
                                ref="dialog"
                                v-model="modal"
                                :return-value.sync="date"
                                persistent
                                width="290px"
                                >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                    v-model="form.tanggal_lahir_driver"
                                    label="Tanggal Lahir"
                                    prepend-icon="mdi-calendar"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    :rules="rules.tanggal_lahir_driver"
                                    outlined dense 
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="form.tanggal_lahir_driver"
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
                                    @click="$refs.dialog.save(form.tanggal_lahir_driver)"
                                    >
                                    OK
                                    </v-btn>
                                </v-date-picker>
                                </v-dialog>

                            <v-select
                                v-model="form.jenis_kelamin_driver"
                                :items="['Pria', 'Wanita']"
                                label="Jenis Kelamin"
                                :rules="rules.jenis_kelamin_driver"
                                outlined dense 
                                required
                            ></v-select>

                            <v-text-field v-model="form.no_telp_driver" :rules="rules.no_telp_driver" outlined dense label="No Telp" required></v-text-field>
                            <v-text-field v-model="form.email" :rules="rules.email" outlined dense label="Email" required></v-text-field>
                        
                            <!-- SIM -->
                             <v-file-input
                                v-if="inputType=='Tambah'"
                                v-model="form.sim_driver"
                                :rules="sim_driver"
                                accept="image/png, image/jpeg, image/bmp, pdf"
                                placeholder="Masukan file sim"
                                label="Foto SIM"
                                outlined dense
                            ></v-file-input>

                              <v-file-input
                                v-else
                                v-model="form.sim_driver"
                                :rules="sim_driver"
                                accept="image/png, image/jpeg, image/bmp, pdf"
                                placeholder="Masukan file sim"
                                label="Foto SIM"
                                outlined dense
                            ></v-file-input>

                            <!-- Surat Bebas Napza -->
                              <v-file-input
                                v-if="inputType=='Tambah'"
                                v-model="form.surat_bebas_napza"
                                :rules="surat_bebas_napza"
                                accept="image/png, image/jpeg, image/bmp, pdf"
                                placeholder="Masukan file surat bebas napza"
                                label="Foto Surat Bebas Napza"
                                outlined dense
                            ></v-file-input>

                            <v-file-input
                                v-else
                                v-model="form.surat_bebas_napza"
                                :rules="surat_bebas_napza"
                                accept="image/png, image/jpeg, image/bmp, pdf"
                                placeholder="Masukan file surat bebas napza"
                                label="Foto Surat Bebas Napza"
                                outlined dense
                            ></v-file-input>

                            <!-- Surat Kesehatan Jiwa -->

                            <v-file-input
                                v-if="inputType=='Tambah'"
                                v-model="form.surat_kesehatan_jiwa"
                                :rules="surat_kesehatan_jiwa"
                                accept="image/png, image/jpeg, image/bmp, pdf"
                                placeholder="Masukan file surat kesehatan jiwa"
                                label="Foto Surat Kesehatan Jiwa"
                                outlined dense
                            ></v-file-input>

                            <v-file-input
                                v-else
                                v-model="form.surat_kesehatan_jiwa"
                                :rules="surat_kesehatan_jiwa"
                                accept="image/png, image/jpeg, image/bmp, pdf"
                                placeholder="Masukan file surat kesehatan jiwa"
                                label="Foto Surat Kesehatan Jiwa"
                                outlined dense
                            ></v-file-input>

                            <!-- Surat Kesehatan Jasmani -->

                              <v-file-input
                                v-if="inputType=='Tambah'"
                                v-model="form.surat_kesehatan_jasmani"
                                :rules="surat_kesehatan_jasmani"
                                accept="image/png, image/jpeg, image/bmp, pdf"
                                placeholder="Masukan file surat kesehatan jasmani"
                                label="Foto Surat Kesehatan Jasmani"
                                outlined dense
                            ></v-file-input>

                             <v-file-input
                                v-else
                                v-model="form.surat_kesehatan_jasmani"
                                :rules="surat_kesehatan_jasmani"
                                accept="image/png, image/jpeg, image/bmp, pdf"
                                placeholder="Masukan file surat kesehatan jasmani"
                                label="Foto Surat Kesehatan Jasmani"
                                outlined dense
                            ></v-file-input>

                            <!-- SKCK -->
                               <v-file-input
                                v-if="inputType=='Tambah'"
                                v-model="form.skck"
                                :rules="skck"
                                accept="image/png, image/jpeg, image/bmp, pdf"
                                placeholder="Masukan file skck"
                                label="Foto SKCK"
                                outlined dense
                            ></v-file-input>

                             <v-file-input
                                v-else
                                v-model="form.skck"
                                :rules="skck"
                                accept="image/png, image/jpeg, image/bmp, pdf"
                                placeholder="Masukan file skck"
                                label="Foto SKCK"
                                outlined dense
                            ></v-file-input>

                            <!-- FOTO DRIVER  -->

                            <v-file-input
                                v-if="inputType=='Tambah'"
                                v-model="form.foto_driver"
                                :rules="foto_driver"
                                accept="image/png, image/jpeg, image/bmp, pdf"
                                placeholder="Masukan foto anda"
                                label="Foto Driver"
                                outlined dense
                            ></v-file-input>

                            <v-file-input
                                v-else
                                v-model="form.foto_driver"
                                :rules="foto_driver"
                                accept="image/png, image/jpeg, image/bmp, pdf"
                                placeholder="Masukan foto anda"
                                label="Foto Driver"
                                outlined dense
                            ></v-file-input>

                            <v-select
                                v-model="form.bahasa_asing"
                                :items="['Bahasa Indonesia', 'Bahasa Indonesia & Bahasa Inggris']"
                                label="Bahasa Asing"
                                :rules="rules.bahasa_asing"
                                outlined dense 
                                required
                            ></v-select>

                            <v-select
                                v-model="form.status_ketersediaan_driver"
                                :items="['Tersedia', 'Tidak Tersedia']"
                                label="Status"
                                :rules="rules.status_ketersediaan_driver"
                                outlined dense
                                required
                            ></v-select>

                              
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


        <v-dialog v-model="dialogConfirm" persistent max-width="500px">
            <v-card>
                <v-card-title class="red accent-10 justify-center">
                    <span>PERHATIAN!</span>
                </v-card-title>
                <v-card-text style="margin-top:5%">
                    Yakin ingin menghapus driver ini?
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
    name: "Driver",
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
                { text: "ID Driver", value: 'id_driver'},
                { text: "Nama", value: 'nama_driver' , align: "start",sortable: true,},
                { text: "Foto", value: 'foto_driver'},
                { text: "Alamat", value: 'alamat_driver'},
                { text: "Tanggal Lahir", value: 'tanggal_lahir_driver' },
                { text: "Jenis Kelamin", value: 'jenis_kelamin_driver'},
                { text: "No Telp", value: 'no_telp_driver'},
                { text: "Email", value: 'email'},
                { text: "SIM", value: 'sim_driver'},
                { text: "Surat Bebas Napza", value: 'surat_bebas_napza'},
                { text: "Surat Kesehatan Jiwa", value: 'surat_kesehatan_jiwa'},
                { text: "Surat Kesehatan Jasmani", value: 'surat_kesehatan_jasmani'},
                { text: "SKCK", value: 'skck'},
                { text: "Bahasa Asing", value: 'bahasa_asing'},
                { text: "Tarif", value: 'tarif_driver_perhari'},
                { text: "Rerata Rating", value: 'rerata_rating_driver'},
                { text: "Status", value: 'status_ketersediaan_driver'},
                { text: "Actions", value: 'actions'},
            ],
            //
            rules: {
              nama_driver : [
                v => !!v || 'Nama Driver is required',
              ],
              alamat_driver  : [
                v => !!v || 'Alamat Driver is required',
              ],
              tanggal_lahir_driver: [
                v => !!v || 'Tanggal Lahir is required',
              ],
              jenis_kelamin_driver : [
                v => !!v || 'Jenis Kelamin is required',
              ],
              no_telp_driver : [
                v => !!v || 'No Telp is required',
              ],
              email : [
                v => !!v || 'Email is required',
              ],
              bahasa_asing : [
                v => !!v || 'Bahasa Asing is required',
              ],
              status_ketersediaan_driver : [
                v => !!v || 'Status is required',
              ],
            

            },
         
            driver: new FormData,
            drivers: [],
            form: {
                nama_driver: null,
                alamat_driver: null,
                tanggal_lahir_driver: null,
                jenis_kelamin_driver: null,
                no_telp_driver: null,
                email: null,
                sim_driver: null,
                surat_bebas_napza: null,
                surat_kesehatan_jiwa: null,
                surat_kesehatan_jasmani: null,
                skck: null,
                foto_driver: null,
                bahasa_asing: null,
                status_ketersediaan_driver: null,

            },

            // untuk tanggal
            modal:false,
            tanggal_lahir_driver: new Date().toISOString().substr(0, 10),
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
            var url = this.$api + '/driver';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.drivers = response.data.data;
            })
        },
       
        save() {
            this.driver.append('nama_driver', this.form.nama_driver);
            this.driver.append('alamat_driver', this.form.alamat_driver);
            this.driver.append('tanggal_lahir_driver', this.form.tanggal_lahir_driver);
            this.driver.append('jenis_kelamin_driver', this.form.jenis_kelamin_driver);
            this.driver.append('no_telp_driver', this.form.no_telp_driver);
            this.driver.append('email', this.form.email);

            this.driver.append('sim_driver', this.form.sim_driver);
            this.driver.append('surat_bebas_napza', this.form.surat_bebas_napza);
            this.driver.append('surat_kesehatan_jiwa', this.form.surat_kesehatan_jiwa);
            this.driver.append('surat_kesehatan_jasmani', this.form.surat_kesehatan_jasmani);
            this.driver.append('skck', this.form.skck);
            this.driver.append('foto_driver', this.form.foto_driver);

            this.driver.append('bahasa_asing', this.form.bahasa_asing);
            this.driver.append('rerata_rating_driver', 5);
            this.driver.append('status_ketersediaan_driver', this.form.status_ketersediaan_driver);

            this.driver.append('id_role', 'Driver');

            var url = this.$api +'/driver'
            
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
                nama_driver: this.form.nama_driver,
                alamat_driver: this.form.alamat_driver,
                tanggal_lahir_driver: this.form.tanggal_lahir_driver,
                jenis_kelamin_driver: this.form.jenis_kelamin_driver,
                no_telp_driver: this.form.no_telp_driver,
                email: this.form.email,
                bahasa_asing: this.form.bahasa_asing,
                rerata_rating_driver: 5,
                status_ketersediaan_driver: this.form.status_ketersediaan_driver,

                id_role: 'Driver'
            };
            var url = this.$api + '/driver/' + this.editId;
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
         if(this.form.sim_driver!=null){
                let item = new FormData();
                item.append('sim_driver',this.form.sim_driver);
                url = this.$api + '/simDriver/' + this.editId;
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

        
          if(this.form.surat_bebas_napza!=null){
                let item = new FormData();
                item.append('surat_bebas_napza',this.form.surat_bebas_napza);
                url = this.$api + '/sbnDriver/' + this.editId;
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

             if(this.form.surat_kesehatan_jiwa!=null){
                let item = new FormData();
                item.append('surat_kesehatan_jiwa',this.form.surat_kesehatan_jiwa);
                url = this.$api + '/skjiwaDriver/' + this.editId;
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

            if(this.form.surat_kesehatan_jasmani!=null){
                let item = new FormData();
                item.append('surat_kesehatan_jasmani',this.form.surat_kesehatan_jasmani);
                url = this.$api + '/skjasmaniDriver/' + this.editId;
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

            if(this.form.skck!=null){
                let item = new FormData();
                item.append('skck',this.form.skck);
                url = this.$api + '/skckDriver/' + this.editId;
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

            if(this.form.foto_driver!=null){
                let item = new FormData();
                item.append('foto_driver',this.form.foto_driver);
                url = this.$api + '/fotoDriver/' + this.editId;
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
            var url = this.$api + '/driver/' + this.deleteId;
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
            this.editId = item.id_driver;
            this.form.nama_driver = item.nama_driver;
            this.form.alamat_driver = item.alamat_driver;
            this.form.tanggal_lahir_driver = item.tanggal_lahir_driver;
            this.form.jenis_kelamin_driver= item.jenis_kelamin_driver;
            this.form.no_telp_driver = item.no_telp_driver;
            this.form.email = item.email;
            this.form.bahasa_asing = item.bahasa_asing;
            this.form.rerata_rating_driver = item.rerata_rating_driver;
            this.form.status_ketersediaan_driver = item.status_ketersediaan_driver;

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
                nama_driver: null,
                alamat_driver: null,
                tanggal_lahir_driver: null,
                jenis_kelamin_driver: null,
                no_telp_driver: null,
                email: null,
                bahasa_asing: null,
                rerata_rating_driver: null,
                status_ketersediaan_driver: null,

                id_role: null,
            };
        },

         getColor(status_ketersediaan_driver) {
            if(status_ketersediaan_driver == 'Tersedia'){
                return 'green'
            }else if(status_ketersediaan_driver == 'Tidak Tersedia'){
                return 'red'
            }
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
