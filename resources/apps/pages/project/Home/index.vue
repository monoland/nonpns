<template>
    <v-page-wrap no-trash>
        <!--  -->
    </v-page-wrap>
</template>

<script>
import { mapActions } from 'vuex';

// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';

// window.Pusher = Pusher;

export default {
    name: 'page-home',

    route: [
        { path: 'home', name: 'home', root: 'monoland' },
    ],

    created() {
        this.initStore();
        
        this.pageInfo({
            icon: 'home',
            title: 'Beranda',
        });

        // this.echo = new Echo({
        //     broadcaster: 'pusher',
        //     key: 'pARVz8S0wmg8EQKa898v',
        //     wsHost: 'broadcast.bantenprov.go.id',
        //     wsPort: 6001,
        //     disableStats: true,
        // });
    },

    data:() => ({
        echo: null
    }),

    mounted() {
        // this.echo.channel('teacher').listen('TeacherHasUpdated', event => {
        //     console.log(event)
        // });
    },

    methods: {
        ...mapActions(['pageInfo', 'initStore']),
    }
};
</script>
