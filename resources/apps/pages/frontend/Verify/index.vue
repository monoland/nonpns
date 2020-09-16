<template>
    <v-app v-cloak>
        <v-content>
            <v-container class="fill-height">
                <v-row>
                    <v-col class="d-flex align-center justify-center" cols="12">
                        <v-overlay :value="verifyload">
                            <v-progress-circular indeterminate size="64">
                                verify
                            </v-progress-circular>
                        </v-overlay>
                        
                        <v-card v-if="!verifyload">
                            <v-avatar class="ml-4" :color="verifydata !== 404 ? 'green' : 'red'" size="64">
                                <v-icon x-large dark>{{ verifydata !== 404 ? 'done' : 'close' }}</v-icon>
                            </v-avatar>

                            <v-card-text>
                                <table v-if="verifydata !== 404">
                                    <tbody>
                                        <tr>
                                            <td>Nomor SK</td>
                                            <td class="px-2">:</td>
                                            <td>{{ verifydata.number }}</td>
                                        </tr>

                                        <tr>
                                            <td>Tanggal SK</td>
                                            <td class="px-2">:</td>
                                            <td>{{ verifydata.tmt }}</td>
                                        </tr>

                                        <tr>
                                            <td>Nomor Urut</td>
                                            <td class="px-2">:</td>
                                            <td>{{ verifydata.serial }}</td>
                                        </tr>

                                        <tr>
                                            <td>Nama</td>
                                            <td class="px-2">:</td>
                                            <td>{{ verifydata.fullname }}</td>
                                        </tr>

                                        <tr>
                                            <td>Mata Pelajaran</td>
                                            <td class="px-2">:</td>
                                            <td>{{ verifydata.subject }}</td>
                                        </tr>

                                        <tr>
                                            <td>Satuan Pendidikan</td>
                                            <td class="px-2">:</td>
                                            <td>{{ verifydata.school }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <h1 class="font-weight-regular red--text" v-else>Data Tidak Valid</h1>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
import { mapState, mapActions } from 'vuex';

export default {
    name: 'page-verify',

    route: [
        { path: '/verify/:verify', name: 'verify' },
    ],

    computed: {
        ...mapState(['verifyload', 'verifydata'])
    },

    mounted() {
        this.initStore();
        this.verifypost(this.$route.params.verify);
    },

    methods: {
        ...mapActions(['initStore', 'verifypost'])
    }
}
</script>