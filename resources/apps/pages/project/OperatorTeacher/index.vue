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

                <v-col cols="6">
                    <v-combobox
                        label="Status Pendidik"
                        :items="statuses"
                        :color="$root.theme"
                        v-model="record.status"
                    ></v-combobox>
                </v-col>

                <v-col cols="6">
                    <v-combobox
                        label="Pendidikan Terakhir"
                        :items="educations"
                        :color="$root.theme"
                        v-model="record.education"
                    ></v-combobox>
                </v-col>

                <v-col cols="12">
                    <v-select
                        label="Mata Pelajaran"
                        :items="subjects"
                        :color="$root.theme"
                        append-outer-icon="add"
                        @click:append-outer="addMapel"
                        v-model="record.subject"
                    ></v-select>

                    <v-data-table
                        :headers="headmapel"
                        :items="datamapel"
                        :items-per-page="5"
                        hide-default-footer
                    ></v-data-table>
                </v-col>

                <v-col cols="12">
                    <v-text-field
                        label="Sekolah Tambahan"
                        :color="$root.theme"
                        append-outer-icon="add"
                        @click:append-outer="addMapel"
                        v-model="record.itemschool"
                    ></v-text-field>

                    <v-data-table
                        :headers="headschool"
                        :items="dataschool"
                        :items-per-page="5"
                        hide-default-footer
                    ></v-data-table>
                </v-col>

                <v-col cols="12">
                    <v-text-field
                        label="Lampiran Dokumen"
                        :color="$root.theme"
                        append-outer-icon="add"
                        @click:append-outer="addMapel"
                        v-model="record.itemsdoc"
                    ></v-text-field>

                    <v-data-table
                        :headers="headdoc"
                        :items="datadoc"
                        :items-per-page="5"
                        hide-default-footer
                    ></v-data-table>
                </v-col>
            </v-row>
        </v-page-form>
    </v-page-wrap>
</template>

<script>
import { pageMixins } from '@apps/mixins/PageMixins';

export default {
    name: 'page-operator-teacher',

    mixins: [pageMixins],

    route: [
        { path: 'operator-teacher', name: 'operator-teacher', root: 'monoland' },
    ],

    data:() => ({
        headmapel: [
            { text: 'Nama Mapel', value: 'name' }
        ],

        headschool: [
            { text: 'Nama Sekolah', value: 'name' }
        ],

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
            title: 'OperatorTeacher',
        });

        this.dataUrl(`/api/teacher`);

        this.setRecord({
            id: null,
            name: null,
        });
    },

    methods: {
        addMapel: function() {}
    }
};
</script>