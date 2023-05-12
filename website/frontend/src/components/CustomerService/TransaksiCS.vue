<template>
    <v-main class="list">
          <h3 class="text-h4 font-weight-bold mb-8 text-center text-decoration-underline"> Data Transaksi Customer </h3>

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
            <v-data-table :headers="headers" :items="peminjamans" :search="search">
                 

                <template v-slot:[`item.actions`]="{ item }"> 
                    <v-icon small class="mr-2" @click="editHandler(item)" color="primary">mdi-details</v-icon>
                </template>

                <!-- Untuk gambar -->
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

                <v-card-title class="red lighten-4 justify-center">
                    <span class="headline justify-center">{{ formTitle }} Peminjaman</span>
                </v-card-title>

                <v-card-text>
                    <v-container>
                        <v-form v-model="valid" ref="form">
                            <v-text-field v-model="form.nama_pegawai" :rules="id_customer" label="Nama Pegawai"  outlined dense readonly></v-text-field>

                            <v-text-field v-model="form.nama_customer" :rules="id_customer" label="Nama Customer"  outlined dense readonly></v-text-field>

                            <v-select v-model="form.nama_mobil" :items="itemsMobil" item-text="nama_mobil" item-value="id_mobil" :rules="nama_mobil" label="Nama Mobil" required outlined dense persistent-hint return-object single-line readonly></v-select>

                            <v-select v-model="form.jenis_peminjaman" :items="itemsJenis" item-text="text" item-value="value" :rules="jenis_peminjaman" label="Jenis Peminjaman" required outlined dense readonly ></v-select>

                             <v-select v-model="form.nama_driver" v-if="form.jenis_peminjaman == 'Mobil + Driver'" :items="itemsDriver" item-text="nama_driver" item-value="id_driver" label="Nama Driver" outlined dense persistent-hint return-object single-line></v-select>

                             <v-text-field v-model="form.tanggal_transaksi" type="datetime-local" label="Tanggal Transaksi" :rules="tanggal_transaksi" required outlined dense readonly></v-text-field>

                            <v-text-field v-model="form.tanggal_mulai_sewa" type="datetime-local" label="Tanggal Mulai Sewa" :rules="tanggal_mulai_sewa" required outlined dense readonly></v-text-field>

                            <v-text-field v-model="form.tanggal_selesai_sewa" type="datetime-local" label="Tanggal Selesai Sewa" :rules="tanggal_selesai_sewa" required outlined dense readonly></v-text-field>

                            <v-text-field v-model="form.tanggal_pengembalian" type="datetime-local" label="Tanggal Pengembalian" :rules="tanggal_pengembalian" required outlined dense readonly></v-text-field>

                            <v-select v-model="form.status_transaksi" :items="itemsStatusTransaksi" item-text="text" item-value="value" label="Status Transaski" outlined dense readonly></v-select>

                            <v-select  v-model="form.kode_promo" :items="itemsPromo" item-text="kode_promo" item-value="id_promo" :rules="kode_promo" label="Kode Promo" required outlined dense persistent-hint return-object single-line readonly></v-select>

                            <v-text-field v-model="form.subtotal_pembayaran" label="Subtotal Pembayaran" :rules="subtotal_pembayaran" prefix="Rp. " required outlined dense readonly></v-text-field>

                            <v-text-field v-model="form.total_denda" label="Total Denda" :rules="total_denda" prefix="Rp. " required outlined dense readonly></v-text-field>

                            <v-text-field v-model="form.total_promo" label="Total Promo" :rules="total_promo" prefix="Rp. " required outlined dense readonly></v-text-field>

                            <v-text-field v-model="form.total_tarif_driver" label="Total Tarif Driver" :rules="total_tarif_driver" prefix="Rp. " required outlined dense readonly></v-text-field>

                             <v-text-field v-model="form.total_pembayaran" label="Total Pembayaran" :rules="total_pembayaran" prefix="Rp. " required outlined dense readonly></v-text-field>

                            <v-select v-model="form.metode_pembayaran" :items="itemsMetode" item-text="text" item-value="value" :rules="metode_pembayaran" label="Metode Pembayaran" required outlined dense readonly></v-select>

                            <v-select v-model="form.status_pembayaran" :items="itemsStatusPembayaran" item-text="text" item-value="value" label="Status Pembayaran" outlined dense readonly></v-select>

                             <span v-if="form.jenis_peminjaman == 'Mobil + Driver'" class="text-caption text-uppercase text-center" >Rating Driver</span> 
                            <v-rating v-model="form.rating_driver_transaksi" v-if="form.jenis_peminjaman == 'Mobil + Driver'" color="yellow darken-3" align="center" background-color="grey darken-1" empty-icon="$ratingFull" half-increments hover large readonly>
                    </v-rating>
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
            dialogConfirmUpdate: false,
            dialogConfirm: false,
            valid:false,
            itemsMobil: [],
            itemsPromo: [],
            itemsDriver: [],
            headers: [
                { text: "#", value: 'id_transaksi'},
                { text: "Nama", value: 'customer.nama_customer'},
                { text: "Tanggal Transaksi", value: 'tanggal_transaksi'},
                { text: "Tanggal Mulai Sewa", value: 'tanggal_mulai_sewa' },
                { text: "Tanggal Akhir Sewa", value: 'tanggal_selesai_sewa'},     
                { text: "Tanggal Pembelian", value: 'tanggal_pengembalian'},
                { text: "Rating Driver Transaksi", value: 'rating_driver_transaksi' },
                { text: "Bukti Transfer", value: 'bukti_transfer'},
                { text: "Actions", value: 'actions'},
            ],
            //
            rules: {
              status  : [
                v => !!v || 'Status is required',
              ],
            },
         
            peminjaman: new FormData,
            peminjamans: [],
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
                nama_customer: '',
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
            var url = this.$api + '/transaksi';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.peminjamans = response.data.data;
            })
        },

        readDataPromo() {
            var url = this.$api + '/promo';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.itemsPromo = response.data.data;
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
     
        save() {
            this.peminjaman.append('status', this.form.status);

            var url = this.$api +'/transaksiPeminjaman'
            
            this.load = true;
            this.$http.post(url, this.peminjaman, {
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
                id_pegawai: this.form.id_pegawai,
                status: this.form.status,
            };
            var url = this.$api + '/updateStatusTransaksi/' + this.editId;
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
        
        editHandler(item) {
            this.inputType = 'Ubah';
           this.editId = item.id_transaksi;
           this.form.nama_customer = item.customer.nama_customer;
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
            this.dialogConfirmUpdate =false,
            this.dialogConfirm  = false;
            this.inputType = 'Tambah';
        },
        resetForm() {
            this.form = { 
                id_customer: null,
                status:null,
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
        this.readDataPromo();
        this.readDataMobil();
        this.readDataDriver();
    },
};
</script>
