<template>
    <v-main class="list">
          <h3 class="text-h4 font-weight-bold mb-8 text-center text-decoration-underline"> Data Member</h3>

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

                <v-btn color="success" dark @click="dialog = true"> Tambah Member </v-btn>

            </v-card-title>
            <v-data-table :headers="headers" :items="members" :search="search">
                 

                <template v-slot:[`item.actions`]="{ item }"> 
                    <v-icon small class="mr-2" @click="editHandler(item)" color="primary">mdi-fountain-pen-tip</v-icon>
                    <v-icon small @click="deleteHandler(item.id_member)" color="error"> mdi-trash-can </v-icon>
                </template>

            </v-data-table>
        </v-card>

        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>

                <v-card-title class="red lighten-4 justify-center">
                    <span class="headline justify-center">{{ formTitle }} Member</span>
                </v-card-title>

                <v-card-text>
                    <v-container >
                        <!-- untuk validasi -->
                        <v-text-field v-model="form.nama_member" :rules="rules.nama_member" outlined dense label="Nama" required></v-text-field>
                        <v-text-field v-model="form.alamat_member" :rules="rules.alamat_member" outlined dense label="Alamat" required></v-text-field>

                        <v-dialog ref="dialog" v-model="modal" :return-value.sync="date" persistent width="290px">
                            <template v-slot:activator="{ on, attrs }">
                            <v-text-field v-model="form.tanggal_lahir_member" label="Tanggal Lahir" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" :rules="rules.tanggal_lahir_member" outlined dense></v-text-field>
                            </template>
                            <v-date-picker v-model="form.tanggal_lahir_member" scrollable>
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="modal = false"> Cancel </v-btn>
                            <v-btn text color="primary" @click="$refs.dialog.save(form.tanggal_lahir_member)"> OK </v-btn>
                            </v-date-picker>
                        </v-dialog>

                            <v-select v-model="form.jenis_kelamin_member" :items="['Pria', 'Wanita']" label="Jenis Kelamin" :rules="rules.jenis_kelamin_member" outlined dense required></v-select>

                            <v-text-field v-model="form.no_telp_member" :rules="rules.no_telp_member" outlined dense label="No Telp" required></v-text-field>
                            <v-text-field v-model="form.umur" :rules="rules.umur" outlined dense label="Umur" required></v-text-field>
                            <v-text-field v-model="form.email" :rules="rules.email" outlined dense label="Email" required></v-text-field>
                            <v-text-field v-model="form.username" :rules="rules.username" outlined dense label="Username" required></v-text-field>
                            <v-text-field v-model="form.password" :rules="rules.password" outlined dense label="Password" required></v-text-field>
                            <v-text-field v-model="form.sisa_deposit_uang" :rules="rules.sisa_deposit_uang" outlined dense label="Sisa Deposit Uang" required></v-text-field>
                            <v-text-field v-model="form.sisa_deposit_kelas" :rules="rules.sisa_deposit_kelas" outlined dense label="Sisa Deposit Kelas" required></v-text-field>
                            <v-text-field v-model="form.masa_berlaku" :rules="rules.masa_berlaku" outlined dense label="Masa Berlaku" required></v-text-field>
                            <v-text-field v-model="form.paket" :rules="rules.paket" outlined dense label="Paket" required></v-text-field>
                        <v-form v-model="valid" ref="form"> 
                            <v-select
                                v-model="form.status_member"
                                :items="['Sudah Terverifikasi', 'Belum Terverifikasi']"
                                label="Status"
                                :rules="rules.status_member"
                                outlined dense
                                required
                            ></v-select>                              
                        </v-form>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="cancel"> Batal </v-btn>
                <v-btn color="blue darken-1" text @click="dialogConfirmUpdate = true"> Simpan </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="dialogConfirm" persistent max-width="500px">
            <v-card>
                <v-card-title class="red accent-10 justify-center">
                <span>PERHATIAN!</span>
                </v-card-title>
                <v-card-text style="margin-top: 5%"> Yakin ingin menghapus member ini? </v-card-text>

                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="dialogConfirm = false"> Batal </v-btn>
                <v-btn color="red darken-1" text @click="deleteData"> Hapus </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="dialogConfirmUpdate" persistent max-width="500px">
        <v-card>
            <v-card-title class="blue lighten-4 justify-center">
            <span>PERHATIAN!</span>
            </v-card-title>
            <v-card-text style="margin-top: 5%"> Anda yakin menyimpan data ini? </v-card-text>

            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="dialogConfirmUpdate = false"> Tidak </v-btn>
            <v-btn color="red darken-1" text @click="setForm"> Ya </v-btn>
            </v-card-actions>
        </v-card>
        </v-dialog>

        <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>{{ error_message }}</v-snackbar>
    </v-main>
</template>

<script>
export default {
    name: "Member",
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
                { text: "ID Member", value: 'id_member'},
                { text: "Nama", value: 'nama_member', align: "start",sortable: true,},
                { text: "Alamat", value: 'alamat_member'},
                { text: "Tanggal Lahir", value: 'tanggal_lahir_member'},
                { text: "Jenis Kelamin", value: 'jenis_kelamin_member'},
                { text: "No Telp", value: 'no_telp_member'},
                { text: "Umur", value: 'umur'},
                { text: "Email", value: 'email'},
                { text: "Username", value: 'username'},
                { text: "Password", value: 'password'},
                { text: "Sisa Deposit Uang", value: 'sisa_deposit_uang'},
                { text: "Sisa Deposit Kelas", value: 'sisa_deposit_kelas'},
                { text: "Masa Berlaku", value: 'masa_berlaku'},
                { text: "Paket", value: 'paket'},
                { text: "Status", value: 'status_member'},
                { text: "Actions", value: 'actions'},
            ],
            //
            rules: {
                nama_member: [(v) => !!v || 'Nama Member is required'],
                alamat_member: [(v) => !!v || 'Alamat Member is required'],
                tanggal_lahir_member: [(v) => !!v || 'Tanggal Lahir is required'],
                jenis_kelamin_member: [(v) => !!v || 'Jenis Kelamin is required'],
                no_telp_member: [(v) => !!v || 'No Telp is required'],
                umur: [(v) => !!v || 'Umur is required'],
                email: [(v) => !!v || 'Email is required'],
                username: [(v) => !!v || 'Username is required'],
                password: [(v) => !!v || 'Password is required'],
                sisa_deposit_uang: [(v) => !!v || 'Sisa Deposit Uang is required'],
                sisa_deposit_kelas: [(v) => !!v || 'Sisa Deposit Kelas is required'],
                masa_berlaku: [(v) => !!v || 'Masa Berlaku is required'],
                paket: [(v) => !!v || 'Paket is required'],
                status_member  : [v => !!v || 'Status is required'],
                
            },
         
            member: new FormData,
            members: [],
            form: {
                nama_member: null,
                alamat_member: null,
                tanggal_lahir_member: null,
                jenis_kelamin_member: null,
                no_telp_member: null,
                umur: null,
                email: null,
                username: null,
                password: null,
                sisa_deposit_uang: null,
                sisa_deposit_kelas: null,
                masa_berlaku: null,
                paket: null,
                status_member: null,
            },
            // untuk tanggal
            modal: false,
            tanggal_lahir_member: new Date().toISOString().substr(0, 10),
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
            var url = this.$api + '/member';
            this.$http.get(url, {
                headers: {
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.members = response.data.data;
            })
        },
    
        save() {
            this.member.append('nama_member', this.form.nama_member);
            this.member.append('alamat_member', this.form.alamat_member);
            this.member.append('tanggal_lahir_member', this.form.tanggal_lahir_member);
            this.member.append('jenis_kelamin_member', this.form.jenis_kelamin_member);
            this.member.append('no_telp_member', this.form.no_telp_member);
            this.member.append('umur', this.form.umur);
            this.member.append('email', this.form.email);
            this.member.append('username', this.form.username);
            this.member.append('password', this.form.password);
            this.member.append('sisa_deposit_uang', this.form.sisa_deposit_uang);
            this.member.append('sisa_deposit_kelas', this.form.sisa_deposit_kelas);
            this.member.append('masa_berlaku', this.form.masa_berlaku);
            this.member.append('paket', this.form.paket);
            this.member.append('status_member', this.form.status_member);

            var url = this.$api +'/member'
            
            this.load = true;
            this.$http.post(url, this.member, {
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
                nama_member: this.form.nama_member,
                alamat_member: this.form.alamat_member,
                tanggal_lahir_member: this.form.tanggal_lahir_member,
                jenis_kelamin_member: this.form.jenis_kelamin_member,
                no_telp_member: this.form.no_telp_member,
                umur: this.form.umur,
                email: this.form.email,
                username: this.form.username,
                password: this.form.password,
                sisa_deposit_uang: this.form.sisa_deposit_uang,
                sisa_deposit_kelas: this.form.sisa_deposit_kelas,
                masa_berlaku: this.form.masa_berlaku,
                paket: this.form.paket,
                status_member: this.form.status_member,

                id_role: 'Member'
            };
            // var url = this.$api + '/updateStatus/' + this.editId;
            var url = this.$api + '/member/' + this.editId;
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
        deleteData() {
        //menghapus data
        var url = this.$api + '/member' + this.deleteId;
        this.load = true;
        this.$http
            .delete(url, {
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            }
            })
            .then((response) => {
            this.error_message = response.data.message;
            this.color = "green";
            this.snackbar = true;
            this.load = false;
            this.close();
            this.readData(); // baca data
            this.resetForm();
            this.inputType = 'Tambah';
            })
            .catch((error) => {
            this.error_message = error.response.data.message;
            this.color = "red";
            this.snackbar = true;
            this.load = false;
            });
        },
        editHandler(item) {
            this.inputType = 'Ubah';
            this.editId = item.id_member;
            this.form.nama_member = item.nama_member;
            this.form.alamat_member = item.alamat_member;
            this.form.tanggal_lahir_member = item.tanggal_lahir_member;
            this.form.jenis_kelamin_member = item.jenis_kelamin_member;
            this.form.no_telp_member = item.no_telp_member;
            this.form.umur = item.umur;
            this.form.email = item.email;
            this.form.username = item.username;
            this.form.password = item.password;
            this.form.sisa_deposit_uang = item.sisa_deposit_uang;
            this.form.sisa_deposit_kelas = item.sisa_deposit_kelas;
            this.form.masa_berlaku = item.masa_berlaku;
            this.form.paket = item.paket;
            this.form.status_member= item.status_member;
            this.dialog = true;
        },
        deleteHandler(id) {
            this.deleteId = id;
            this.dialogConfirm = true;
        },
        close() {
            this.dialog = false;
            this.inputType = 'Tambah';
            this.dialogConfirmUpdate = false;
            this.dialogConfirm = false;
            this.readData();
        },
        cancel() {
            this.resetForm();
            this.readData();
            this.dialog = false;
            this.dialogConfirmUpdate = false;
            this.dialogConfirm  = false;
            this.inputType = 'Tambah';
        },
        resetForm() {
            this.form = { 
                nama_member: null,
                alamat_member: null,
                tanggal_lahir_member: null,
                jenis_kelamin_member: null,
                no_telp_member: null,
                umur: null,
                email: null,
                username: null,
                password: null,
                sisa_deposit_uang: null,
                sisa_deposit_kelas: null,
                masa_berlaku: null,
                paket: null,
                status_member: null,

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
