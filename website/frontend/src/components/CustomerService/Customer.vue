<template>
    <v-main class="list">
          <h3 class="text-h4 font-weight-bold mb-8 text-center text-decoration-underline"> Data Customer</h3>

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
            <v-data-table :headers="headers" :items="customers" :search="search">
                 

                <template v-slot:[`item.actions`]="{ item }"> 
                    <v-icon small class="mr-2" @click="editHandler(item)" color="primary">mdi-fountain-pen-tip</v-icon>
                </template>

                <!-- Untuk gambar -->
                <template v-slot:[`item.foto_customer`]="{ item }">
                    <td>
                    <img :src=" $image + '/source_fotoCustomer/' + item.foto_customer" width="100">
                    </td>
                </template>

                 <template v-slot:[`item.ktp_customer`]="{ item }">
                    <td>
                    <img :src="$image + '/source_ktpCustomer/' + item.ktp_customer" width="100">
                    </td>
                </template>

                 <template v-slot:[`item.sim_customer`]="{ item }">
                    <td>
                    <img v-if="item.sim_customer != null" :src=" $image + '/source_simCustomer/' + item.sim_customer" width="100">
                    </td>
                </template>

            </v-data-table>
        </v-card>

        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>

                <v-card-title class="red lighten-4 justify-center">
                    <span class="headline justify-center">{{ formTitle }} Customer</span>
                </v-card-title>

                <v-card-text>
                    <v-container >
                        <!-- untuk validasi -->
                        <v-form v-model="valid" ref="form"> 
                             <v-select
                                v-model="form.status_customer"
                                :items="['Sudah Terverifikasi', 'Belum Terverifikasi']"
                                label="Status"
                                :rules="rules.status_customer"
                                outlined dense
                                required
                            ></v-select>                              
                        </v-form>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancel"> Cancel </v-btn>
                    <v-btn color="blue darken-1" text @click="setForm"> Save </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>{{ error_message }}</v-snackbar>
    </v-main>
</template>

<script>
export default {
    name: "Customer",
    data() {
        return {
            inputType: 'Tambah',
            load: false,
            snackbar: false,
            error_message: '',
            color: '',
            search: null,
            dialog: false,
            valid:false,
            headers: [
                { text: "ID Customer", value: 'id_customer'},
                { text: "Nama", value: 'nama_customer', align: "start",sortable: true,},
                { text: "Alamat", value: 'alamat_customer'},
                { text: "Tanggal Lahir", value: 'tanggal_lahir'},
                { text: "Jenis Kelamin", value: 'jenis_kelamin_customer'},
                { text: "No Telp", value: 'no_telp_customer'},
                { text: "Foto", value: 'foto_customer'},
                { text: "KTP / Kartu Pelajar", value: 'ktp_customer'},
                { text: "SIM", value: 'sim_customer'},
                { text: "Email", value: 'email'},
                { text: "Status", value: 'status_customer'},
                { text: "Actions", value: 'actions'},
            ],
            //
            rules: {
              status_customer  : [
                v => !!v || 'Status is required',
              ],
             
            },
         
            customer: new FormData,
            customers: [],
            form: {
                status_customer: null,
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
            var url = this.$api + '/customer';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.customers = response.data.data;
            })
        },
    
        save() {
            
            this.customer.append('status_customer', this.form.status_customer);

            var url = this.$api +'/customer'
            
            this.load = true;
            this.$http.post(url, this.customer, {
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
                status_customer: this.form.status_customer,
            };
            var url = this.$api + '/updateStatus/' + this.editId;
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
            this.editId = item.id_customer;
            this.form.status_customer= item.status_customer;
            this.dialog = true;
        },
        close() {
            this.dialog = false;
            this.inputType = 'Tambah';
            this.dialogConfirm = false;
            this.readData();
        },
        cancel() {
            this.resetForm();
            this.readData();
            this.dialog = false;
            this.dialogConfirm  = false;
            this.inputType = 'Tambah';
        },
        resetForm() {
            this.form = { 
                status_customer : null,
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
