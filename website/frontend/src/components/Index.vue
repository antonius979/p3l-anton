<template>
    <div class="Index">
        <v-app-bar app fixed height="55px" class="dash">
            <v-toolbar-items>
                <v-btn text router @click="dashboard">
                    <v-img 
                        src="../assets/asli.png"
                        max-height="60"
                        max-width="60">
                    </v-img>
                </v-btn>
            </v-toolbar-items>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-list-item
                    v-for="item in items"
                    :key="item.title"
                    link
                    tag="router-link"
                    :to="item.to"
                >
                <v-list-item-content>
                    <v-list-item-title class="text-center">{{ item.title }}</v-list-item-title>
                </v-list-item-content>
                </v-list-item>
            </v-toolbar-items>
        </v-app-bar>
        <div class="fullheight pa-5">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Index",
        data() {
            this.$router.push({
                        name: 'Dashboard',
                    });
            return {
                drawer: true,
                items: [
                    { title: "Register", to: "/registerCustomer" },
                    { title: "Login", to: "/login"},
                ],
            };
        },
        methods: {
            
        }, 
    };
</script>

<style scoped>
.fullheight{
    min-height: 100vh !important;
    padding: 0 !important;
}

.router{
    text-decoration: none;
    color: black;
    
}
.dash{
    background-color: #B0C4DE !important;
}

.text-center{
    color: rgb(90, 58, 160);
    font-weight: 700;
    font-size: 14pt;
}

</style>
