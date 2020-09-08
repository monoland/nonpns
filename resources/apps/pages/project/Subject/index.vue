<template>
    <v-page-wrap 
        crud absolute 
        searchable 
        with-progress 
        enable-print
    >
        <template #print-button>
            <v-btn-tips @click="printReport" label="PRINT" icon="print" :show="!disabled.refresh" />
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

        <v-row id="print-area" style="display: none;">
            <v-simple-table dense>
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th>Mata Pelajaran</th>
                            <th>Kebutuhan</th>
                            <th>Tersedia ASN</th>
                            <th>Non ASN</th>
                            <th>Formasi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(item, index) in reports" :key="index">
                            <td>{{ item.subject }}</td>
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
    name: 'page-subject',

    mixins: [pageMixins],

    route: [
        { path: 'subject', name: 'subject', root: 'monoland' },
    ],

    data:() => ({
        reports: []
    }),

    created() {
        this.tableHeaders([
            { text: 'Name', value: 'name' },
            { text: 'Updated', value: 'updated_at', class: 'datetime-field' }
        ]);

        this.pageInfo({
            icon: 'people',
            title: 'Subject',
        });

        this.dataUrl(`/api/subject`);

        this.setRecord({
            id: null,
            name: null,
        });

        this.getReports();
    },

    methods: {
        getReports: async function() {
            let { data } = await this.http.get(`/api/subject/reports`);
            this.reports = data;
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
            }, 500);
        }
    }
};
</script>