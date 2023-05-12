<template>
    <div class="dashboard">
        <v-navigation-drawer v-model="drawer" class="fullheight" width="256" app color="#B0C4DE">
            <v-list-item>
                <v-list-item-content>
                    <img src="..\assets\gofit.png" width="130" height="180">
                    <v-spacer></v-spacer>
                    <v-list-item-title class="title_drawer">Welcome {{nama_pegawai}}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>
            <v-list dense nav>
                <v-list-item
                    v-for="item in items"
                    :key="item.title"
                    link
                    tag="router-link"
                    :to="item.to">
                    <v-list-item-icon class="router"> <v-icon class="router"> {{item.icon}} </v-icon> </v-list-item-icon>
                    <v-list-item-content  class="router">
                        <v-list-item-title >{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar app fixed height="45px"  >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer" color="rgb(90, 58, 160);"></v-app-bar-nav-icon>
            <VSpacer />
            <v-toolbar-items>
                <v-btn @click="logout" text router color="rgb(90, 58, 160);"><v-icon>mdi-power</v-icon></v-btn>
            </v-toolbar-items>
        </v-app-bar>



        <div class="fullheight pa-5">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Dashboard",
        data() {
            return {
                drawer: true,
                items: [
                    { title: 'Pegawai', to: '/Apegawai', icon:"mdi-badge-account-horizontal" },
                    // { title: 'Driver', to: '/Adriver', icon:"mdi-badge-account-horizontal" },
                    // { title: 'Pemilik Mobil', to: '/Apemilikmobil', icon:"mdi-account-multiple" },
                    { title: 'Instruktur', to: '/Ainstruktur', icon:"mdi-badge-account-horizontal" },
                    // { title: 'Mobil', to: '/Amobil', icon:"mdi-car-side" },
                    { title: 'Member', to: '/Amember', icon:"mdi-badge-account-horizontal" },
                    { title: 'AktivasiTahunan', to: '/AaktivasiTahunan', icon:"mdi-badge-account-horizontal" },
                    { title: 'DepositUang', to: '/AdepositUang', icon:"mdi-badge-account-horizontal" },
                    { title: 'DepositKelas', to: '/AdepositKelas', icon:"mdi-badge-account-horizontal" },
                ],
                nama_pegawai: localStorage.getItem('nama_pegawai'),
            };
        },
        methods: {
            logout(){
                localStorage.removeItem('id_pegawai');
                localStorage.removeItem('id_role');
                localStorage.removeItem('email');
                localStorage.removeItem('nama_pegawai');
                this.$router.push({
                        name: 'Index',
                    });
            
            },

             
        profil() {
                this.$router.push("/profil")
        },
        
        },
    };
</script>

<style scoped>
    .fullheight {
        min-height: 100vh !important;
    }

    .router{
        text-decoration:none;
        color: rgb(90, 58, 160);
    }


     /* OUTER CONTAINER */
    .tcontainer {
        width: 100%;
        overflow: hidden; /* Hide scroll bar */
    }

     .title_drawer {
        color: rgb(90, 58, 160);
        text-align: center;
        font-weight: bold;
    }
 
    /* MIDDLE CONTAINER */
    .ticker-wrap {
        width: 100%;
        padding-left: 100%; /* Push contents to right side of screen */
    }

    /* INNER CONTAINER */
    @keyframes ticker {
        0% { transform: translate3d(0, 0, 0); }
        100% { transform: translate3d(-100%, 0, 0); }
    }
    
    .ticker-move {
        /* Basically move items from right side of screen to left in infinite loop */
        display: inline-block;
        white-space: nowrap;
        padding-right: 100%;
        animation-iteration-count: infinite;
        animation-timing-function: linear;
        animation-name: ticker;
        animation-duration: 40s;
    }

    .ticker-move:hover{
        animation-play-state: paused; /* Pause scroll on mouse hover */
    }

    /* ITEMS */
    .ticker-item{
        display: inline-block; /* Lay items in a horizontal line */
        padding: 0 2rem;
    }

</style>
