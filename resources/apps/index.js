import Vue from 'vue';

Vue.config.productionTip = false;

// import component
import * as Parts from './parts';
Object.keys(Parts).forEach((part) => {
    Vue.component(Parts[part].name, Parts[part]);
});

// add press directive
import Hammer from 'hammerjs';
Vue.directive('press', {
    bind:(el, binding) => {
        if (typeof binding.value === 'function') {
            const mc = new Hammer(el);
            mc.get('press').set({ time: 500 });
            mc.on('press', binding.value);
        }
    }
});

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: '9b155284f87393e32a82',
//     cluster: 'ap1',
//     forceTLS: true
// });

// pusher
// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

import Apps from './pages/Apps.vue';
import router from './plugins/router';
import store from './plugins/store';
import vuetify from './plugins/vuetify';

new Vue({
    router,
    store,
    vuetify,
    
    data:() => ({
        avatar: null,
        background: null,
        theme: null,
        navdrawer: false,
    }),

    created() {
        this.navdrawer = this.$vuetify.breakpoint.name === 'lg' || this.$vuetify.breakpoint.name === 'xl';
    },
    
    methods: {
        formatBytes: function(bytes) {
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            if (bytes === 0) return '0 Bytes';
            const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)), 10);
            if (i === 0) return `${bytes} ${sizes[i]})`;
            return `${(bytes / (1024 ** i)).toFixed(1)} ${sizes[i]}`;
        },

        formatCurrency: function(money) {
            if (!money) return 0;
            return money.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    },

    mounted() {
        // 
    },
    
    render: h => h(Apps)
}).$mount('#monoland');