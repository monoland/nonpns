<template>
    <v-page-wrap crud absolute searchable with-progress>
        <template #navigate>
            <v-btn-tips @click="$router.go(-1)" label="school" icon="arrow_back" :show="true" />
        </template>

        <template #toolbar-default>
            <v-btn-tips @click="postReset" label="RESET-VERIFIKASI" icon="history" :show="!disabled.link" />
            <v-btn-tips @click="openVerify" label="VERIFIKASI" icon="done_all" :show="!disabled.link" />
        </template>

        <v-widget table v-if="desktop">
            <v-data-table
                v-model="table.selected"
                :headers="headers"
                :items="records"
                :single-select="true"
                :loading="table.loader"
                :options.sync="table.options"
                :server-items-length="table.total"
                :footer-props="table.footerProps"
                item-key="id"
                show-select
            >
                <template #:progress>
                    <v-progress-linear :color="color" height="1" indeterminate></v-progress-linear>
                </template>

                <template v-slot:item.updated="{ item }">
                    <v-icon>{{ item.updated === true ? 'check' : 'close' }}</v-icon>
                </template>

                <template v-slot:item.verified="{ item }">
                    <v-icon>{{ item.verified === true ? 'check' : 'close' }}</v-icon>
                </template>
            </v-data-table>
        </v-widget>

        <v-list two-line subheader v-else>
            <template v-for="(record, index) in records">
                <v-list-item :key="index" v-press="() => recordPress(record)" @click="openItem(record)">
                    <v-list-item-avatar>
                        <v-scale-transition mode="out-in">
                            <v-icon 
                                :key="`icon-${record.pinned}`" 
                                :class="{ 'deep-orange': record.pinned, 'grey lighten-1': !record.pinned }"
                                class="white--text"
                            >
                                {{ record.pinned ? 'done' : 'perm_identity' }}
                            </v-icon>
                        </v-scale-transition>
                    </v-list-item-avatar>

                    <v-list-item-content>
                        <v-list-item-title>{{ record.name }}</v-list-item-title>
                        <v-list-item-subtitle class="f-nunito">{{ `TTL: ${record.born_place}, ${record.born_date}` }}</v-list-item-subtitle>
                    </v-list-item-content>

                    <v-list-item-icon>
                        <v-icon>{{ record.verified ? 'check' : 'close' }}</v-icon>
                    </v-list-item-icon>
                </v-list-item>

                <v-divider :key="`divider-${index}`" inset></v-divider>
            </template>
        </v-list>

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
            </v-row>
        </v-page-form>
    </v-page-wrap>
</template>

<script>
import { pageMixins } from '@apps/mixins/PageMixins';

export default {
    name: 'page-teacher',

    mixins: [pageMixins],

    route: [
        { path: 'school/:school/teacher', name: 'teacher', root: 'monoland' },
    ],

    data:() => ({
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
            { text: 'Update', value: 'updated' },
            { text: 'Verifikasi', value: 'verified' },
            { text: 'Updated', value: 'updated_at', class: 'datetime-field' }
        ]);

        this.pageInfo({
            icon: 'people',
            title: 'Pegawai',
        });

        this.dataUrl(`/api/school/${this.$route.params.school}/teacher`);

        this.setRecord({
            id: null,
            nik: null,
            name: null,
            front_title: null,
            back_title: null,
            gender: null,
            born_place: null,
            born_date: null,
            status: null,
            tmt: null,
            merried: null,
            education: null,
            register: null
        });
    },

    methods: {
        openVerify: function(){
            this.$router.push({ name: 'teacher-verify', params: { teacher: this.record.id } });
        },

        openItem: function(record) {
            this.$router.push({ name: 'teacher-verify', params: { teacher: record.id } });
        },
        
        postReset: function() {}
    }
};
</script>