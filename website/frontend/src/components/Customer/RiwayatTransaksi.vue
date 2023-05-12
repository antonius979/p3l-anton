<template>
    <v-main class="list">
        <h3 class="text-h4 font-weight-bold mb-8 text-center tex-decoration-underline">Riwayat Transaksi</h3>

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

                <template v-slot:[`item.bukti_transfer`]="{ item }">
                    <td>
                    <img v-if="item.bukti_transfer != null" :src=" $image + '/source_buktiTransfer/' + item.bukti_transfer" width="100">
                    </td>
                </template>

                <template v-slot:[`item.rating_driver_transaksi`]="{ item }">
                        <v-rating v-if="item.jenis_peminjaman == 'Mobil + Driver'" v-model="item.rating_driver_transaksi" color="yellow darken-3" align="center" background-color="grey darken-1" medium readonly empty-icon="$ratingFull" half-increments></v-rating>
                    </template>
            </v-data-table>
        </v-card>

        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-card-title class="red lighten-4 justify-center">Detail Riwayat Transaksi</v-card-title>

                <v-card-text>
                    <v-container>
                        <v-form v-model="valid" ref="form">
                            <v-text-field v-model="form.nama_pegawai" :rules="id_customer" label="Nama Pegawai"  outlined dense readonly></v-text-field>

                            <v-select v-model="form.nama_mobil" :items="itemsMobil" item-text="nama_mobil" item-value="id_mobil" :rules="nama_mobil" label="Nama Mobil" required outlined dense persistent-hint return-object single-line readonly></v-select>

                            <v-select v-model="form.jenis_peminjaman" :items="itemsJenis" item-text="text" item-value="value" :rules="jenis_peminjaman" label="Jenis Peminjaman" required outlined dense readonly ></v-select>

                             <v-select v-model="form.nama_driver" v-if="form.jenis_peminjaman == 'Mobil + Driver'" :items="itemsDriver" item-text="nama_driver" item-value="id_driver" label="Nama Driver" outlined dense persistent-hint return-object single-line></v-select>

                             <v-text-field v-model="form.tanggal_transaksi" type="datetime-local" label="Tanggal Transaksi" :rules="tanggal_transaksi" required outlined dense readonly></v-text-field>

                            <v-text-field v-model="form.tanggal_mulai_sewa" type="datetime-local" label="Tanggal Mulai Sewa" :rules="tanggal_mulai_sewa" required outlined dense readonly></v-text-field>

                            <v-text-field v-model="form.tanggal_selesai_sewa" type="datetime-local" label="Tanggal Selesai Sewa" :rules="tanggal_selesai_sewa" required outlined dense readonly></v-text-field>

                            <v-text-field v-model="form.tanggal_pengembalian" type="datetime-local" label="Tanggal Pengembalian" :rules="tanggal_pengembalian" required outlined dense readonly></v-text-field>

                            <v-select v-model="form.status_transaksi" :items="itemsStatusTransaksi" item-text="text" item-value="value" label="Status Transaski" outlined dense readonly></v-select>

                            <v-select v-model="form.kode_promo" :items="itemsPromo" item-text="kode_promo" item-value="id_promo" :rules="kode_promo" label="Kode Promo" required outlined dense persistent-hint return-object single-line readonly></v-select>

                            <v-text-field v-model="form.subtotal_pembayaran" label="Subtotal Pembayaran" :rules="subtotal_pembayaran" prefix="Rp. " required outlined dense readonly></v-text-field>

                            <v-text-field v-model="form.total_denda" label="Total Denda" :rules="total_denda" prefix="Rp. " required outlined dense readonly></v-text-field>

                            <v-text-field v-model="form.total_promo" label="Total Promo" :rules="total_promo" prefix="Rp. " required outlined dense readonly></v-text-field>

                            <v-text-field v-model="form.total_tarif_driver" label="Total Tarif Driver" :rules="total_tarif_driver" prefix="Rp. " required outlined dense readonly></v-text-field>

                             <v-text-field v-model="form.total_pembayaran" label="Total Pembayaran" :rules="total_pembayaran" prefix="Rp. " required outlined dense readonly></v-text-field>

                            <v-select v-model="form.metode_pembayaran" :items="itemsMetode" item-text="text" item-value="value" :rules="metode_pembayaran" label="Metode Pembayaran" required outlined dense readonly></v-select>

                            <v-select v-model="form.status_pembayaran" :items="itemsStatusPembayaran" item-text="text" item-value="value" label="Status Pembayaran" outlined dense readonly></v-select>

                             <span v-if="form.jenis_peminjaman == 'Mobil + Driver'" class="text-caption text-uppercase text-center" >Rating Driver</span> 
                            <v-rating v-model="form.rating_driver_transaksi" v-if="form.jenis_peminjaman == 'Mobil + Driver'" color="yellow darken-3" align="center" background-color="grey darken-1" empty-icon="$ratingFull" half-increments hover large>
                    </v-rating>
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
                { text: "Status Transaksi", value: 'status_transaksi'},
                { text: "Kode Promo", value: 'promo.kode_promo'},
                { text: "Metode Pembayaran", value: 'metode_pembayaran'},
                { text: "Bukti Pembayaran", value: 'bukti_transfer'},
                { text: "Status Pembayaran", value: 'status_pembayaran'},
                { text: "Rating Driver", value: 'rating_driver_transaksi'},
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

            itemsStatusPembayaran: [
                {
                    text: "Belum Bayar",
                    value: "Belum Bayar",
                },
                {
                    text: "Sudah Bayar",
                    value: "Sudah Bayar",
                }
            ],

            itemsStatusTransaksi: [
                {
                    text: "Belum Terverifikasi",
                    value: "Belum Terverifikasi",
                },
                {
                    text: "Sudah Terverifikasi",
                    value: "Sudah Terverifikasi",
                }
            ],

            form: {
                nama_pegawai : '',
                nama_mobil : '',
                jenis_peminjaman : '', 
                nama_driver : '',
                tanggal_transaksi : '',
                tanggal_mulai_sewa : '',
                tanggal_selesai_sewa : '',
                tanggal_pengembalian : '',
                status_transaksi : '',
                kode_promo : '',
                subtotal_pembayaran : '',
                total_denda : '',
                total_promo : '',
                total_tarif_driver : '',
                total_pembayaran : '',
                metode_pembayaran : '',
                status_pembayaran : '',
                rating_driver_transaksi : '',
            },
            peminjaman: new FormData,
            peminjamans: [],
            deleteId: '',
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
            var url = this.$api + '/showTransaksiAll/' + localStorage.getItem('id_customer');
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
            var url = this.$api + '/driver';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.itemsDriver = response.data.data;
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
                id_mobil : this.form.nama_mobil.id_mobil ?? '',
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
        
        editHandler(item) {
            this.inputType = 'Ubah';
            this.editId = item.id_transaksi
            this.form.nama_pegawai = item.pegawai.nama_pegawai;
            this.form.nama_mobil = {
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

            if(item.driver != null)
            {
                this.form.nama_driver = {
                    id_driver : item.driver.id_driver,
                    nama_driver : item.driver.nama_driver,
                };
            }
            this.form.jenis_peminjaman = item.jenis_peminjaman;
            this.form.metode_pembayaran = item.metode_pembayaran;
            this.form.tanggal_mulai_sewa = item.tanggal_mulai_sewa;
            this.form.tanggal_selesai_sewa = item.tanggal_selesai_sewa;
            this.form.tanggal_transaksi = item.tanggal_transaksi;
            this.form.tanggal_pengembalian = item.tanggal_pengembalian;
            this.form.status_pembayaran = item.status_pembayaran;
            this.form.status_transaksi = item.status_transaksi;
            this.form.total_denda = item.total_denda;
            this.form.total_promo = item.total_promo;
            this.form.total_tarif_driver = item.total_tarif_driver;
            this.form.subtotal_pembayaran = item.subtotal_pembayaran;
            this.form.total_pembayaran =item.total_pembayaran;
            this.form.rating_driver_transaksi = item.rating_driver_transaksi;
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