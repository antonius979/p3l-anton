import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

function importComponent(path) {
    return () => import(`./components/${path}.vue`);
}

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'Index',
            meta: { title: 'Atma Jogja Rental'},
            component: importComponent('Index'),
            children: [
                {
                    path: '/',
                    name: 'Dashboard',
                    meta: { title: 'Atma Jogja Rental'},
                    component: importComponent('Dashboard'),
                },
            ]
        },

        {
            path: "/dasboardAdmin",
            name: 'DashboardLayoutAdmin',
            meta: {title: 'Dashboard Admin'},
            component: importComponent('BarsAdmin'),
            children: [
                {
                    path: '/Apemilikmobil',
                    name: 'PemilikMobil',
                    meta: { title: 'Pemilik Mobil' },
                    component: importComponent('Admin/PemilikMobil'),
                },
                {
                    path: '/Amobil',
                    name: 'Mobil',
                    meta: { title: 'Mobil' },
                    component: importComponent('Admin/Mobil'),
                },
                {
                    path: '/AmobilKontrak',
                    name: 'MobilKontrak',
                    meta: { title: 'Mobil Kontrak' },
                    component: importComponent('Admin/KontrakMobil'),
                },
                {
                    path: '/Apegawai',
                    name: 'Pegawai',
                    meta: { title: 'Pegawai' },
                    component: importComponent('Admin/Pegawai'),
                },
                {
                    path: '/Adriver',
                    name: 'Driver',
                    meta: { title: 'Driver' },
                    component: importComponent('Admin/Driver'),
                },
                {
                    path: '/Ainstruktur',
                    name: 'Instruktur',
                    meta: { title: 'Instruktur' },
                    component: importComponent('Admin/Instruktur'),
                },
                {
                    path: '/Amember',
                    name: 'Member',
                    meta: { title: 'Member' },
                    component: importComponent('Admin/Member'),
                },
                {
                    path: '/AaktivasiTahunan',
                    name: 'AktivasiTahunan',
                    meta: { title: 'AktivasiTahunan' },
                    component: importComponent('Admin/AktivasiTahunan'),
                },
                {
                    path: '/AdepositUang',
                    name: 'DepositUang',
                    meta: { title: 'DepositUang' },
                    component: importComponent('Admin/DepositUang'),
                },
                {
                    path: '/AdepositKelas',
                    name: 'DepositKelas',
                    meta: { title: 'DepositKelas' },
                    component: importComponent('Admin/DepositKelas'),
                },
              
            ],
        },

        {
            path: "/dasboardKasir",
            name: 'DashboardLayoutKasir',
            meta: {title: 'Dashboard Kasir'},
            component: importComponent('BarsKasir'),
            children: [
                {
                    path: '/Kmember',
                    name: 'Member',
                    meta: { title: 'Member' },
                    component: importComponent('Kasir/Member'),
                },
              
            ],
        },

        {
            path: "/dasboardManager",
            name: 'DashboardLayoutManager',
            meta: {title: 'Dashboard Manager'},
            component: importComponent('BarsManager'),
            children: [
                {
                    path: '/Mpromo',
                    name: 'Promo',
                    meta: { title: 'Promo' },
                    component: importComponent('Manager/Promo'),
                },
                {
                    path: '/MdaftarJadwal',
                    name: 'DaftarJadwal',
                    meta: { title: 'DaftarJadwal' },
                    component: importComponent('Manager/DaftarJadwal'),
                },
                {
                    path: '/MjadwalPegawai',
                    name: 'JadwalPegawai',
                    meta: { title: 'JadwalPegawai' },
                    component: importComponent('Manager/JadwalPegawai'),
                },
                {
                    path: '/Mjadwal',
                    name: 'Jadwal',
                    meta: { title: 'Jadwal' },
                    component: importComponent('Manager/Jadwal'),
                },
                {
                    path: '/MjadwalHarian',
                    name: 'JadwalHarian',
                    meta: { title: 'JadwalHarian' },
                    component: importComponent('Manager/JadwalHarian'),
                },
            ],
        },
        // {
        //     path: "/dasboardCS",
        //     name: 'DashboardLayoutCS',
        //     meta: {title: 'Dashboard Customer Service'},
        //     component: importComponent('BarsCustomerService'),
        //     children: [
        //         {
        //             path: '/CScustomer',
        //             name: 'Customer',
        //             meta: { title: 'Customer' },
        //             component: importComponent('CustomerService/Customer'),
        //         },
        //         {
        //             path: '/CSverifpinjam',
        //             name: 'VerifPeminjaman',
        //             meta: { title: 'Verifikasi Peminjaman' },
        //             component: importComponent('CustomerService/VerifPeminjaman'),
        //         },
        //         {
        //             path: '/CSverifbayar',
        //             name: 'VerifPembayaran',
        //             meta: { title: 'Verifikasi Pembayaran' },
        //             component: importComponent('CustomerService/VerifPembayaran'),
        //         },
        //         {
        //             path: '/CStampilTransaksi',
        //             name: 'TampilTransaksi',
        //             meta: { title: 'Data Transaksi Customer' },
        //             component: importComponent('CustomerService/TransaksiCS'),
        //         },
        //     ],
        // },
        // {
        //     path:"/dashboardCustomer",
        //     name: "DashboardLayoutCustomer",
        //     meta: {title: 'Dashboard Customer'},
        //     component: importComponent('BarsCustomer'),
        //     children: [
        //         {
        //             path: '/profilCustomer',
        //             name: 'ProfilCustomer',
        //             meta: { title: 'Profil Customer' },
        //             component: importComponent('Customer/Profil'),
        //         },
        //         {
        //             path: '/editprofilCustomer',
        //             name: 'EditProfilCustomer',
        //             meta: { title: 'Edit Profil Customer' },
        //             component: importComponent('Customer/EditProfilCustomer'),
        //         },
        //         {
        //             path: '/peminjamanCustomer',
        //             name: 'PeminjamanCustomer',
        //             meta: { title: 'Peminjaman Customer' },
        //             component: importComponent('Customer/Peminjaman'),
        //         },
        //         {
        //             path: '/pembayaranCustomer',
        //             name: 'PembayaranCustomer',
        //             meta: { title: 'Pembayaran Customer' },
        //             component: importComponent('Customer/Pembayaran'),
        //         },
        //         {
        //             path: '/riwayatTransaksiCustomer',
        //             name: 'RiwayatTransaksiCustomer',
        //             meta: { title: 'Riwayat Transaksi Customer' },
        //             component: importComponent('Customer/RiwayatTransaksi'),
        //         },
        //     ]

        // },

    //login
    {
        path: '/login',
        name: 'Login',
        meta: {title: 'Login'},
        component: importComponent('Login'),
    },

    //register
    {
        path: '/registerCustomer',
        name: 'RegisterCustomer',
        meta: {title: 'RegisterCustomer'},
        component: importComponent('RegisterCustomer'),
    },
    
  ],
});

// Set Judul
router.beforeEach((to, from, next) => {
    document.title = to.meta.title;
    next();
});


export default router;
