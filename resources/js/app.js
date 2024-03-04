require('./bootstrap');

import { createApp, h, Vue } from 'vue'
import { createInertiaApp, Head, Link } from '@inertiajs/inertia-vue3'
import Layout from "./Shared/Layout"
import Notification from "./Shared/Notification"
import { InertiaProgress } from '@inertiajs/progress'

//Card modal
//.component('CardModal', CardModal)
import CardModal from "./Shared/CardModal"

// FileUpload
import vueFilePond from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginImageCrop from 'filepond-plugin-image-crop';
import FilePondPluginImageTransform from 'filepond-plugin-image-transform';

//VUe-select
//import Vue from 'vue';
import 'vue-select/dist/vue-select.css';
import vSelect from 'vue-select';
import VueSelect from 'vue-select';

//Bootstrap Vue
//import { BootstrapVue } from 'bootstrap-vue';
/*.use(BootstrapVue)
      .use(IconsPlugin) */

//Vue Multiselect 3
import Multiselect from '@vueform/multiselect';

//Sweet Alert
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
//VUE-3 RICH ACCORDION
// import { useAccordion } from "vue3-rich-accordion";
// import "vue3-rich-accordion/accordion-library-styles.css";
// import "vue3-rich-accordion/accordion-library-styles.scss";
// .use(useAccordion)
// import { Inertia } from '@inertiajs/inertia';
// import router from './router';
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginFileValidateSize,
    FilePondPluginImageCrop,
    FilePondPluginImageTransform
);

createInertiaApp({
    resolve: async name => {
        let page = (await import(`./Pages/${name}`)).default;
        page.layout ??= Layout
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(VueSweetalert2)
            .component("multiselect", Multiselect)
            .component("Link", Link)
            .component("Head", Head)
            .component('CardModal', CardModal)
            .component("Notification", Notification)
            .component("FilePond", FilePond)
            .component("v-select", vSelect)
            .mixin({
                data() {
                    return {
                        get jasper_ip() {
                            var lo = "192.168.6.23:8080/";
                            var gl = "122.54.19.171:8080/";
                            var nw = "122.53.120.27:8080/"
                            return nw;
                        }
                    }
                },
                methods: {
                    formatDateRange(dateFrom, dateTo) {
                        const fromDate = new Date(dateFrom);
                        const toDate = new Date(dateTo);

                        // Define formatting options for the 'from' and 'to' dates
                        const options = {
                            month: 'long',
                            day: 'numeric',
                        };

                        // Format the 'from' and 'to' dates
                        const formattedFromDate = fromDate.toLocaleDateString(undefined, options);
                        const formattedToDate = toDate.toLocaleDateString(undefined, options);

                        // Construct the date range string
                        if (fromDate.getFullYear() !== toDate.getFullYear()) {
                            return `${formattedFromDate}, ${fromDate.getFullYear()} to ${formattedToDate}, ${toDate.getFullYear()}`;
                        } else {
                            return `${formattedFromDate} to ${formattedToDate}, ${fromDate.getFullYear()}`;
                        }

                    },
                    stringAsArray(originalString) {
                        return originalString.split(this.delimiter);
                    },
                    format_number(number, num_decimals, include_comma) {

                        return number.toLocaleString('en-US', { useGrouping: include_comma, minimumFractionDigits: num_decimals, maximumFractionDigits: num_decimals });
                    },
                    format_number_conv(number, num_decimals, include_comma) {
                        var numm = parseFloat(number);
                        return numm.toLocaleString('en-US', { useGrouping: include_comma, minimumFractionDigits: num_decimals, maximumFractionDigits: num_decimals });
                    },
                    getMonthName(monthNumber) {
                        const months = [
                            'January',
                            'February',
                            'March',
                            'April',
                            'May',
                            'June',
                            'July',
                            'August',
                            'September',
                            'October',
                            'November',
                            'December',
                        ];

                        const parsedNumber = parseInt(monthNumber);
                        if (!isNaN(parsedNumber) && parsedNumber >= 1 && parsedNumber <= 12) {
                            return months[parsedNumber - 1];
                        } else {
                            return 'Invalid Month';
                        }
                    },
                    getStatus(stat_num) {
                        if (stat_num === '-2') {
                            return 'Returned';
                        } else if (stat_num === '-1') {
                            return 'Saved';
                        } else if (stat_num === '0') {
                            return 'Submitted';
                        } else if (stat_num === '1') {
                            return 'Reviewed';
                        } else if (stat_num === '2') {
                            return 'Approved';
                        } else if (stat_num === '3') {
                            return 'Final Approve';
                        } else {
                            return 'Unknown Status';
                        }
                    },
                    getSemester(sem) {
                        if (sem === '1') {
                            return 'First Semester';
                        } else {
                            return 'Second Semester';
                        }
                    },
                    getPeriod(sem, year) {
                        if (sem === '1') {
                            return `January to June ${year}`;
                        } else {
                            return `July to December ${year}`;
                        }
                    },
                    getColor(status) {
                        if (status == 1) {
                            return 'blue';
                        } else if (status == 0) {
                            return 'orange';
                        } else if (status == 2) {
                            return 'green';
                        } else if (status == -1) {
                            return 'black';
                        } else if (status == -2) {
                            return 'red';
                        } else {
                            // Default color if the status doesn't match any condition
                            return 'black'; // You can set a default color here
                        }
                    },
                    getActivityType(act_type) {
                        if (act_type === 'review target') {
                            return 'Reviewed semestral target';
                        } else if (act_type === 'approve target') {
                            return 'Approved semestral target';
                        } else if (act_type === 'review accomplishment') {
                            return 'Reviewed monthly target';
                        } else if (act_type === 'approve accomplishment') {
                            return 'Approved monthly target';
                        } else if (act_type === 'final approve accomplishment') {
                            return 'Final approve accomplishment';
                        } else if (act_type === 'return accomplishment') {
                            return 'Return accomplishment';
                        } else if (act_type === 'review semestral accomplishment') {
                            return 'Review monthly target';
                        } else if (act_type === 'approve semestral accomplishment') {
                            return 'Approve monthly target';
                        } else if (act_type === 'return target') {
                            return 'Return target';
                        } else if (act_type === 'return semestral accomplishment') {
                            return 'Return semestral accomplishment';
                        } else {
                            // Handle any other cases or return a default value
                            return ''; // or any other default value you want
                        }
                    }
                }
            })
            .mount(el)
    },
    title: title => 'IPCR: ' + title
})

InertiaProgress.init({
    delay: 250,
    color: '#29d',
    includeCSS: true,
    showSpinner: false,
})
