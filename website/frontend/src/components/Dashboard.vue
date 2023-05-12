<template>
    <v-main class="Dashboard">
        <v-carousel
        :cycle="true"
        :continuous="true"
        hide-delimiters
        :show-arrows="false"
        height=630px
        class="carousel">   
            <v-carousel-item
            v-for="(item,i) in items"
            :key="i"
            :src="item.src"
            reverse-transition="fade-transition"
            transition="fade-transition"
            ></v-carousel-item>
        </v-carousel>

    </v-main>
</template>

<script>
    export default {
        name: "Dashboard",
        data() {
            return {
                items: [
                    {
                        src: 'https://st.depositphotos.com/1158045/2361/i/950/depositphotos_23610209-stock-photo-running-on-treadmills.jpg',
                    },
                    {
                        src: 'https://st.depositphotos.com/1708346/1404/i/950/depositphotos_14043607-stock-photo-college-gym-49ers-football-team.jpg',
                    },
                    {
                        src: 'https://cdn1-production-images-kly.akamaized.net/ECmjuqgQRWy4sxnQ4NClNDs_zBk=/640x360/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/1476227/original/050441400_1484732526-m5.jpg',
                    },
                    {
                        src: 'https://st2.depositphotos.com/1518767/9017/i/950/depositphotos_90177350-stock-photo-fit-people-using-weights-machines.jpg',
                    },
                ],
            };
        },
        
    };
</script>     
<style>
</style>  