<template>
    <v-page-wrap crud absolute searchable with-progress>
        <template #navigate>
            <v-btn-tips @click="$router.go(-1)" label="branch" icon="arrow_back" :show="true" />
        </template>

        <template #toolbar-default>
            <v-btn-tips @click="postReset" label="RESET-USER" icon="history" :show="!disabled.link" />
            <v-btn-tips @click="openLink" label="PENDIDIK" icon="perm_identity" :show="!disabled.link" />
        </template>

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
                <v-col cols="12">
                    <v-text-field
                        label="Nama"
                        :color="$root.theme"
                        v-model="record.name"
                    ></v-text-field>
                </v-col>
            </v-row>
        </v-page-form>
    </v-page-wrap>
</template>

<script>
import { pageMixins } from '@apps/mixins/PageMixins';

export default {
    name: 'page-school',

    mixins: [pageMixins],

    route: [
        { path: 'branch/:branch/school', name: 'school', root: 'monoland' },
    ],

    data:() => ({
        // 
    }),

    created() {
        this.tableHeaders([
            { text: 'Name', value: 'name' },
            { text: 'Pegawai', value: 'teachers' },
            { text: 'Update', value: 'updates', align: 'end' },
            { text: null, value: 'update_percent' },
            { text: 'Verifikasi', value: 'verifies', align: 'end' },
            { text: null, value: 'verify_percent' },
            { text: 'Updated', value: 'updated_at', class: 'datetime-field' }
        ]);

        this.pageInfo({
            icon: 'people',
            title: 'School',
        });

        this.dataUrl(`/api/branch/${this.$route.params.branch}/school`);

        this.setRecord({
            id: null,
            name: null,
        });
    },

    methods: {
        openLink: function() {
            this.$router.push({ name: 'teacher', params: { school: this.record.id } });
        },

        postReset: async function() {
            try {
                await this.http.post(`/api/school/${this.record.id}/reset`);

                this.$store.dispatch('message', 'proses reset berhasil!');
            } catch (error) {
                this.$store.dispatch('errors', error);
            }
        }
    }
};
</script>