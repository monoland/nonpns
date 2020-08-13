<template>
    <v-page-wrap 
        crud 
        absolute 
        searchable 
        with-progress
        enable-print
    >
        <template #toolbar-default>
            <v-btn-tips @click="openLink" label="SEKOLAH" icon="school" :show="!disabled.link" />
        </template>

        <template #print-button>
            <v-btn-tips @click="printReport" label="PRINT" icon="print" :show="!disabled.refresh" />
        </template>

        <v-desktop-table v-if="desktop"
            single
        ></v-desktop-table>

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

        <v-row id="print-area" style="display: none;">
            <v-simple-table dense>
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th>Kantor Cabang Dinas</th>
                            <th>SMA</th>
                            <th>SMK</th>
                            <th>SKh</th>
                            <th>Sekolah</th>
                            <th>Pegawai</th>
                            <th>Kebutuhan</th>
                            <th>Tersedia</th>
                            <th>Selisih</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(item, index) in records" :key="index">
                            <td v-html="item.name"></td>
                            <td v-html="item.sma"></td>
                            <td v-html="item.smk"></td>
                            <td v-html="item.skh"></td>
                            <td v-html="item.schools"></td>
                            <td v-html="item.verified"></td>
                            <td v-html="item.require"></td>
                            <td v-html="item.available"></td>
                            <td v-html="item.balance"></td>
                        </tr>

                        <tr>
                            <td colspan="5">TOTAL</td>
                            <td v-html="totalVerified"></td>
                            <td v-html="totalRequire"></td>
                            <td v-html="totalAvailable"></td>
                            <td v-html="totalBalance"></td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </v-row>
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

    computed: {
        totalVerified: function() {
            return this.records.reduce((prv, itm) => {
                return prv + parseInt(itm.verified);
            }, 0);
        },

        totalRequire: function() {
            return this.records.reduce((prv, itm) => {
                return prv + parseInt(itm.require);
            }, 0);
        },

        totalAvailable: function() {
            return this.records.reduce((prv, itm) => {
                return prv + parseInt(itm.available);
            }, 0);
        },

        totalBalance: function() {
            return this.records.reduce((prv, itm) => {
                return prv + parseInt(itm.balance);
            }, 0);
        }
    },

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
            { text: 'Update', value: 'updated', align: 'end' },
            { text: null, value: 'update_percent' },
            { text: 'Verifikasi', value: 'verified', align: 'end' },
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
        },

        printReport: async function() {
            let win = window.open('', 'PRINT', 'height=600,width=1024');
                win.document.write('<html>');
                win.document.write('<head>');
                win.document.write('<title>Print Preview</title>');
                win.document.write('</head>');
                win.document.write('<body>');
                win.document.write('<div data-app="true" class="v-application v-application--is-ltr theme--light" style="background: #FFFFFF;">');
                win.document.write('<div class="v-application--wrap">');
                win.document.write('<main class="v-content" data-booted="true" style="padding: 0px 0px 0px 0px;">');
                win.document.write('<div class="v-content__wrap">');
                win.document.write('<div class="row print-area" style="padding: 0px; margin: 0px; background-color: #FFFFFF;">');
                win.document.write(document.getElementById('print-area').innerHTML);
                win.document.write('</div>');
                win.document.write('</div>');
                win.document.write('</main>');
                win.document.write('</div>');
                win.document.write('</div>');
                win.document.write('</body>');
                win.document.write('</html>');

            let css = win.document.createElement('link');
                css.type = 'text/css';
                css.rel = 'stylesheet';
                css.href = '/styles/monoland.css?version=1'; 
                css.media = 'all';
                win.document.getElementsByTagName("head")[0].appendChild(css);
            
            setTimeout(() => {
                win.document.close();
                win.focus();
                win.print();
                win.close();
            }, 500);
        }
    }
};
</script>