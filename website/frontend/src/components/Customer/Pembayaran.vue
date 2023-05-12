<template>
    <v-main class="list">
        <h3 class="text-h4 font-weight-bold mb-8 text-center tex-decoration-underline">Pembayaran</h3>

        <v-card>
            <v-card-title>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details></v-text-field>
            </v-card-title>

            <v-data-table :headers="headers" :items="peminjamans" :search="search">
                <template v-slot:[`item.actions`]="{ item }">
                    <v-icon small class="mr-2" @click="editHandler(item)" color="primary">mdi-fountain-pen-tip</v-icon>
                </template>
            </v-data-table>
        </v-card>

        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-card-title class="red lighten-4 justify-center">{{ formTitle }} Pembayaran</v-card-title>

                <v-card-text>
                    <v-container>
                        <v-form v-model="valid" ref="form">
                            <v-text-field v-model="form.id_customer" :rules="id_customer" label="ID Customer" readonly outlined dense></v-text-field>

                            <v-select v-model="selectMobil" :items="itemsMobil" item-text="nama_mobil" item-value="id_mobil" :rules="nama_mobil" label="Nama Mobil" required outlined dense persistent-hint return-object single-line readonly></v-select>

                            <v-select v-model="form.jenis_peminjaman" :items="itemsJenis" item-text="text" item-value="value" :rules="jenis_peminjaman" label="Jenis Peminjaman" required outlined dense readonly></v-select>

                            <v-select v-model="form.nama_driver" v-if="form.jenis_peminjaman == 'Mobil + Driver'" :items="itemsDriver" item-text="nama_driver" item-value="id_driver" label="Nama Driver" outlined dense persistent-hint return-object single-line readonly></v-select>

                            <v-text-field v-model="form.tanggal_transaksi" type="datetime-local" label="Tanggal Transaksi" :rules="tanggal_transaksi" required outlined dense readonly></v-text-field>

                            <v-text-field v-model="form.tanggal_mulai_sewa" type="datetime-local" label="Tanggal Mulai Sewa" :rules="tanggal_mulai_sewa" required outlined dense readonly></v-text-field>

                            <v-text-field v-model="form.tanggal_selesai_sewa" type="datetime-local" label="Tanggal Selesai Sewa" :rules="tanggal_selesai_sewa" required outlined dense readonly></v-text-field>

                            <v-text-field v-model="form.tanggal_pengembalian" type="datetime-local" label="Tanggal Pengembalian" :rules="tanggal_pengembalian" required outlined dense readonly></v-text-field>

                            <v-select v-model="form.kode_promo" :items="itemsPromo" item-text="kode_promo" item-value="id_promo" :rules="kode_promo" label="Kode Promo" required outlined dense persistent-hint return-object single-line readonly></v-select>

                            <v-text-field v-model="form.total_denda" label="Total Denda" :rules="total_denda" prefix="Rp. " required outlined dense readonly></v-text-field>

                            <v-text-field v-model="form.total_tarif_driver" v-if="form.jenis_peminjaman == 'Mobil + Driver'" label="Total Tarif Driver" :rules="total_denda" prefix="Rp. " required outlined dense readonly></v-text-field>

                            <v-text-field v-model="form.total_pembayaran" label="Total Pembayaran" :rules="total_pembayaran" prefix="Rp. " required outlined dense readonly></v-text-field>   


                            <!-- Waktu Update -->
                             <v-file-input
                                v-model="form.bukti_transfer"
                                accept="image/png, image/jpeg, image/bmp"
                                label="Bukti Transfer"
                                prepend-icon="mdi-camera"
                            ></v-file-input>

                            <v-select v-model="form.metode_pembayaran" :items="itemsMetode" item-text="text" item-value="value" :rules="metode_pembayaran" label="Metode Pembayaran" required outlined dense></v-select>
                        </v-form>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancel"> Batal </v-btn>
                    <v-btn color="blue darken-1" @click="dialogConfirmUpdate = true">Simpan</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="dialogConfirm" persistent max-width="400px">
            <v-card>
                <v-card-title>
                    <span class="headline">Hapus</span>
                </v-card-title>
                <v-card-text>Apakah anda yakin ingin menghapus transaksi ini?</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="dialogConfirm = false">Tidak</v-btn>
                    <v-btn color="blue darken-1" @click="deleteData">Ya</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

         <v-dialog v-model="dialogConfirmUpdate" persistent max-width="400px">
            <v-card>
                <v-card-title>
                    <span class="headline">Simpan</span>
                </v-card-title>
                <v-card-text>Apakah anda yakin ingin menyimpan transaksi ini?</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancel">Tidak</v-btn>
                    <v-btn color="blue darken-1" @click="setForm">Ya</v-btn>
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
            dialogConfirm: false,
            dialogConfirmUpdate: false,
            selectMobil: '',
            valid: false,
            itemsMobil: [],
            itemsPromo: [],
            itemsDriver: [],
            headers: [
                {text: "#", value: 'id_transaksi'},
                { text: "Nama Mobil", value: 'mobil.nama_mobil', align: "start", sortable: true},
                { text: "Jenis Peminjaman", value: 'jenis_peminjaman'},
                { text: "Tanggal Transaksi", value: 'tanggal_transaksi'},
                { text: "Tanggal Mulai Sewa", value: 'tanggal_mulai_sewa'},
                { text: "Tanggal Selesai Sewa", value: 'tanggal_selesai_sewa'},
                { text: "Tanggal Pengembalian", value: 'tanggal_pengembalian'},
                { text: "Total Pembayaran", value: 'total_pembayaran'},
                { text: "Kode Promo", value: 'promo.kode_promo'},
                { text: "Metode Pembayaran", value: 'metode_pembayaran'},
                { text: "Status Pembayaran", value: 'status_pembayaran'},
                { text: "Actions", value: 'actions'}
            ],

            rules: {
                nama_mobil  : [
                v => !!v || 'Nama Mobil tidak boleh kosong',
              ],
              jenis_peminjaman  : [
                v => !!v || 'Jenis Peminjaman tidak boleh kosong',
              ],
              tanggal_mulai_sewa  : [
                v => !!v || 'Tanggal Mulai Sewa tidak boleh kosong',
              ],
              tanggal_selesai_sewa : [
                v => !!v || 'Tanggal Akhir Sewa tidak boleh kosong',
              ],
              metode_pembayaran : [
                v => !!v || 'Metode Pembayaran tidak boleh kosong',
              ],
              kode_promo: [
                v => !!v || 'Kode Promo tidak boleh kosong',
              ],
            },

            itemsMetode: [
                {
                    text: "Tunai",
                    value: "Tunai",
                },
                {
                    text: "Transfer",
                    value: "Transfer",
                }
            ],

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

            form: {
                id_customer: localStorage.getItem('id_customer'),
                jenis_peminjaman: '',
                nama_driver: '',
                tanggal_transaksi : '',
                tanggal_mulai_sewa: '',
                tanggal_selesai_sewa: '',
                kode_promo: '',
                metode_pembayaran: '',
                tanggal_pengembalian: '',
                total_denda: '',
                total_tarif_driver: '',
                total_pembayaran : '',
                bukti_transfer : null,
                rating_driver_transaksi : '',
                id_driver: '',
                id_mobil: '',
                id_promo : '',
            },
            peminjaman: new FormData,
            peminjamans: [],
            editId: ''
        };
    },

    methods: {
        setForm() {
            if(this.$refs.form.validate()) {
                if(this.inputType !== 'Tambah') {
                    this.update();
                } else {
                    this.save();
                }
            }
        },

        readData() {
            var url = this.$api + '/showTransaksiBayar/' + localStorage.getItem('id_customer');
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.peminjamans = response.data.data;
            })
        },

        readDataMobil() {
            var url = this.$api + '/getMobil';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.itemsMobil = response.data.data;
            })
        },

        readDataPromo() {
            var url = this.$api + '/cekPromo/' + localStorage.getItem('id_customer');
            this.$http.get(url, {
                 headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.itemsPromo = response.data.data;
            })
        },

        readDataDriver() {
            var url = this.$api + '/driver'
            this.$http.get(url, {
                 headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.itemsDriver = response.data.data;
            })
        },

        save() {
            const today = new Date();
            const date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
            const time = today.getHours()+':'+today.getMinutes()+':'+today.getSeconds();
            const datetime  = date + ' ' + time;
            this.peminjaman.append('id_customer', this.form.id_customer);
            this.peminjaman.append('id_mobil', this.selectMobil.id_mobil ?? '');
            this.peminjaman.append('jenis_peminjaman', this.form.jenis_peminjaman);
            this.peminjaman.append('tanggal_mulai_sewa', this.form.tanggal_mulai_sewa);
            this.peminjaman.append('tanggal_selesai_sewa', this.form.tanggal_selesai_sewa);
            this.peminjaman.append('id_promo', this.form.kode_promo.id_promo ?? '');
            this.peminjaman.append('metode_pembayaran', this.form.metode_pembayaran);
            this.peminjaman.append('status_transaksi', 'Belum Terverifikasi');
            this.peminjaman.append('status_pembayaran', 'Belum Bayar');
            this.peminjaman.append('tanggal_transaksi', datetime);

            var url = this.$api + '/transaksi';
            this.load = true;
            this.$http.post(url, this.peminjaman, {
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
                this.load = false;
                this.snackbar = true;
                this.close();
                this.resetForm();
                this.readData();
            });
        },

        update() {
            let newData = {
                id_mobil : this.selectMobil.id_mobil ?? '',
                id_driver : this.form.nama_driver.id_driver ?? '',
                jenis_peminjaman : this.form.jenis_peminjaman,
                tanggal_transaksi : this.form.tanggal_transaksi,
                tanggal_mulai_sewa : this.form.tanggal_mulai_sewa,
                tanggal_selesai_sewa : this.form.tanggal_selesai_sewa,
                tanggal_pengembalian : this.form.tanggal_pengembalian,
                rating_driver_transaksi : this.form.rating_driver_transaksi,
                metode_pembayaran : this.form.metode_pembayaran,
                id_promo : this.form.kode_promo.id_promo ?? '',
            };

           

            var url = this.$api + '/updateCustomer/' + this.editId;
            this.load = true;
            this.$http.put(url, newData, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.error_message = response.data.message;
                this.color = "green";
                this.snackbar = true;
                this.load = false;
                this.close();
                this.readData();
                this.resetForm();
                this.inputType = 'Tambah';
            }).catch(error => {
                this.error_message = error.response.data.message;
                this.color = "red";
                this.snackbar = true;
                this.load = false;
                this.close();
                this.resetForm();
                this.readData();
            });


            if(this.form.bukti_transfer != null) {
                let item = new FormData();
                item.append('bukti_transfer', this.form.bukti_transfer);
                url = this.$api + '/updateBuktiTransfer/' + this.editId;
                this.load = true;
                this.$http.post(url, item, {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                }).then(response => {
                    this.error_message = response.data.message;
                    this.color = "green";
                    this.snackbar = true;
                    this.close();
                    this.readData();
                    this.resetForm();
                }).catch(error => {
                    this.error_message = error.response.data.message;
                     this.color = "red";
                    this.snackbar = true;
                    this.close();
                    this.readData();
                    this.resetForm();
                })
            }
        },

        deleteData() {
            var url = this.$api + '/transaksi/' + this.deleteId;
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
                this.readData();
                this.resetForm();
                this.inputType = 'Tambah';
            }).catch(error => {
                this.error_message = error.response.data.message;
                this.snackbar = true;
                this.color = "red";
                this.load = false;
            })
        }, 
        
        editHandler(item) {
            this.inputType = 'Ubah';
            this.editId = item.id_transaksi
            this.form.id_customer = item.id_customer;
            this.selectMobil = {
                id_mobil : item.mobil.id_mobil,
                nama_mobil : item.mobil.nama_mobil,
            };

            if(item.promo != null)
            {
                this.form.kode_promo = {
                    id_promo : item.promo.id_promo,
                    kode_promo : item.promo.kode_promo,
                };
            }

            if(item.driver != null) {
                this.form.nama_driver = {
                    id_driver : item.driver.id_driver,
                    nama_driver : item.driver.nama_driver,
                };
            }
            this.form.jenis_peminjaman = item.jenis_peminjaman;
            this.form.metode_pembayaran = item.metode_pembayaran;
            this.form.tanggal_transaksi = item.tanggal_transaksi;
            this.form.tanggal_mulai_sewa = item.tanggal_mulai_sewa;
            this.form.tanggal_selesai_sewa = item.tanggal_selesai_sewa;
            this.form.tanggal_pengembalian = item.tanggal_pengembalian;
            this.form.total_denda = item.total_denda;
            this.form.total_tarif_driver = item.total_tarif_driver;
            this.form.total_pembayaran = item.total_pembayaran;
            this.dialog = true;      
            this.form.rating_driver_transaksi = item.rating_driver_transaksi;      
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
           this.dialog = false;
            this.inputType = 'Tambah';
            this.dialogConfirm = false;
            this.dialogConfirmUpdate = false;
            this.readData();
            this.resetForm(); 
        },

        resetForm() {
            this.form = {
                id_customer : null,
                nama_mobil : null,
                jenis_peminjaman : null,
                tanggal_mulai_sewa : null,
                tanggal_selesai_sewa : null,
                metode_pembayaran : null,
                kode_promo : null,
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
        this.readDataPromo();
        this.readDataDriver();
    },
};
</script>