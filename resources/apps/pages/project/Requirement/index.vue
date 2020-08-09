<template>
    <v-page-wrap
        crud 
        absolute 
        searchable 
        with-progress
    >
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
            </v-data-table>
        </v-widget>

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
                <v-col cols="3">
                    <v-combobox
                        label="Status Pegawai"
                        :items="statuses"
                        :color="$root.theme"
                        :disabled="form.mode === 'edit'"
                        v-model="record.status"
                    ></v-combobox>
                </v-col>

                <v-col cols="5">
                    <v-combobox
                        label="Keterangan"
                        :items="subjects"
                        :color="$root.theme"
                        :disabled="form.mode === 'edit'"
                        v-model="record.subject"
                    ></v-combobox>
                </v-col>

                <v-col cols="2">
                    <v-text-field
                        label="Kebutuhan"
                        :color="$root.theme"
                        v-model="record.require"
                    ></v-text-field>
                </v-col>

                <v-col cols="2">
                    <v-text-field
                        label="Tersedia"
                        :color="$root.theme"
                        v-model="record.available"
                    ></v-text-field>
                </v-col>
            </v-row>
        </v-page-form>
    </v-page-wrap>
</template>

<script>
import { pageMixins } from '@apps/mixins/PageMixins';
import { mapState } from 'vuex';

export default {
    name: 'page-requirement',

    mixins: [pageMixins],

    route: [
        { path: 'requirement', name: 'requirement', root: 'monoland' },
    ],

    computed: {
        subjects: function() {
            if (this.combos && this.combos.hasOwnProperty('subjects')) {
                return this.combos.subjects;
            }

            return [];
        }
    },

    data:() => ({
        statuses: [
            { text: 'Pendidik', value: 'Pendidik' },
            { text: 'Tenaga Kependidikan', value: 'Tenaga Kependidikan' },
        ],
    }),

    created() {
        this.tableHeaders([
            { text: 'Status', value: 'status' },
            { text: 'Mata Pelajaran', value: 'subject.text' },
            { text: 'Kebutuhan', value: 'require', class: 'count-field' },
            { text: 'Tersedia', value: 'available', class: 'count-field' },
        ]);

        this.pageInfo({
            icon: 'people',
            title: 'Kebutuhan Pegawai',
        });

        this.dataUrl(`/api/requirement`);

        this.setRecord({
            id: null,
            status: null,
            subject: null,
            require: 0,
            available: 0
        });
    }
}
</script>