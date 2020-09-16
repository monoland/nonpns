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
            text: `${baseURL}/${this.text}`,
            height: 112,
            width: 112,
            quietZone: 4
        });
    }
}
</script>