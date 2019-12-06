<template>
    <v-page-wrap no-trash>
        <!--  -->
    </v-page-wrap>
</template>

<script>
import { mapState, mapActions } from 'vuex';

export default {
    name: 'page-home',

    route: [
        { path: 'home', name: 'home', root: 'monoland' },
    ],

    computed: {
        ...mapState(['auth']),
    },

    created() {
        this.initStore();
        
        this.pageInfo({
            icon: 'home',
            title: 'Beranda',
        });
    },

    data:() => ({
        echo: null
    }),

    mounted() {
        //   
    },

    methods: {
        ...mapActions(['pageInfo', 'initStore']),
    }
};
</script>
