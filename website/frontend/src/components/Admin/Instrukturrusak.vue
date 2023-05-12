<template>
  <v-main class="list">
    <h3 class="text-h4 font-weight-bold mb-8 text-center text-decoration-underline">Data Instruktur</h3>

    <v-card>
      <v-card-title>
        <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details> </v-text-field>

        <v-spacer></v-spacer>

        <v-btn color="success" dark @click="dialog = true"> Tambah Instruktur </v-btn>
      </v-card-title>
      <v-data-table :headers="headers" :items="intrukturs" :search="search">
        <!-- Untuk mengubah warna status 
                <template v-slot:[`item.status_ketersediaan_driver`]="{ item }">
                    <v-chip
                        :color="getColor(item.status_ketersediaan_driver)"
                        dark
                        outlined
                    >
                    {{ item.status_ketersediaan_driver }}
                    </v-chip>
                </template> -->

        <template v-slot:[`item.actions`]="{ item }">
          <v-icon small class="mr-2" @click="editHandler(item)" color="primary">mdi-fountain-pen-tip</v-icon>
          <v-icon small @click="deleteHandler(item.id_instruktur)" color="error"> mdi-trash-can </v-icon>
        </template>
      </v-data-table>
    </v-card>

    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title class="blue lighten-4 justify-center">
          <span class="headline justify-center">{{ formTitle }} Instruktur</span>
        </v-card-title>

        <v-card-text>
          <v-container>
            <!-- untuk validasi -->
            <v-form v-model="valid" ref="form">
              <v-text-field v-model="form.nama_instruktur" :rules="rules.nama_instruktur" outlined dense label="Nama" required></v-text-field>
              <v-text-field v-model="form.alamat_instruktur" :rules="rules.alamat_instruktur" outlined dense label="Alamat" required></v-text-field>

              <v-dialog ref="dialog" v-model="modal" :return-value.sync="date" persistent width="290px">
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field v-model="form.tanggal_lahir_instruktur" label="Tanggal Lahir" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" :rules="rules.tanggal_lahir_instruktur" outlined dense></v-text-field>
                </template>
                <v-date-picker v-model="form.tanggal_lahir_instruktur" scrollable>
                  <v-spacer></v-spacer>
                  <v-btn text color="primary" @click="modal = false"> Cancel </v-btn>
                  <v-btn text color="primary" @click="$refs.dialog.save(form.tanggal_lahir_instruktur)"> OK </v-btn>
                </v-date-picker>
              </v-dialog>

              <v-select v-model="form.jenis_kelamin_instruktur" :items="['Pria', 'Wanita']" label="Jenis Kelamin" :rules="rules.jenis_kelamin_instruktur" outlined dense required></v-select>

              <v-text-field v-model="form.no_telp_instruktur" :rules="rules.no_telp_instruktur" outlined dense label="No Telp" required></v-text-field>
              <v-text-field v-model="form.email" :rules="rules.email" outlined dense label="Email" required></v-text-field>
              <v-text-field v-model="form.username" :rules="rules.username" outlined dense label="Username" required></v-text-field>
              <v-text-field v-model="form.password" :rules="rules.password" outlined dense label="Password" required></v-text-field>
              <v-text-field v-model="form.waktu_terlambat" :rules="rules.waktu_terlambat" outlined dense label="Waktu_Terlambat" required></v-text-field>
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
        <v-card-text style="margin-top: 5%"> Yakin ingin menghapus instruktur ini? </v-card-text>

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
  name: "Instruktur",
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
      headers: [
        { text: "ID Instruktur", value: 'id_instruktur' },
        { text: "Nama", value: 'nama_instruktur', align: "start", sortable: true },
        { text: "Alamat", value: 'alamat_instruktur'},
        { text: "Tanggal Lahir", value: 'tanggal_lahir_instruktur'},
        { text: "Jenis Kelamin", value: 'jenis_kelamin_instruktur'},
        { text: "No Telp", value: 'no_telp_instruktur'},
        { text: "Email", value: 'email'},
        { text: "Username", value: 'username'},
        { text: "Password", value: 'password'},
        { text: "Waktu Terlambat", value: 'waktu_terlambat'},
        { text: "Actions", value: 'actions'},
      ],
      //
      rules: {
        nama_instruktur: [(v) => !!v || 'Nama Instruktur is required'],
        alamat_instruktur: [(v) => !!v || 'Alamat Instruktur is required'],
        tanggal_lahir_instruktur: [(v) => !!v || 'Tanggal Lahir is required'],
        jenis_kelamin_instruktur: [(v) => !!v || 'Jenis Kelamin is required'],
        no_telp_instruktur: [(v) => !!v || 'No Telp is required'],
        email: [(v) => !!v || 'Email is required'],
        username: [(v) => !!v || 'Username is required'],
        password: [(v) => !!v || 'Password is required'],
        waktu_terlambat: [(v) => !!v || 'Waktu Terlambat is required'],
      },

      instruktur: new FormData(),
      instrukturs: [],
      form: {
        nama_instruktur: null,
        alamat_instruktur: null,
        tanggal_lahir_instruktur: null,
        jenis_kelamin_instruktur: null,
        no_telp_instruktur: null,
        email: null,
        username: null,
        password: null,
        waktu_terlambat: null,
      },

      // untuk tanggal
      modal: false,
      tanggal_lahir_instruktur: new Date().toISOString().substr(0, 10),
      deleteId: '',
      editId: '',
    };
  },

  methods: {
    setForm() {
      if (this.$refs.form.validate()) {
        if (this.inputType !== 'Tambah') {
          this.update();
        } else {
          this.save();
        }
      }
    },

    readData() {
      var url = this.$api + '/instruktur';
      this.$http.get(url, {
          headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
          }
        })
        .then((response) => {
          this.instrukturs = response.data.data;
        });
    },

    save() {
      this.instruktur.append('nama_instruktur', this.form.nama_instruktur);
      this.instruktur.append('alamat_instruktur', this.form.alamat_instruktur);
      this.instruktur.append('tanggal_lahir_instruktur', this.form.tanggal_lahir_instruktur);
      this.instruktur.append('jenis_kelamin_instruktur', this.form.jenis_kelamin_instruktur);
      this.instruktur.append('no_telp_instruktur', this.form.no_telp_instruktur);
      this.instruktur.append('email', this.form.email);
      this.instruktur.append('username', this.form.username);
      this.instruktur.append('password', this.form.password);
      this.instruktur.append('waktu_terlambat', this.form.waktu_terlambat);
      
      this.instruktur.append('id_role', 'Instruktur');

      var url = this.$api + '/instruktur';

      this.load = true;
      this.$http
        .post(url, this.instruktur, {
          headers: {
            'Authorization' : 'Bearer ' + localStorage.getItem('token')
          }
        })
        .then((response) => {
          this.error_message = response.data.message;
          this.color = "green";
          this.snackbar = true;
          this.load = true;
          this.close();
          this.readData(); // baca data
          this.resetForm();
        })
        .catch((error) => {
          this.error_message = error.response.data.message;
          this.color = "red";
          this.snackbar = true;
          this.load = false;
        });
    },

    update() {
      let newData = {
        nama_instruktur: this.form.nama_instruktur,
        alamat_instruktur: this.form.alamat_instruktur,
        tanggal_lahir_instruktur: this.form.tanggal_lahir_instruktur,
        jenis_kelamin_instruktur: this.form.jenis_kelamin_instruktur,
        no_telp_instruktur: this.form.no_telp_instruktur,
        email: this.form.email,
        username: this.form.username,
        password: this.form.password,
        waktu_terlambat: this.form.waktu_terlambat,

        id_role: 'Instruktur'
      };
      var url = this.$api + '/instruktur' + this.editId;
      this.load = true;
      this.$http
        .put(url, newData, {
          headers: {
            'Authorization' : 'Bearer ' + localStorage.getItem('token')
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
    deleteData() {
      //menghapus data
      var url = this.$api + '/instruktur' + this.deleteId;
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
      this.editId = item.id_instruktur;
      this.form.nama_instruktur = item.nama_instruktur;
      this.form.alamat_instruktur = item.alamat_instruktur;
      this.form.tanggal_lahir_instruktur = item.tanggal_lahir_instruktur;
      this.form.jenis_kelamin_instruktur = item.jenis_kelamin_instruktur;
      this.form.no_telp_instruktur = item.no_telp_instruktur;
      this.form.email = item.email;
      this.form.username = item.username;
      this.form.password = item.password;
      this.form.waktu_terlambat = item.waktu_terlambat;

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
      this.dialogConfirm = false;
      this.inputType = 'Tambah';
    },
    resetForm() {
      this.form = {
        nama_instruktur: null,
        alamat_instruktur: null,
        tanggal_lahir_instruktur: null,
        jenis_kelamin_instruktur: null,
        no_telp_instruktur: null,
        email: null,
        username: null,
        password: null,
        waktu_terlambat: null,

        id_role: null,
      };
    },

    //  getColor(status_ketersediaan_driver) {
    //     if(status_ketersediaan_driver == 'Tersedia'){
    //         return 'green'
    //     }else if(status_ketersediaan_driver == 'Tidak Tersedia'){
    //         return 'red'
    //     }
    // },
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
