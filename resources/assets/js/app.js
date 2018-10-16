
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('sweetalert');
require('flatpickr');
require('./flatpickr-id');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component(
    'form-pendaftaran-sertifikasi', 
    require('./components/FormPendaftaranSertifikasi.vue')
);

Vue.component(
    'form-tambah-user',
    require('./components/FormTambahuser.vue')
);

Vue.component(
    'form-asesmen-diri',
    require('./components/FormAsesmenDiri.vue')
);

Vue.component(
    'form-asesmen-diri-asesor',
    require('./components/FormAsesmenDiriAsesor.vue')
);

Vue.component(
    'form-impor-sertifikat',
    require('./components/ImporSertifikat.vue')
);
