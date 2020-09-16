<template>
    <v-page-wrap 
        crud 
        absolute 
        searchable 
        with-progress
        enable-print
    >
        <template #navigate>
            <v-btn-tips @click="$router.go(-1)" label="branch" icon="arrow_back" :show="true" />
        </template>

        <template #print-button>
            <v-btn-tips @click="printReport" label="PRINT" icon="print" :show="!disabled.refresh" />
        </template>

        <template #toolbar-default>
            <v-btn-tips @click="printQrCode" label="QR-CODE" icon="print" :show="!disabled.link"></v-btn-tips>
            <v-btn-tips @click="postReset" label="RESET-USER" icon="history" :show="!disabled.link" />
            <v-btn-tips @click="openLink" label="PENDIDIK" icon="perm_identity" :show="!disabled.link" />
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
                        <v-list-item-subtitle class="f-nunito">{{ `update: ${record.updated}/${record.teachers}, verified: ${record.verified}` }}</v-list-item-subtitle>
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

        <v-row id="print-qrcode" style="display: none;">
            <template v-for="(item, index) in teachers">
                <div class="pagesplit" :key="index">
                    <table>
                        <tbody>
                            <tr>
                                <td class="align-center"><strong>PETIKAN</strong></td>
                            </tr>
                            <tr>
                                <td class="align-center"><strong>KEPUTUSAN GUBERNUR BANTEN</strong></td>
                            </tr>
                            <tr>
                                <td class="align-center"><strong>NOMOR: {{ item.number }}</strong></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="align-center"><strong>TENTANG</strong></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="align-center">PENUGASAN GURU BUKAN PEGAWAI NEGERI SIPIL PADA SEKOLAH MENENGAH ATAS</td>
                            </tr>
                            <tr>
                                <td class="align-center">NEGERI, SEKOLAH MENENGAH KEJURUAN NEGERI DAN SEKOLAH KHUSUS</td>
                            </tr>
                            <tr>
                                <td class="align-center">DI LINGKUNGAN PEMERINTAH PROVINSI BANTEN</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="align-center"><strong>GUBERNUR BANTEN</strong></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>

                            <tr>
                                <td>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="sk-tagline">Menimbang</td>
                                                <td class="sk-delimiter">:</td>
                                                <td><span style="display: inline-block; width: 96px;"></span> dst;</td>
                                            </tr>

                                            <tr>
                                                <td class="sk-tagline">Mengingat</td>
                                                <td class="sk-delimiter">:</td>
                                                <td><span style="display: inline-block; width: 96px;"></span> dst;</td>
                                            </tr>

                                            <tr>
                                                <td class="sk-tagline">Memperhatikan</td>
                                                <td class="sk-delimiter">:</td>
                                                <td class="text-justify">Peraturan Pemerintah Republik Indonesia Nomor 41 tahun 2019 tentang Tunjangan Profesi Guru dan Dosen, Tunjangan Khusus Guru dan Dosen, Serta Tunjangan Kehormatan Profesor;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="align-center"><strong>MEMUTUSKAN</strong></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>

                            <tr>
                                <td>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="sk-tagline">Menetapkan</td>
                                                <td class="sk-delimiter">:</td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td class="sk-tagline">KESATU</td>
                                                <td class="sk-delimiter">:</td>
                                                <td>Menugaskan Guru Bukan Pegawai Negeri Sipil:</td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <v-simple-table dense>
                                                        <template v-slot:default>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Nomor Urut</td>
                                                                    <td class="sk-delimiter">:</td>
                                                                    <td>{{ item.serial }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Nama</td>
                                                                    <td class="sk-delimiter">:</td>
                                                                    <td>{{ item.fullname }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Mata Pelajaran</td>
                                                                    <td class="sk-delimiter">:</td>
                                                                    <td>{{ item.subject }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Satuan Pendidikan</td>
                                                                    <td class="sk-delimiter">:</td>
                                                                    <td><strong>{{ item.school }}</strong></td>
                                                                </tr>
                                                            </tbody>
                                                        </template>
                                                    </v-simple-table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="sk-tagline">KEDUA</td>
                                                <td class="sk-delimiter">:</td>
                                                <td class="text-justify">Guru bukan Pegawai Negeri Sipil yang dimaksud pada Diktum KESATU dapat mengikuti Progran Sertifikasi Guru dari Kementerian Pendidikan dan Kebudayaan Republik Indonesia dan dapat diterbitkan Surat Keputusan Tunjangan Profesi (SKTP) serta tidak akan menuntut untuk diangkat menjadi Pegawai Negeri Sipil.</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td class="sk-tagline">KETIGA</td>
                                                <td class="sk-delimiter">:</td>
                                                <td class="text-justify"><strong>PETIKAN</strong> Keputusan Gubernur ini disampaikan kepada yang bersangkutan dan yang berkepentingan untuk dapat diketahui dan dipergunakan sebagaimana mestinya.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                            </tr>

                            <tr>
                                <td>
                                    <table class="sk-ttd" style="width: 100%;">
                                        <tbody>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>Ditetapkan di    S e r a n g</td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>Pada tanggal {{ item.tmt }}</td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td>Untuk PETIKAN yang sah</td>
                                                <td>&nbsp;</td>
                                                <td>GUBERNUR BANTEN,</td>
                                            </tr>

                                            <tr>
                                                <td>Kepala Badan Kepegawaian Daerah,</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td style="vertical-align: middle;">ttd</td>
                                                <td style="vertical-align: middle;">
                                                    <v-qrcode :text="`${item.shorturl}`"></v-qrcode>
                                                </td>
                                                <td style="vertical-align: middle;">ttd</td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td><strong><u>Dr. KOMARUDIN, MAP</u></strong></td>
                                                <td>&nbsp;</td>
                                                <td><strong>WAHIDIN HALIM</strong></td>
                                            </tr>

                                            <tr>
                                                <td>Pembina Utama Muda</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td>NIP. 197007211991011002</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                            </tr>

                            <tr>
                                <td>Kepada :</td>
                            </tr>

                            <tr>
                                <td>Yth. Sdr/i. {{ item.fullname }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </template>
        </v-row>

        <v-row id="print-area" style="display: none;">
            <v-simple-table dense v-if="table.selected.length <= 0">
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th colspan="10"><h3>TABEL REKAPITULASI KEBUTUHAN PENDIDIK DAN TENAGA KEPENDIDIKAN</h3></th>
                        </tr>
                        <tr>
                            <th colspan="10"><h3>PEMERINTAH PROVINSI BANTEN</h3></th>
                        </tr>

                        <tr><th colspan="10">{{ info.name }}</th></tr>

                        <tr>
                            <th>No</th>
                            <th>Nama Sekolah</th>
                            <th>Pegawai</th>
                            <th>Kebutuhan</th>
                            <th>Tersedia ASN</th>
                            <th>Non ASN</th>
                            <th>Selisih</th>
                        </tr>
                    </thead>

                    <tbody>
                        <template v-for="(item, index) in records">
                            <tr :key="index">
                                <td v-html="index + 1"></td>
                                <td v-html="item.name"></td>
                                <td v-html="item.verified"></td>
                                <td v-html="item.require"></td>
                                <td v-html="item.available"></td>
                                <td v-html="item.honorer"></td>
                                <td v-html="item.balance"></td>
                            </tr>
                        </template>

                        <tr>
                            <td colspan="2">TOTAL</td>
                            <td v-html="totalVerified"></td>
                            <td v-html="totalRequire"></td>
                            <td v-html="totalAvailable"></td>
                            <td v-html="totalHonorer"></td>
                            <td v-html="totalBalance"></td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>

            <v-simple-table dense v-else>
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th><h3>{{ record.name }}</h3></th>
                        </tr>
                        <tr>
                            <th>Mata Pelajaran</th>
                            <th>Kebutuhan</th>
                            <th>Tersedia ASN</th>
                            <th>Non ASN</th>
                            <th>Formasi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(item, index) in record.details" :key="index">
                            <td>{{ item.status }} - {{ item.subject.text }}</td>
                            <td v-html="item.require"></td>
                            <td v-html="item.available"></td>
                            <td v-html="item.honorer"></td>
                            <td v-html="item.balance"></td>
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
    name: 'page-school',

    mixins: [pageMixins],

    route: [
        { path: 'branch/:branch/school', name: 'school', root: 'monoland' },
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

        totalHonorer: function() {
            return this.records.reduce((prv, itm) => {
                return prv + parseInt(itm.honorer);
            }, 0);
        },

        totalBalance: function() {
            return this.records.reduce((prv, itm) => {
                return prv + parseInt(itm.balance);
            }, 0);
        }
    },

    data:() => ({
        teachers: []
    }),

    created() {
        this.tableHeaders([
            { text: 'Name', value: 'name' },
            { text: 'Pegawai', value: 'teachers' },
            { text: 'Update', value: 'updated', align: 'end' },
            { text: null, value: 'update_percent' },
            { text: 'Verifikasi', value: 'verified', align: 'end' },
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

        openItem: function(record) {
            this.$router.push({ name: 'teacher', params: { school: record.id } });
        },

        postReset: async function() {
            try {
                await this.http.post(`/api/school/${this.record.id}/reset`);

                this.$store.dispatch('message', 'proses reset berhasil!');
            } catch (error) {
                this.$store.dispatch('errors', error);
            }
        },

        printQrCode: async function() {
            let { data } = await this.http.get(`/api/school/${this.table.selected[0].id}/nominative`);
            this.teachers = data;

            setTimeout(() => {
            
                let win = window.open('', 'PRINT', 'height=600,width=1024');
                    win.document.write('<html>');
                    win.document.write('<head>');
                    win.document.write('<title>Print Preview</title>');
                    win.document.write('</head>');
                    win.document.write('<body>');
                    win.document.write('<div class="print-area" style="padding: 0px; margin: 0px; background-color: #FFFFFF;">');
                    win.document.write(document.getElementById('print-qrcode').innerHTML);
                    win.document.write('</div>');
                    win.document.write('</body>');
                    win.document.write('</html>');

                let prt = win.document.createElement('link');
                    prt.type = 'text/css';
                    prt.rel = 'stylesheet';
                    prt.href = '/styles/print.css?version=1'; 
                    prt.media = 'print';
                    win.document.getElementsByTagName("head")[0].appendChild(prt);
            
            
                win.document.close();
                win.focus();
            }, 1500);
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
                // win.print();
                // win.close();
            }, 500);
        }
    }
};
</script>