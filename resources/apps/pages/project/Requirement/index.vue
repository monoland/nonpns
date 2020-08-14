<template>
    <v-page-wrap
        crud 
        absolute 
        searchable 
        with-progress
        enable-print
    >
        <template #print-button>
            <v-btn-tips @click="printReport" label="PRINT" icon="print" :show="!disabled.refresh" />
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

        <v-page-form>
            <v-row>
                <v-col cols="2">
                    <v-combobox
                        label="Status Pegawai"
                        :items="statuses"
                        :color="$root.theme"
                        :disabled="form.mode === 'edit'"
                        v-model="record.status"
                    ></v-combobox>
                </v-col>

                <v-col cols="4">
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
                        label="Tersedia ASN"
                        :color="$root.theme"
                        v-model="record.available"
                    ></v-text-field>
                </v-col>

                <v-col cols="2">
                    <v-text-field
                        label="Tersedia Non ASN"
                        :color="$root.theme"
                        v-model="record.honorer"
                    ></v-text-field>
                </v-col>
            </v-row>
        </v-page-form>

        <v-row id="print-area" style="display: none;">
            <v-simple-table dense>
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th colspan="5">
                                <!-- <div class="font-weight-bold">BERITA ACARA</div> -->
                                <h3 class="text-center">BERITA ACARA</h3>
                            </th>
                        </tr>
                        <tr><th colspan="5"></th></tr>
                        <tr>
                            <th colspan="5">Pada hari ini____________________ Tanggal______ Bulan___________________ Tahun_________</th>
                        </tr>
                        <tr>
                            <th colspan="5">Bertempat di SMA/SMK/SKh___________________________________________________________</th>
                        </tr>
                        <tr>
                            <th colspan="5">telah melakukan pendataan kebutuhan pendidik dan tenaga kependidikan dan telah di verifikasi -</th>
                        </tr>
                        <tr>
                            <th colspan="5">oleh yang bertanda tangan dibawah ini:</th>
                        </tr>
                        <tr><th colspan="5"></th></tr>
                        
                        <tr>
                            <th>Nama</th>
                            <th colspan="4">: __________________________________________________________________</th>
                        </tr>
                        <tr>
                            <th>NIP</th>
                            <th colspan="4">: __________________________________________________________________</th>
                        </tr>
                        <tr><th colspan="5"></th></tr>
                        <tr>
                            <th colspan="5">Dengan hasil sebagai berikut:</th>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <th>Mata Pelajaran</th>
                            <th>Kebutuhan</th>
                            <th>Tersedia ASN</th>
                            <th>Non ASN</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(item, index) in records" :key="index">
                            <td>{{ item.status }}</td>
                            <td>{{ item.subject.text }}</td>
                            <td>{{ item.require }}</td>
                            <td>{{ item.available }}</td>
                            <td>{{ item.honorer }}</td>
                        </tr>

                        <tr>
                            <td colspan="2">JUMLAH</td>
                            <td>{{ totalRequire }}</td>
                            <td>{{ totalAvailable }}</td>
                            <td>{{ totalHonorer }}</td>
                        </tr>


                        <tr><td colspan="5" style="border-bottom: 0;"></td></tr>

                        <tr>
                            <td colspan="5" style="border-bottom: 0;">Demikian Berita Acara ini dibuat untuk dipergunakan sebagaimana mestinya</td>
                        </tr>

                        <tr><td colspan="5" style="border-bottom: 0;"></td></tr>
                        <tr><td colspan="5" style="border-bottom: 0;"></td></tr>

                        <tr>
                            <td colspan="3" style="border-bottom: 0;"></td>
                            <td colspan="2" style="border-bottom: 0; text-align: center;">KEPALA SEKOLAH</td>
                        </tr>

                        <tr><td colspan="5" style="border-bottom: 0;"></td></tr>
                        <tr><td colspan="5" style="border-bottom: 0;"></td></tr>
                        <tr><td colspan="5" style="border-bottom: 0;"></td></tr>
                        <tr><td colspan="5" style="border-bottom: 0;"></td></tr>
                        

                        <tr>
                            <td colspan="3" style="border-bottom: 0;"></td>
                            <td colspan="2" style="border-bottom: 0; text-align: center;">_______________________________</td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </v-row>
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
            { text: 'Tersedia ASN', value: 'available', class: 'count-field' },
            { text: 'Non ASN', value: 'honorer', class: 'count-field' },
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
            available: 0,
            honorer: 0
        });
    },

    methods: {
        printReport: function() {
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
}
</script>