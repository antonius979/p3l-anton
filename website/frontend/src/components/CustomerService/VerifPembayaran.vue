<template>
    <v-main class="list">
          <h3 class="text-h4 font-weight-bold mb-8 text-center text-decoration-underline"> Verifikasi Pembayaran </h3>

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
                    <v-icon small class="mr-2" @click="editHandler(item)" color="primary">mdi-fountain-pen-tip</v-icon>
                </template>

                 <template v-slot:[`item.bukti_transfer`]="{ item }">
                    <td>
                    <img v-if="item.bukti_transfer != null" :src=" $image + '/source_buktiTransfer/' + item.bukti_transfer" width="100">
                    </td>
                </template>

            </v-data-table>
        </v-card>

        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>

                <v-card-title class="red lighten-4 justify-center">
                    <span class="headline justify-center">{{ formTitle }} Pembayaran</span>
                </v-card-title>

                <v-card-text>
                    <v-container >
                        <!-- untuk validasi -->
                        <v-form v-model="valid" ref="form"> 

                                <v-text-field v-model="form.nama_customer" outlined dense label="Nama Customer" readonly></v-text-field>

                                <v-select v-model="form.nama_mobil" :items="itemsMobil" item-text="nama_mobil" item-value="id_mobil" :rules="nama_mobil" label="Nama Mobil" outlined dense required return-object persistent-hint readonly></v-select>

                                <v-select v-model="form.kode_promo" :items="itemsPromo" item-text="kode_promo" item-value="id_promo" :rules="nama_mobil" label="Kode Promo" outlined dense required return-object persistent-hint readonly></v-select>

                                <v-select v-model="form.jenis_peminjaman" label="Jenis Peminjaman" :items="itemsJenis" item-text="text" item-value="value"  :rules="jenis_peminjaman" 
                                outlined dense readonly></v-select>
                                
                                <v-text-field v-model="form.tanggal_transaksi" type="datetime-local" label="Tanggal Transaksi" outlined dense readonly></v-text-field>

                                <v-text-field v-model="form.tanggal_pengembalian" type="datetime-local" label="Tanggal Pengembalian" outlined dense required :rules="tanggal_pengembalian"></v-text-field>

                                <v-select v-model="form.metode_pembayaran" :items="itemsMetode" item-text="text" item-value="value" label="Metode Pembayaran" outlined dense readonly></v-select>

                                <v-select v-model="form.status_pembayaran" :items="itemsStatus" item-text="text" item-value="value" label="Status Pembayaran" outlined dense></v-select>
                              
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
            itemsPromo: [],
            itemsMobil: [],
            headers: [
                { text: "#", value: 'id_transaksi'},
                { text: "Nama", value: 'customer.nama_customer'},
                { text: "Nama Mobil", value: 'mobil.nama_mobil' , align: "start",sortable: true,},
                { text: "Jenis Peminjaman", value: 'jenis_peminjaman'},
                { text: "Tanggal Transaksi", value: 'tanggal_transaksi'},
                { text: "Tanggal Mulai Sewa", value: 'tanggal_mulai_sewa' },
                { text: "Tanggal Pengembalian", value: 'tanggal_pengembalian'},
                { text: "Metode Pembayaran", value: 'metode_pembayaran'},
                { text: "Kode Promo", value: 'promo.kode_promo'},
                { text: "Total Denda", value: 'total_denda'},
                { text: "Total Tarif Driver", value: 'total_tarif_driver'},
                { text: "Total Promo", value: 'total_promo'},
                { text: "Subtotal Pembayaran", value: 'subtotal_pembayaran'},
                { text: "Total Pembayaran", value: 'total_pembayaran'},                
                { text: "Bukti Pembayaran", value: 'bukti_transfer'},
                { text: "Status Bayar", value: 'status_pembayaran'},
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
            form: {
                nama_customer : '',
                nama_mobil : '',
                kode_promo : '',
                jenis_peminjaman : '',
                tanggal_transaksi : '',
                tanggal_pengembalian : '',
                metode_pembayaran : '',
                status_pembayaran : '',
                id_driver : '',
                id_mobil: '',
                id_promo: '',
                tanggal_selesai_sewa: '',
                tanggal_mulai_sewa : ''
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

            itemsStatus: [
                {
                    text: "Belum Bayar",
                    value: "Belum Bayar",
                },
                {
                    text: "Sudah Bayar",
                    value: "Sudah Bayar",
                }
            ],
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
            var url = this.$api + '/transaksiVerifBayar';
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
                id_mobil : this.form.nama_mobil.id_mobil ?? '', 
                id_driver : this.form.id_driver,
                id_promo : this.form.kode_promo.id_promo ?? '',
                jenis_peminjaman : this.form.jenis_peminjaman,
                tanggal_transaksi : this.form.tanggal_transaksi,
                tanggal_pengembalian : this.form.tanggal_pengembalian,
                metode_pembayaran : this.form.metode_pembayaran,
                status_pembayaran : this.form.status_pembayaran,
                tanggal_selesai_sewa: this.form.tanggal_selesai_sewa,
                tanggal_mulai_sewa : this.form.tanggal_mulai_sewa,
            };
            var url = this.$api + '/transaksiBayar/' + this.editId;
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
                this.close();
                this.readData(); // baca data
                this.resetForm();
            })
        },
        
        editHandler(item) {
            this.inputType = 'Ubah';
            this.editId = item.id_transaksi;
            this.form.nama_customer = item.customer.nama_customer;
            this.form.nama_mobil = {
                id_mobil : item.mobil.id_mobil,
                nama_mobil : item.mobil.nama_mobil
            };

            if(item.promo !== null) {
                this.form.kode_promo = {
                    id_promo : item.promo.id_promo,
                    kode_promo : item.promo.kode_promo,
                };
            }

            this.form.jenis_peminjaman = item.jenis_peminjaman;
            this.form.tanggal_transaksi = item.tanggal_transaksi;
            this.form.tanggal_pengembalian = item.tanggal_pengembalian;
            this.form.metode_pembayaran = item.metode_pembayaran;
            this.form.status_pembayaran = item.status_pembayaran;
            this.form.id_driver = item.id_driver;
            this.form.tanggal_selesai_sewa = item.tanggal_selesai_sewa;
            this.form.tanggal_mulai_sewa = item.tanggal_mulai_sewa;
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
        this.readDataMobil();
        this.readDataPromo();
    },
};
</script>
