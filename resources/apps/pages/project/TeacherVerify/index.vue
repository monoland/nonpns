<template>
    <v-page-wrap absolute>
        <template #navigate>
            <v-btn-tips @click="$router.go(-1)" label="teacher" icon="arrow_back" :show="true" />
        </template>

        <v-card>
            <v-card-text>
                <v-row :no-gutters="$vuetify.breakpoint.name === 'xs'">
                    <v-col md="3" cols="3">
                        <v-text-field
                            label="Gelar Depan"
                            :color="$root.theme"
                            v-model="employee.front_title"
                        ></v-text-field>
                    </v-col>

                    <v-col md="6" cols="6">
                        <v-text-field
                            label="Nama"
                            :color="$root.theme"
                            v-model="employee.name"
                        ></v-text-field>
                    </v-col>

                    <v-col md="3" cols="3">
                        <v-text-field
                            label="Gelar Belakang"
                            :color="$root.theme"
                            v-model="employee.back_title"
                        ></v-text-field>
                    </v-col>

                    <v-col md="8" cols="12">
                        <v-text-field
                            label="Nomor KTP"
                            :color="$root.theme"
                            v-model="employee.nik"
                        ></v-text-field>
                    </v-col>

                    <v-col md="4" cols="12">
                        <v-text-field
                            label="NUPTK"
                            :color="$root.theme"
                            v-model="employee.register"
                        ></v-text-field>
                    </v-col>

                    <v-col cols="8">
                        <v-text-field
                            label="Tempat Lahir"
                            :color="$root.theme"
                            v-model="employee.born_place"
                        ></v-text-field>
                    </v-col>

                    <v-col cols="4">
                        <v-date-menu
                            label="Tanggal Lahir"
                            :color="$root.theme"
                            v-model="employee.born_date"
                        ></v-date-menu>
                    </v-col>

                    <v-col sm="6" cols="12">
                        <v-combobox
                            label="Jenis Kelamin"
                            :items="genders"
                            :color="$root.theme"
                            v-model="employee.gender"
                        ></v-combobox>
                    </v-col>

                    <v-col sm="6" cols="12">
                        <v-combobox
                            label="Status Nikah"
                            :items="merrieds"
                            :color="$root.theme"
                            v-model="employee.merried"
                        ></v-combobox>
                    </v-col>

                    <v-col sm="4" cols="12">
                        <v-combobox
                            label="Status Pegawai"
                            :items="statuses"
                            :color="$root.theme"
                            v-model="employee.status"
                        ></v-combobox>
                    </v-col>

                    <v-col sm="4" cols="12">
                        <v-combobox
                            label="Pendidikan Terakhir"
                            :items="educations"
                            :color="$root.theme"
                            v-model="employee.education"
                        ></v-combobox>
                    </v-col>

                    <v-col sm="4" cols="12">
                        <v-combobox
                            label="Sumber Gaji"
                            :items="sources"
                            :color="$root.theme"
                            v-model="employee.source"
                        ></v-combobox>
                    </v-col>

                    <v-col cols="12">
                        <v-combobox
                            label="Mata Pelajaran"
                            :items="subjects"
                            :color="$root.theme"
                            :search-input.sync="mapelsync"
                            @change="mapelsync = null"
                            v-model="employee.subjects"
                            hide-selected
                            multiple
                            chips
                            deletable-chips
                        ></v-combobox>
                    </v-col>

                    <v-col cols="12">
                        <v-card class="grey lighten-5" flat>
                            <v-card-text style="min-height: 56px;">
                                <v-list class="pa-0" two-line v-if="employee.documents && employee.documents.length > 0">
                                    <template v-for="(document, index) in employee.documents">
                                        <v-list-item :key="index">
                                            <v-list-item-avatar>
                                                <v-icon>folder</v-icon>
                                            </v-list-item-avatar>

                                            <v-list-item-content>
                                                <v-list-item-title>{{ document.name }}</v-list-item-title>
                                                <v-list-item-subtitle>
                                                    <span class="field">Jenis</span>:
                                                    <select v-model="document.kind">
                                                        <option disabled value="">Pilihan</option>    
                                                        <option v-for="(doctype, idx) in doctypes" :key="idx">
                                                            {{ doctype }}
                                                        </option>
                                                    </select> 

                                                    <template v-if="document.kind === 'IJAZAH' || document.kind === 'Surat Keputusan (SK)'">
                                                        <br /><span class="field">Nomor</span>: <input type="text" v-model="document.kind_numb" placeholder="Isi Nomor"> 
                                                        <br /><span class="field">Tanggal</span>: 
                                                        <v-menu
                                                            v-model="document.picker"
                                                            :close-on-content-click="false"
                                                            transition="scale-transition"
                                                            offset-y
                                                            min-width="290px"
                                                        >
                                                            <template v-slot:activator="{ on }">
                                                                <input type="text" v-model="document.kind_date" placeholder="Isi Tanggal"  v-on="on">
                                                            </template>

                                                            <v-date-picker v-model="document.kind_date" @input="document.picker = false"></v-date-picker>
                                                        </v-menu>
                                                        <br /><span class="field">Pejabat</span>: <input type="text" v-model="document.kind_sign" placeholder="Isi Pejabat"> 
                                                    </template>
                                                </v-list-item-subtitle>
                                            </v-list-item-content>

                                            <v-list-item-action>
                                                <v-btn icon @click="removeDocument(document, index)">
                                                    <v-icon>delete</v-icon>
                                                </v-btn>
                                            </v-list-item-action>
                                        </v-list-item>

                                        <v-divider :key="'div-' + index"></v-divider>
                                    </template>
                                </v-list>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-page-wrap>
</template>

<script>
import { pageMixins } from '@apps/mixins/PageMixins';

export default {
    name: 'page-teacher-verify',

    mixins: [pageMixins],

    route: [
        { path: 'teacher/:teacher/teacher-verify', name: 'teacher-verify', root: 'monoland' },
    ],

    data:() => ({
        doctypes: [
            'KTP', 'FOTO', 'NUPTK', 'IJAZAH', 
            'Surat Keputusan (SK)', 'Surat Keterangan Atasan (SKTA)'
        ],

        educations: [
            { text: 'Tidak Sekolah', value: 11 },
            { text: 'SD', value: 1 },
            { text: 'SMP', value: 2 },
            { text: 'SMA', value: 3 },
            { text: 'SMK', value: 4 },
            { text: 'D1', value: 5 },
            { text: 'D2', value: 6 },
            { text: 'D3', value: 7 },
            { text: 'S1', value: 8 },
            { text: 'S2', value: 9 },
            { text: 'S3', value: 10 },
        ],

        sources: [
            { text: 'APBN', value: 'APBN' },
            { text: 'APBD', value: 'APBD' },
            { text: 'LAINNYA', value: 'LAINNYA' },
        ],

        genders: [
            { text: 'Laki-Laki', value: 'L' },
            { text: 'Perempuan', value: 'P' },
        ],

        merrieds: [
            { text: 'Kawin', value: 'Kawin' },
            { text: 'Blm. Kawin', value: 'Blm. Kawin' },
            { text: 'Duda', value: 'Duda' },
            { text: 'Janda', value: 'Janda' },
        ],

        statuses: [
            { text: 'Pendidik', value: 'Pendidik' },
            { text: 'Tenaga Kependidikan', value: 'Tenaga Kependidikan' },
        ],

        employee: {
            front_title: null
        },

        subjects: [],
        mapelsync: null
    }),

    created() {
        this.pageInfo({
            icon: 'people',
            title: 'Verifikasi Pegawai',
        });

        this.fetchTeacher(`api/teacher/${this.$route.params.teacher}`);
    },

    methods: {
        fetchTeacher: async function(url) {
            try {
                let { data } = await this.http.get(url);

                this.employee = data;
            } catch (error) {
                this.$store.dispatch('errors', error);
            }
        }
    }
};
</script>