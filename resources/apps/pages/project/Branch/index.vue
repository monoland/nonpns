<template>
    <v-page-wrap crud absolute searchable with-progress>
        <template #toolbar-default>
            <v-btn-tips @click="openLink" label="SEKOLAH" icon="school" :show="!disabled.link" />
        </template>

        <v-desktop-table v-if="desktop"
            single
        ></v-desktop-table>

        <!-- <v-mobile-table icon="perm_identity" v-else>
            <template v-slot:default="{ item }">
                <v-list-item-content>
                    <v-list-item-title>{{ item.name }}</v-list-item-title>
                    <v-list-item-subtitle class="f-nunito">{{ item.email }}</v-list-item-subtitle>
                </v-list-item-content>
            </template>
        </v-mobile-table> -->

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
                        <v-list-item-subtitle class="f-nunito">{{ `sekolah: ${record.schools}, update: ${record.updated}/${record.teachers}, verified: ${record.verified}` }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>

                <v-divider :key="`divider-${index}`" inset></v-divider>
            </template>
        </v-list>

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
    name: 'page-branch',

    mixins: [pageMixins],

    route: [
        { path: 'branch', name: 'branch', root: 'monoland' },
    ],

    data:() => ({
        // 
    }),

    created() {
        this.tableHeaders([
            { text: 'Name', value: 'name' },
            { text: 'Sekolah', value: 'schools' },
            { text: 'SMA', value: 'sma' },
            { text: 'SMK', value: 'smk' },
            { text: 'SKh', value: 'skh' },
            { text: 'Pegawai', value: 'teachers' },
            { text: 'Update', value: 'updates', align: 'end' },
            { text: null, value: 'update_percent' },
            { text: 'Verifikasi', value: 'verifies', align: 'end' },
            { text: null, value: 'verify_percent' },
        ]);

        this.pageInfo({
            icon: 'people',
            title: 'Branch',
        });

        this.dataUrl(`/api/branch`);

        this.setRecord({
            id: null,
            name: null,
        });
    },

    methods: {
        openLink: function() {
            this.$router.push({ name: 'school', params: { branch: this.record.id } });
        },

        openItem: function(record) {
            if (this.page.state === 'pinned') {
                this.$store.commit('selectedPush', record);
            } else {
                this.$router.push({ name: 'school', params: { branch: record.id } });
            }
        }
    }
};
</script>