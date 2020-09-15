<template>
    <div ref="qrcode"></div>
</template>

<script>
import { baseURL } from '@apps/.env.js';
import * as QRCode from 'easyqrcodejs';

export default {
    name: 'v-qrcode',

    props: {
        text: {
            type: String,
            default: null
        }
    },

    mounted() {
        new QRCode(this.$refs.qrcode, {
            text: `${baseURL}/#/verify/${this.text.replace("'", "")}`,
            height: 128,
            width: 128,
            quietZone: 4
        });
    }
}
</script>