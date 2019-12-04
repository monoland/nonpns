<template>
    <v-page-wrap crud absolute searchable with-progress>
        <v-desktop-table v-if="desktop"
            single
        ></v-desktop-table>

        <v-mobile-table icon="perm_identity" v-else>
            <template v-slot:default="{ item }">
                <v-list-item-content>
                    <v-list-item-title>{{ item.name }}</v-list-item-title>
                    <v-list-item-subtitle class="f-nunito">{{ item.email }}</v-list-item-subtitle>
                </v-list-item-content>
            </template>
        </v-mobile-table>

        <v-page-form small>
            <v-row>
                <v-col cols="2">
                    <v-text-field
                        label="Gelar"
                        :color="$root.theme"
                        v-model="record.front_title"
                    ></v-text-field>
                </v-col>

                <v-col cols="8">
                    <v-text-field
                        label="Nama"
                        :color="$root.theme"
                        v-model="record.name"
                    ></v-text-field>
                </v-col>

                <v-col cols="2">
                    <v-text-field
                        label="Gelar"
                        :color="$root.theme"
                        v-model="record.back_title"
                    ></v-text-field>
                </v-col>

                <v-col cols="8">
                    <v-text-field
                        label="Nomor KTP"
                        :color="$root.theme"
                        v-model="record.nik"
                    ></v-text-field>
                </v-col>

                <v-col cols="4">
                    <v-text-field
                        label="NUPTK"
                        :color="$root.theme"
                        v-model="record.register"
                    ></v-text-field>
                </v-col>

                <v-col cols="8">
                    <v-text-field
                        label="Tempat Lahir"
                        :color="$root.theme"
                        v-model="record.born_place"
                    ></v-text-field>
                </v-col>

                <v-col cols="4">
                    <v-date-menu
                        label="Tanggal Lahir"
                        :color="$root.theme"
                        v-model="record.born_date"
                    ></v-date-menu>
                </v-col>

                <v-col cols="6">
                    <v-combobox
                        label="Jenis Kelamin"
                        :items="genders"
                        :color="$root.theme"
                        v-model="record.gender"
                    ></v-combobox>
                </v-col>

                <v-col cols="6">
                    <v-combobox
                        label="Status Nikah"
                        :items="merrieds"
                        :color="$root.theme"
                        v-model="record.merried"
                    ></v-combobox>
                </v-col>

                <v-col cols="4">
                    <v-combobox
                        label="Status Pendidik"
                        :items="statuses"
                        :color="$root.theme"
                        v-model="record.status"
                    ></v-combobox>
                </v-col>

                <v-col cols="4">
                    <v-combobox
                        label="Pendidikan Terakhir"
                        :items="educations"
                        :color="$root.theme"
                        v-model="record.education"
                    ></v-combobox>
                </v-col>

                <v-col cols="4">
                    <v-combobox
                        label="Sumber Gaji"
                        :items="sources"
                        :color="$root.theme"
                        v-model="record.source"
                    ></v-combobox>
                </v-col>

                <v-col cols="12">
                    <v-combobox
                        label="Mata Pelajaran"
                        :items="subjects"
                        :color="$root.theme"
                        :search-input.sync="mapelsync"
                        @change="mapelsync = null"
                        v-model="record.subjects"
                        hide-selected
                        multiple
                        chips
                        deletable-chips
                    ></v-combobox>
                </v-col>

                <v-col cols="12">
                    <v-card class="grey lighten-5" flat>
                        <v-card-text style="min-height: 56px;">
                            <v-progress-linear v-if="upload.value > 0"
                                v-model="upload.value"
                                height="25"
                                reactive
                            >
                                <template v-slot="{ value }">
                                    <strong>{{ upload.name + ' - ' + Math.round(value) }}%</strong>
                                </template>
                            </v-progress-linear>

                            <v-list class="pa-0" two-line v-if="record.documents && record.documents.length > 0">
                                <template v-for="(document, index) in record.documents">
                                    <v-list-item :key="index">
                                        <v-list-item-avatar>
                                            <v-icon>folder</v-icon>
                                        </v-list-item-avatar>

                                        <v-list-item-content>
                                            <v-list-item-title>{{ document.name }}</v-list-item-title>
                                            <v-list-item-subtitle>
                                                <span class="field">Jenis</span>:
                                                <select v-model="document.type">
                                                    <option disabled value="">Pilihan</option>    
                                                    <option v-for="(doctype, idx) in doctypes" :key="idx">
                                                        {{ doctype }}
                                                    </option>
                                                </select> 

                                                <template v-if="document.type === 'IJAZAH' || document.type === 'SK'">
                                                    <br /><span class="field">Nomor</span>: <input type="text" v-model="document.fileno" placeholder="Isi Nomor"> 
                                                    <br /><span class="field">Tanggal</span>: 
                                                        <v-menu
                                                            v-model="document.picker"
                                                            :close-on-content-click="false"
                                                            transition="scale-transition"
                                                            offset-y
                                                            min-width="290px"
                                                        >
                                                            <template v-slot:activator="{ on }">
                                                                <input type="text" v-model="document.filedt" placeholder="Isi Tanggal"  v-on="on">
                                                            </template>

                                                            <v-date-picker v-model="document.filedt" @input="document.picker = false"></v-date-picker>
                                                        </v-menu>
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

                        <v-card-text class="grey lighten-3" style="height: 48px; position: relative">
                            <div class="d-block overline">lampiran dokumen</div>
                            
                            <v-btn class="v-btn__media"
                                absolute
                                dark fab top right
                                :color="$root.theme"
                            >
                                <v-document-upload
                                    :callback="addDocument"
                                >
                                    <v-icon>add</v-icon>
                                </v-document-upload>
                            </v-btn>
                        </v-card-text>
                    </v-card>
                </v-col>
                
            </v-row>
        </v-page-form>
    </v-page-wrap>
</template>

<script>
import { pageMixins } from '@apps/mixins/PageMixins';
import { mapState } from 'vuex';

export default {
    name: 'page-operator-teacher',

    mixins: [pageMixins],

    route: [
        { path: 'operator-teacher', name: 'operator-teacher', root: 'monoland' },
    ],

    computed: {
        ...mapState(['upload']),

        subjects: function() {
            if (this.combos && this.combos.hasOwnProperty('subjects')) {
                return this.combos.subjects;
            }

            return [];
        }
    },

    data:() => ({
        doctypes: ['KTP', 'FOTO', 'NUPTK', 'IJAZAH', 'SK'],

        filedt: null,
        newdocument: {
            id: null,
            name: null,
            type: '',
            picker: false,
            path: null,
            fileno: null,
            filedt: null,
            signby: null
        },

        educations: [
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
            { text: 'Kawin', value: 'kawin' },
            { text: 'Blm. Kawin', value: 'blm_kawin' },
            { text: 'Duda', value: 'duda' },
            { text: 'Janda', value: 'janda' },
        ],

        statuses: [
            { text: 'Pendidik', value: 'Pendidik' },
            { text: 'Tenaga Kependidikan', value: 'Tenaga Kependidikan' },
        ],

        mapelsync: null,
    }),

    created() {
        this.tableHeaders([
            { text: 'Name', value: 'name' },
            { text: 'Tmp Lahir', value: 'born_place' },
            { text: 'Tgl Lahir', value: 'born_date' },
            { text: 'Updated', value: 'updated_at', class: 'datetime-field' }
        ]);

        this.pageInfo({
            icon: 'people',
            title: 'Pegawai',
        });

        this.dataUrl(`/api/teacher`);

        this.setRecord({
            id: null,
            name: null,
            documents: [],
        });
    },

    methods: {
        addDocument: function(document) {
            let newdoc = Object.assign({}, this.newdocument);
                newdoc.id = document.id;
                newdoc.name = document.name;
                newdoc.path = document.path;
            
            let idx = this.record.documents.findIndex(obj => obj.id === newdoc.id);

            if (idx === -1) {
                this.record.documents.push(newdoc);
            }
        },

        removeDocument: async function(document, index) {
            try {
                await this.http.delete(
                    '/sipandik/api/document/' + document.id
                );

                this.record.documents.splice(index, 1);
            } catch (error) {
                this.$store.dispatch('errors', error);
            }
        }
    },
};
</script>