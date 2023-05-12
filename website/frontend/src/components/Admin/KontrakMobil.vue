<template>
    <v-main class="list">
          <h3 class="text-h4 font-weight-bold mb-8 text-center text-decoration-underline"> Data Mobil akan Habis Kontrak  </h3>

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
            <v-data-table :headers="headers" :items="mobils" :search="search">
                 
                <!-- Untuk mengubah warna status  -->
                <template v-slot:[`item.status_ketersediaan_mobil`]="{ item }">
                    <v-chip
                        :color="getColor(item.status_ketersediaan_mobil)"
                        dark
                        outlined
                    >
                    {{ item.status_ketersediaan_mobil }}
                    </v-chip>
                </template>

                <template v-slot:[`item.actions`]="{ item }"> 
                    <v-icon small class="mr-2" @click="editHandler(item)" color="primary">mdi-fountain-pen-tip</v-icon>
                    <v-icon small @click="deleteHandler(item.id_mobil)" color="error"> mdi-trash-can </v-icon>
                </template>

                <!-- Untuk gambar -->
                <template v-slot:[`item.gambar_mobil`]="{ item }">
                    <td>
                    <img :src=" $image + '/source_imageMobil/' + item.gambar_mobil" width="300">
                    </td>
                </template>

            </v-data-table>
        </v-card>

        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>

                <v-card-title class="red lighten-4 justify-center">
                    <span class="headline justify-center">{{ formTitle }} Mobil</span>
                </v-card-title>

                <v-card-text>
                    <v-container >
                        <!-- untuk validasi -->
                        <v-form v-model="valid" ref="form"> 
                             <v-select
                                v-model="selectMitra"
                                :items="itemMitra"
                                item-value="id_pemilik_mobil"
                                item-text="nama_pemilik_mobil"
                                label="Nama Mitra"
                                :rules="rules.id_pemilik_mobil"
                                outlined dense
                                required
                                return-object
                                persistent-hint
                                single-line
                            ></v-select>
                            <v-text-field v-model="form.plat_nomor" :rules="rules.plat_nomor" outlined dense label="Plat Nomor" required></v-text-field>
                            <v-text-field v-model="form.nomor_stnk" :rules="rules.nomor_stnk" outlined dense label="No STNK" required></v-text-field>

                            <!-- Untuk input file gambar -->
                            <!-- Waktu Add -->
                             <v-file-input
                                v-if="inputType=='Tambah'"
                                v-model="form.gambar_mobil"
                                :rules="imgRules"
                                accept="image/png, image/jpeg, image/bmp"
                                placeholder="Pilih gambar mobil yang diinginkan"
                                label="Gambar Mobil"
                                prepend-icon="mdi-camera"
                            ></v-file-input>

                            <!-- Waktu Update -->
                             <v-file-input
                                v-else
                                v-model="form.gambar_mobil"
                                accept="image/png, image/jpeg, image/bmp"
                                placeholder="Pilih gambar mobil yang diinginkan"
                                label="Gambar Mobil"
                                prepend-icon="mdi-camera"
                            ></v-file-input>

                              <v-text-field v-model="form.nama_mobil" :rules="rules.nama_mobil" outlined dense label="Nama Mobil" required></v-text-field>
                              <v-select
                                v-model="form.tipe_mobil"
                                :items="['Sedan', 'City Car', 'SUV', 'MPV']"
                                label="Tipe Mobil"
                                :rules="rules.tipe_mobil"
                                outlined dense 
                                required
                            ></v-select>
                               <v-select
                                v-model="form.jenis_transmisi"
                                :items="['AT', 'MT', 'CVT']"
                                label="Jenis Transmisi"
                                :rules="rules.jenis_transmisi"
                                outlined dense
                                required
                            ></v-select>
                             <v-select
                                v-model="form.jenis_bahan_bakar"
                                :items="['Pertamax', 'Pertalite']"
                                label="Jenis Bahan Bakar"
                                :rules="rules.jenis_bahan_bakar"
                                outlined dense
                                required
                            ></v-select>
                            <v-select
                                v-model="form.warna_mobil"
                                :items="['Putih', 'Abu-Abu', 'Silver', 'Hitam', 'Merah']"
                                label="Warna Mobil"
                                :rules="rules.warna_mobil"
                                outlined dense
                                required
                            ></v-select>

                              <v-text-field v-model="form.kapasitas_penumpang" :rules="rules.kapasitas_penumpang" outlined dense label="Kapasitas Penumpang" required></v-text-field>

                            <v-select
                                v-model="form.volume_bagasi"
                                :items="['-','Kecil', 'Sedang', 'Besar']"
                                label="Volume Bagasi"
                                :rules="rules.volume_bagasi"
                                outlined dense
                                required
                            ></v-select>
                            
                              <v-text-field v-model="form.fasilitas" :rules="rules.fasilitas" outlined dense label="Fasilitas" required></v-text-field>
                            
                            <v-select
                                v-model="form.kategori_aset"
                                :items="['Owner', 'Mitra']"
                                label="Kategori Aset"
                                :rules="rules.volume_bagasi"
                                outlined dense
                                required
                            ></v-select>
                            <v-spacer></v-spacer>

                           
                        <v-text-field v-model="form.tanggal_kontrak_mulai_mobil" type="date" label="Tanggal Kontrak Mulai"></v-text-field>
                        <v-text-field v-model="form.tanggal_kontrak_selesai_mobil" type="date" label="Tanggal Kontrak Akhir"></v-text-field>
                        <v-text-field v-model="form.tanggal_terakhir_servis_mobil" type="date" label="Tanggal Service Akhir"></v-text-field>


                            <v-text-field v-model="form.harga_sewa_mobil_perhari" :rules="rules.harga_sewa_mobil_perhari" outlined dense label="Harga Sewa Mobil Per Hari" prefix="Rp. " required></v-text-field>

                            
                            <v-select
                                v-model="form.status_ketersediaan_mobil"
                                :items="['Tersedia', 'Tidak Tersedia', 'Kontrak Habis']"
                                label="Status"
                                :rules="rules.status_ketersediaan_mobil"
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

        <v-dialog v-model="dialogConfirm" persistent max-width="400px">
            <v-card>
                <v-card-title>
                    <span class="headline">Warning!</span>
                </v-card-title>
                <v-card-text>Anda yakin menghapus data mobil?</v-card-text>
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
    name: "Mobil",
    data() {
        return {
            inputType: 'Tambah',
            itemMitra:[],
            selectMitra:'',
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
                { text: "ID Mobil", value: 'id_mobil'},
                { text: "Nama Mitra", value: 'pemilik_mobil.nama_pemilik_mobil'},
                { text: "Plat Nomor", value: 'plat_nomor'},
                { text: "Nomor STNK", value: 'nomor_stnk'},
                { text: "Gambar Mobil", value: 'gambar_mobil'},
                { text: "Nama", value: 'nama_mobil', align: "start",sortable: true,},
                { text: "Tipe", value: 'tipe_mobil'},
                { text: "Jenis Transmisi", value: 'jenis_transmisi'},
                { text: "Jenis Bahan Bakar", value: 'jenis_bahan_bakar'},
                { text: "Warna", value: 'warna_mobil'},
                { text: "Kapasitas Penumpang", value: 'kapasitas_penumpang'},
                { text: "Volume Bagasi", value: 'volume_bagasi'},
                { text: "Fasilitas", value: 'fasilitas'},
                { text: "Kategori Aset", value: 'kategori_aset'},
                { text: "Tanggal Mulai Kontrak", value: 'tanggal_kontrak_mulai_mobil'},
                { text: "Tanggal Selesai Kontrak", value: 'tanggal_kontrak_selesai_mobil'},
                { text: "Tanggal Terakhir Servis", value: 'tanggal_terakhir_servis_mobil'},
                { text: "Harga Sewa Mobil Perhari", value: 'harga_sewa_mobil_perhari'},
                { text: "Status", value: 'status_ketersediaan_mobil'},
                { text: "Actions", value: 'actions'},
            ],
            //
            rules: {
              id_pemilik_mobil  : [
                v => !!v || 'ID Pemilik Mobil is required',
              ],
              plat_nomor  : [
                v => !!v || 'Plat Nomor is required',
              ],
              nomor_stnk  : [
                v => !!v || 'Nomor STNK is required',
              ],
              nama_mobil : [
                v => !!v || 'Nama Mobil is required',
              ],
              tipe_mobil : [
                v => !!v || 'Tipe Mobil is required',
              ],
              jenis_transmisi : [
                v => !!v || 'Jenis Transmisi is required',
              ],
              jenis_bahan_bakar : [
                v => !!v || 'Jenis Bahan Bakar is required',
              ],
              warna_mobil : [
                v => !!v || 'Warna Mobil is required',
              ],
              kapasitas_penumpang : [
                v => !!v || 'Kapasitas Penumpang  is required',
              ],
              volume_bagasi : [
                v => !!v || 'Volume Bagasi is required',
              ],
             fasilitas: [
                v => !!v || 'Fasilitas is required',
              ],
             kategori_aset : [
                v => !!v || 'Kategori Aset is required',
              ],
             harga_sewa_mobil_perhari : [
                v => !!v || 'Harga Sewa Mobil perhari is required',
              ],
             status_ketersediaan_mobil : [
                v => !!v || 'Status is required',
              ],
              
            },
         
            mobil: new FormData,
            mobils: [],
            form: {
                selectMitra:'',
                plat_nomor: null,
                nomor_stnk: null,
                gambar_mobil:null,
                nama_mobil: null,
                tipe_mobil: null,
                jenis_transmisi: null,
                jenis_bahan_bakar: null,
                warna_mobil: null,
                kapasitas_penumpang: null,
                volume_bagasi: null,
                fasilitas: null,
                kategori_aset: null,
                tanggal_kontrak_mulai_mobil: null,
                tanggal_kontrak_selesai_mobil: null,
                tanggal_terakhir_servis_mobil: null,
                harga_sewa_mobil_perhari: null,
                status_ketersediaan_mobil: null,
            },

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
            var url = this.$api + '/mobil';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.mobils = response.data.data;
            })
        },

        // Read Kontrak

        readDataKontrak() {
            var url= this.$api + '/mobilKontrak';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.mobils = response.data.data;
            })
        },

        kontrakHandler() {
            this.readDataKontrak();
        },

       
        save() {
            this.mobil.append('id_pemilik_mobil', this.selectMitra.id_pemilik_mobil ?? '');
            this.mobil.append('plat_nomor', this.form.plat_nomor);
            this.mobil.append('nomor_stnk', this.form.nomor_stnk);
            this.mobil.append('gambar_mobil', this.form.gambar_mobil);
            this.mobil.append('nama_mobil', this.form.nama_mobil);
            this.mobil.append('tipe_mobil', this.form.tipe_mobil);
            this.mobil.append('jenis_transmisi', this.form.jenis_transmisi);
            this.mobil.append('jenis_bahan_bakar', this.form.jenis_bahan_bakar);
            this.mobil.append('warna_mobil', this.form.warna_mobil);
            this.mobil.append('kapasitas_penumpang', this.form.kapasitas_penumpang);
            this.mobil.append('volume_bagasi', this.form.volume_bagasi);
            this.mobil.append('fasilitas', this.form.fasilitas);
            this.mobil.append('kategori_aset', this.form.kategori_aset);
            this.mobil.append('tanggal_kontrak_mulai_mobil', this.form.tanggal_kontrak_mulai_mobil);
            this.mobil.append('tanggal_kontrak_selesai_mobil', this.form.tanggal_kontrak_selesai_mobil);
            this.mobil.append('tanggal_terakhir_servis_mobil', this.form.tanggal_terakhir_servis_mobil);
            this.mobil.append('harga_sewa_mobil_perhari', this.form.harga_sewa_mobil_perhari);
            this.mobil.append('status_ketersediaan_mobil', this.form.status_ketersediaan_mobil);

            var url = this.$api +'/mobil'
            
            this.load = true;
            this.$http.post(url, this.mobil, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token'),
                }
            }).then(response=> {
                this.error_message = response.data.message;
                this.color = "green";
                this.snackbar= true;
                this.load= true;
                this.close();
                this.readDataKontrak(); // baca data
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
                id_pemilik_mobil : this.selectMitra.id_pemilik_mobil ?? '',
                plat_nomor: this.form.plat_nomor,
                nomor_stnk: this.form.nomor_stnk,
                nama_mobil: this.form.nama_mobil,
                tipe_mobil: this.form.tipe_mobil,
                jenis_transmisi: this.form.jenis_transmisi,
                jenis_bahan_bakar: this.form.jenis_bahan_bakar,
                warna_mobil: this.form.warna_mobil,
                kapasitas_penumpang: this.form.kapasitas_penumpang,
                volume_bagasi: this.form.volume_bagasi,
                fasilitas: this.form.fasilitas,
                kategori_aset: this.form.kategori_aset,
                tanggal_kontrak_mulai_mobil: this.form.tanggal_kontrak_mulai_mobil,
                tanggal_kontrak_selesai_mobil: this.form.tanggal_kontrak_selesai_mobil,
                tanggal_terakhir_servis_mobil: this.form.tanggal_terakhir_servis_mobil,
                harga_sewa_mobil_perhari: this.form.harga_sewa_mobil_perhari,
                status_ketersediaan_mobil: this.form.status_ketersediaan_mobil
            };
            var url = this.$api + '/mobil/' + this.editId;
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
                this.readDataKontrak(); // baca data
                this.resetForm();
                this.inputType = 'Tambah';
            }).catch(error => {
                this.error_message = error.response.data.message;
                this.color= 'red';
                this.snackbar = true;
                this.load = false;
            })
            // khusus gambar
            if(this.form.gambar_mobil!=null){
                let item = new FormData();
                item.append('gambar_mobil',this.form.gambar_mobil);
                url = this.$api + '/mobilFoto/' + this.editId;
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
                    this.readDataKontrak(); //mengambil data
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
            var url = this.$api + '/mobil/' + this.deleteId;
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
                this.readDataKontrak(); // baca data
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
            this.editId = item.id_mobil;
            if(item.pemilik_mobil != null)
            {
                this.selectMitra = {
                    id_pemilik_mobil : item.pemilik_mobil.id_pemilik_mobil,
                    nama_pemilik_mobil : item.pemilik_mobil_nama_pemilik_mobil
                }
            }
            this.form.plat_nomor = item.plat_nomor;
            this.form.nomor_stnk = item.nomor_stnk;
            this.form.nama_mobil = item.nama_mobil;
            this.form.tipe_mobil = item.tipe_mobil;
            this.form.jenis_transmisi = item.jenis_transmisi;
            this.form.jenis_bahan_bakar = item.jenis_bahan_bakar;
            this.form.warna_mobil = item.warna_mobil;
            this.form.kapasitas_penumpang = item.kapasitas_penumpang;
            this.form.volume_bagasi = item.volume_bagasi;
            this.form.fasilitas = item.fasilitas;
            this.form.kategori_aset = item.kategori_aset;
            this.form.tanggal_kontrak_mulai_mobil= item.tanggal_kontrak_mulai_mobil;
            this.form.tanggal_kontrak_selesai_mobil = item.tanggal_kontrak_selesai_mobil;
            this.form.tanggal_terakhir_servis_mobil = item.tanggal_terakhir_servis_mobil;
            this.form.harga_sewa_mobil_perhari = item.harga_sewa_mobil_perhari;
            this.form.status_ketersediaan_mobil = item.status_ketersediaan_mobil;
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
            this.readDataKontrak();
            
        },
        cancel() {
            this.resetForm();
            this.readDataKontrak();
            this.dialog = false;
            this.dialogConfirm  = false;
             this.dialogConfirmUpdate = false;
            this.inputType = 'Tambah';
        },
        resetForm() {
            this.form = { 
                selectMitra : '',
                plat_nomor: null,
                nomor_stnk: null,
                nama_mobil: null,
                tipe_mobil: null,
                jenis_transmisi: null,
                jenis_bahan_bakar: null,
                warna_mobil: null,
                kapasitas_penumpang: null,
                volume_bagasi: null,
                fasilitas: null,
                kategori_aset: null,
                tanggal_kontrak_mulai_mobil: null,
                tanggal_kontrak_selesai_mobil: null,
                tanggal_terakhir_servis_mobil: null,
                harga_sewa_mobil_perhari: null,
            };
        },

        getColor(status_ketersediaan_mobil) {
            if(status_ketersediaan_mobil == 'Tersedia'){
                return 'green'
            }else if(status_ketersediaan_mobil == 'Tidak Tersedia'){
                return 'red'
            }else if(status_ketersediaan_mobil == 'Kontrak Habis'){
                return 'blue'
            }
        },

        getAllMitra() {

                var url = this.$api + '/pemilikMobil';

                this.$http.get(url).then(response => {

                    this.itemMitra = response.data.data;

                })

            },
    },
    computed: {
        formTitle() {
            return this.inputType;
        },
    },
    mounted() {
        this.readDataKontrak();
        this.getAllMitra();
    },
};
</script>
