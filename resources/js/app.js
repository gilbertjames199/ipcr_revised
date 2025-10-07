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
// LOADING
import { ref } from 'vue'

import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/css/index.css' // required CSS

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginFileValidateSize,
    FilePondPluginImageCrop,
    FilePondPluginImageTransform
);

const setFavicon = (iconUrl) => {
  let link = document.querySelector("link[rel~='icon']")
  if (!link) {
    link = document.createElement("link")
    link.rel = "icon"
    document.head.appendChild(link)
  }
  link.href = iconUrl
}

// ✅ Set your favicon
setFavicon('/images/IPCR_ICON.png')
// const isLoading = ref(false)
// const showLoading = () => { isLoading.value = true }
// const hideLoading = () => { isLoading.value = false }
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
            .component('LoadingOverlay', Loading)
            .mixin({
                data() {
                    return {
                        get jasper_ip() {
                            // var lo = "192.168.6.23:8080/";
                            // var gl = "122.54.19.171:8080/";
                            // var nw = "122.54.19.172:8080/";
                            // var nw_loc = "192.168.6.48:8080/";
                            //var nw_temp = "120.72.21.122:8080/"
                            // var nw_oct = "paps.dvodeoro.ph:8080/"
                            // var nw_nov = "paps.dvodeoro.ph/"
                            var nw_nov = "paps.davaodeoro.gov.ph/"
                            return nw_nov;
                        }

                    }
                },
                methods: {
                    // COMPUTATION OF MONTHLYM SCORES
                    // **************************************************
                    QualityRateApp: (q1, q2, q3) => {
                        const n1 = Number(q1) || 0;
                        const n2 = Number(q2) || 0;
                        const n3 = Number(q3) || 0;
                        const average = (n1 + n2 + n3) / 3;
                        // console.log("niabot diri")
                        const ave = (average % 1 === 0) ? average : parseFloat(average.toFixed(2));
                        return ave;
                    },
                    EfficiencyRateApp(e1, e2, e3) {
                        var values = [e1, e2, e3];
                        var validValues = values.filter(val => val !== 0);

                        if (validValues.length === 0) {
                            return 0; // or handle however you want when all are 0
                        }

                        var sum = validValues.reduce((a, b) => a + b, 0);
                        var average = sum / validValues.length;

                        return (average % 1 === 0) ? average : parseFloat(average.toFixed(2));
                    },
                    calculateAverageCore(data) {
                        let sum = 0;
                        let num_of_data = 0;
                        let average = 0;

                        if (Array.isArray(data)) {
                            data.forEach(item => {
                                // console.log(item.q1 + " " + item.q2 + " " + item.q3 + " " + item.e1 + " " + item.e2 + " " + item.e3 + " " + item.time + " " + item.timeliness
                                //     + " type:" + item.type + " ipcr_type: " + item.ipcr_type)
                                if (item.ipcr_type === 'Core Function' || item.type === 'Core Function') {
                                    const q1 = Number(item.q1) || 0;
                                    const q2 = Number(item.q2) || 0;
                                    const q3 = Number(item.q3) || 0;

                                    const e1 = Number(item.e1) || 0;
                                    const e2 = Number(item.e2) || 0;
                                    const e3 = Number(item.e3) || 0;
                                    var val = this.AverageRateApp(this.QualityRateApp(q1, q2, q3), this.EfficiencyRateApp(item.efficiency1 == "No" ? 0 : e1, item.efficiency2 == "No" ? 0 : e2, item.efficiency3 == "No" ? 0 : e3), item.timeliness == "No" ? 0 : item.time)
                                    //var val = this.AverageRating(item.month === 0 || item.month === null ? this.QuantityRate(item.quantity_type, item.TotalQuantity, 1) : this.QuantityRate(item.quantity_type, item.TotalQuantity, item.month), this.QualityRate(item.quality_error, this.quality_score(item.total_quality,item.quality_error)), item.TimeRating == "" ? 0 : item.TimeRating);
                                    // alert(val);
                                    // console.log("ave: core: " + this.QualityRateApp(q1, q2, q3))
                                    // num_of_data += 1;
                                    // sum += parseFloat(val);
                                    // average = sum / num_of_data

                                    val = parseFloat(val);

                                    if (val !== 0) {  // Only include non-zero values
                                        sum += val;
                                        num_of_data += 1;
                                    }
                                    // console.log("val: " + val)
                                }
                            });
                        }
                        if (num_of_data > 0) {
                            average = sum / num_of_data;
                        } else {
                            average = 0;
                        }
                        const Average_Point_Core = average.toFixed(2);
                        return Average_Point_Core;
                    },
                    calculateAverageSupport(data) {
                        // console.log(data);
                        let sum = 0;
                        let num_of_data = 0;
                        let average = 0;

                        if (Array.isArray(data)) {
                            // console.log()
                            data.forEach(item => {
                                // console.log("item: " + item.ipcr_type + " type: " + item.type)
                                if (item.ipcr_type === 'Support Function' || item.type === 'Support Function') {
                                    const q1 = Number(item.q1) || 0;
                                    const q2 = Number(item.q2) || 0;
                                    const q3 = Number(item.q3) || 0;

                                    const e1 = Number(item.e1) || 0;
                                    const e2 = Number(item.e2) || 0;
                                    const e3 = Number(item.e3) || 0;
                                    // console.log("ave: support: " + this.QualityRateApp(q1, q2, q3))
                                    // console.log(item.ipcr_type)
                                    // console.log("item: " + item.time)
                                    // console.log("efficiency: " + this.EfficiencyRateApp(item.efficiency1 == "No" ? 0 : item.e1, item.efficiency2 == "No" ? 0 : item.e2, item.efficiency3 == "No" ? 0 : item.e3))
                                    var val = this.AverageRateApp(this.QualityRateApp(q1, q2, q3), this.EfficiencyRateApp(item.efficiency1 == "No" ? 0 : e1, item.efficiency2 == "No" ? 0 : e2, item.efficiency3 == "No" ? 0 : e3), item.timeliness == "No" ? 0 : (item.time == null ? 0 : item.time))
                                    //var val = this.AverageRating(item.month === 0 || item.month === null ? this.QuantityRate(item.quantity_type, item.TotalQuantity, 1) : this.QuantityRate(item.quantity_type, item.TotalQuantity, item.month), this.QualityRate(item.quality_error, this.quality_score(item.total_quality,item.quality_error)), item.TimeRating == "" ? 0 : item.TimeRating);
                                    // alert(val);

                                    // num_of_data += 1;
                                    // sum += parseFloat(val);
                                    // average = sum / num_of_data

                                    val = parseFloat(val);

                                    if (val !== 0) {  // Only include non-zero values
                                        sum += val;
                                        num_of_data += 1;
                                    }
                                }
                            });
                        } else {
                            console.log("data is not an array")
                        }
                        if (num_of_data > 0) {
                            average = sum / num_of_data;
                        } else {
                            average = 0;
                        }
                        const Average_Point_Core = average.toFixed(2);
                        return Average_Point_Core;
                    },
                    AverageRateApp(Quality, Efficiency, Timeliness) {
                        var values = [Quality, Efficiency, Timeliness];
                        var validValues = values.filter(val => val !== 0);

                        if (validValues.length === 0) {
                            return 0; // or handle differently if needed
                        }

                        var sum = validValues.reduce((a, b) => a + b, 0);
                        var average = sum / validValues.length;

                        return (average % 1 === 0) ? average : parseFloat(average.toFixed(2));
                    },
                    // COMPUTATION OF SEMESTRAL SCORES
                    sem(sem) {
                        var result = ""
                        if (sem == "1") {
                            result = "January to June"
                        } else if (sem == 2) {
                            result = "July to December"
                        }
                        return result;
                    },
                    getAdjectivalScoreSemestral(Core, Support) {
                        var result = 0;
                        var result = Math.round((Core + Support) * 100) / 100;
                        return result;
                    },
                    EfficiencyRateSem(ave1, ave2, ave3) {
                        let values = [ave1, ave2, ave3];
                        let sum = 0;
                        let count = 0;

                        values.forEach(val => {
                            if (val !== 0) {
                                sum += val;
                                count++;
                            }
                        });

                        // Avoid division by zero
                        if (count === 0) {
                            return 0;
                        }

                        let result = sum / count;
                        console.log(result);
                        return parseFloat(result.toFixed(2));
                    },
                    QualityRateSem(ave1, ave2, ave3) {
                        var result = (ave1 + ave2 + ave3) / 3;

                        console.log(result);
                        return parseFloat(result.toFixed(2));
                    },
                    AverageComputationSem(QualityAverage, EfficiencyAverage, TimeAverage) {
                        let values = [QualityAverage, EfficiencyAverage, TimeAverage];
                        let sum = 0;
                        let count = 0;

                        values.forEach(val => {
                            if (val !== 0) {
                                sum += val;
                                count++;
                            }
                        });

                        if (count === 0) {
                            return 0;
                        }

                        let result = sum / count;
                        return parseFloat(result.toFixed(2));
                    },
                    SemName(id) {
                        var result;
                        if (id == 1) {
                            result = "January to June"
                        } else {
                            result = "July to December"
                        }

                        return result;
                    },
                    getAdjectivalScoreSem(Core, Support) {
                        var result = 0;
                        var result = Math.round((Core + Support) * 100) / 100;
                        return result;
                    },
                    getAdjectivalRatingSem(Score) {
                        var result = ""
                        if (Score >= 4.51 && Score <= 5.00) {
                            result = "Outstanding"
                        } else if (Score >= 3.51 && Score <= 4.50) {
                            result = "Very Satisfactory"
                        } else if (Score >= 2.51 && Score <= 3.50) {
                            result = "Satisfactory"
                        } else if (Score >= 1.51 && Score <= 2.50) {
                            result = "Unsatisfactory"
                        } else if (Score >= 1.00 && Score <= 1.50) {
                            result = "Poor"
                        }

                        return result;
                    },
                    AverageRateSem(QuantityRating, QualityRating, TimeRating) {
                        // alert(TimeRating)

                        if (TimeRating == " ") {
                            TimeRating = 0;
                        }
                        if (TimeRating == "") {
                            TimeRating = 0;
                        }
                        if (isNaN(TimeRating)) {
                            TimeRating = 0;
                        }
                        var ratings = [parseFloat(QuantityRating), parseFloat(QualityRating), parseFloat(TimeRating)];

                        var NotZero = ratings.filter(rating => rating !== 0);

                        if (NotZero.length === 0) {
                            return 0; // or any default value when all ratings are zero
                        }

                        const average = NotZero.reduce((sum, rating) => sum + rating, 0) / NotZero.length;


                        return this.format_number_conv(average, 2, true)


                    },
                    calculateAverageCoreSem(data) {
                        let sum = 0;
                        let num_of_data = 0;
                        let average = 0;
                        // console.log(data);
                        if (Array.isArray(data)) {
                            data.forEach(item => {
                                if (item.ipcr_type === 'Core Function') {
                                    var val = this.AverageComputationSem(this.QualityRateSem(item.avg_q1, item.avg_q2, item.avg_q3), this.EfficiencyRateSem(item.avg_e1, item.avg_e2, item.avg_e3), item.timeliness == "No" ? 0 : item.avg_t1);
                                    // alert(val);
                                    // alert(this.TimeRatings(this.AveTime(this.TotalTime(item.result), this.GetSumQuantity(item.result)), item.TimeRange, item.time_range_code));
                                    if (val !== 0) {
                                        num_of_data += 1;
                                        sum += parseFloat(val);
                                        average = sum / num_of_data
                                    }

                                }
                                // console.log(num_of_data);
                                // console.log(average)
                            });
                        }
                        return average.toFixed(2);
                    },
                    calculateAverageSupportSem(data) {
                        let sum = 0;
                        let num_of_data = 0;
                        let average = 0;
                        if (Array.isArray(data)) {
                            data.forEach(item => {
                                if (item.ipcr_type === 'Support Function') {
                                    var val = this.AverageComputationSem(this.QualityRateSem(item.avg_q1, item.avg_q2, item.avg_q3), this.EfficiencyRateSem(item.avg_e1, item.avg_e2, item.avg_e3), item.timeliness == "No" ? 0 : item.avg_t1);
                                    // alert(val);

                                    if (val !== 0) {
                                        num_of_data += 1;
                                        sum += parseFloat(val);
                                        average = sum / num_of_data
                                    }
                                }
                            });
                        }

                        return average.toFixed(2);
                    },
                    //************************************************** */
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
                    formatMonthDayYear(datte) {
                        let dateString = datte;
                        let dateParts = dateString.split("-");
                        return new Date(dateParts[0], dateParts[1] - 1, dateParts[2])
                            .toLocaleDateString("en-US", { month: "long", day: "numeric", year: "numeric" });

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
                            return 'Reviewed monthly accomplishment';
                        } else if (act_type === 'approve accomplishment') {
                            return 'Approved monthly accomplishment';
                        } else if (act_type === 'final approve accomplishment') {
                            return 'Final approve accomplishment';
                        } else if (act_type === 'return accomplishment') {
                            return 'Returned monthly accomplishment';
                        } else if (act_type === 'review semestral accomplishment') {
                            return 'Reviewed semestral accomplishment';
                        } else if (act_type === 'approve semestral accomplishment') {
                            return 'Approved semestral accomplishment';
                        } else if (act_type === 'return target') {
                            return 'Returned target';
                        } else if (act_type === 'return semestral accomplishment') {
                            return 'Returned semestral accomplishment';
                        } else if (act_type === 'returned additional target') {
                            return 'Returned additional target';
                        } else if (act_type === 'reviewed additional target') {
                            return 'Reviewed additional target';
                        } else if (act_type === 'approved additional target') {
                            return 'Approved additional target';
                        } else if (act_type === 'reviewed additional target (new)') {
                            return 'Reviewed semestral target';
                        } else if (act_type === 'approved additional target (new)') {
                            return 'Approved semestral target';
                        } else if (act_type === 'returned additional target (new)') {
                            return 'Returned target';
                        } else if (act_type === 'return accomplishment (for review)') {
                            return 'Returned accomplishment (for review)';
                        } else {
                            return ''; // or any other default value you want
                        }
                    },
                    truncatedDescription(dat) {
                        // alert(dat);
                        const wordLimit = 10; // Change this to the desired word limit
                        const words = dat.split(' ');
                        if (words.length > wordLimit) {
                            return words.slice(0, wordLimit).join(' ') + '...';
                        }
                        return dat;
                    },
                    truncatedDescriptionSpecificLength(dat, limm) {
                        const wordLimit = limm; // Change this to the desired word limit
                        const words = dat.split(' ');
                        if (words.length > wordLimit) {
                            return words.slice(0, wordLimit).join(' ') + '...';
                        }
                        return dat;
                    },
                    formatDateTimeDTS(dateTimeStr) {
                        // Parse the input date-time string to a Date object
                        const dateObj = new Date(dateTimeStr);

                        // Options for formatting the date part
                        const dateOptions = { year: 'numeric', month: 'long', day: 'numeric' };
                        const formattedDate = dateObj.toLocaleDateString('en-US', dateOptions);

                        // Extract the time parts
                        var hours = dateObj.getHours().toString().padStart(2, '0');
                        const minutes = dateObj.getMinutes().toString().padStart(2, '0');
                        // const seconds = dateObj.getSeconds().toString().padStart(2, '0');
                        var mer = ' AM';
                        if (hours > 12) {
                            hours = hours - 12;
                            mer = ' PM';
                        }
                        // Format the time part
                        const formattedTime = `${hours}:${minutes}${mer}`;

                        // Combine the date and time parts
                        return `${formattedDate} -${formattedTime}`;
                    },
                    getRowColorActed(type) {
                        if (type === 'return target') {
                            return '#faeeeb';
                        } else if (type === 'review target') {
                            return '#f0fafc';
                        } else if (type === 'approve target') {
                            return '#f7fcf8';
                        }
                        // else if (type === 'returned additional target (new)') {
                        //     return '#a61805';
                        // } else if (type === 'reviewed additional target (new)') {
                        //     return '#032c69';
                        // } else if (type === 'approved additional target (new)') {
                        //     return '#01820c';
                        // }
                        else if (type === 'return accomplishment') {
                            return '#faeeeb';
                        } else if (type === 'review accomplishment') {
                            return '#f0fafc';
                        } else if (type === 'approve accomplishment') {
                            return '#f7fcf8';
                        } else if (type === 'return semestral accomplishment') {
                            return '#faeeeb';
                        } else if (type === 'review semestral accomplishment') {
                            return '#f0fafc';
                        } else if (type === 'approve semestral accomplishment') {
                            return '#f7fcf8';
                        }
                        else if (type === 'returned additional target') {
                            return '#faeeeb';
                        } else if (type === 'reviewed additional target') {
                            return '#f0fafc';
                        } else if (type === 'approved additional target') {
                            return '#f7fcf8';
                        }
                        else {
                            return ''; // Default color or no color
                        }
                    },
                    getFontColorActed(type) {
                        // alert(type);
                        if (type === 'return target') {
                            return '#a61805';
                        } else if (type === 'review target') {
                            return '#032c69';
                        } else if (type === 'approve target') {
                            return '#01820c';
                        }
                        else if (type === 'returned additional target (new)') {
                            return '#a61805';
                        } else if (type === 'reviewed additional target (new)') {
                            return '#032c69';
                        } else if (type === 'approved additional target (new)') {
                            return '#01820c';
                        }
                        else if (type === 'return accomplishment') {
                            return '#a61805';
                        } else if (type === 'review accomplishment') {
                            return '#032c69';
                        } else if (type === 'approve accomplishment') {
                            return '#01820c';
                        } else if (type === 'return semestral accomplishment') {
                            return '#a61805';
                        } else if (type === 'review semestral accomplishment') {
                            return '#032c69';
                        } else if (type === 'approve semestral accomplishment') {
                            return '#01820c';
                        } else if (type === 'returned additional target') {
                            return '#a61805';
                        } else if (type === 'reviewed additional target') {
                            return '#032c69';
                        } else if (type === 'approved additional target') {
                            return '#01820c';
                        } else {
                            return ''; // Default color or no color
                        }
                    },
                    // isLastDayOfSem(semester, year) {
                    //     const currentDate = new Date();
                    //     return currentDate;
                    // },
                    isLastDayOfSem(sem, year) {
                        // Get the current date
                        const currentDate = new Date();

                        // Determine the last month and last day of the passed semester
                        let lastDay, lastMonth, semester;
                        semester = parseInt(sem, 10);
                        if (semester === 1) {
                            lastDay = 30;  // June 30th for the first semester
                            lastMonth = 5; // Month is 0-indexed, so 5 represents June
                        } else if (semester === 2) {
                            lastDay = 31;  // December 31st for the second semester
                            lastMonth = 11; // Month is 0-indexed, so 11 represents December
                        } else {
                            console.error("Invalid semester passed. Use 1 for first semester or 2 for second semester.");
                            return false;
                        }

                        // Construct the date for the last day of the semester
                        const semesterEndDate = new Date(year, lastMonth, lastDay);
                        // alert(currentDate + ' semEndDate: ' + semesterEndDate)
                        var dtt = currentDate + ' semEndDate: ' + semesterEndDate;
                        return dtt;
                        // Compare the current date with the constructed semester end date
                        // return currentDate >= semesterEndDate;
                    },
                    isPastDate(semester, monthv, yearv) {
                        // Get the current date
                        const currentDate = new Date();
                        var sem = parseInt(semester);
                        var month = parseInt(monthv);
                        var year = parseInt(yearv);
                        if (sem > 1) {
                            month = month + 6;
                        }
                        // Get the last day of the passed month and year
                        const lastDay = new Date(year, month, 0); // 0 will give the last day of the previous month
                        // return lastDay + ' currentDay: ' + currentDate + '\nmonth: ' + month + '\nyear: ' + year
                        // Compare current date with the constructed date (last day of the passed month/year)
                        if (currentDate > lastDay) {
                            return true; // Current date is later than or equal to the constructed date
                        } else {
                            return false; // Current date is earlier than the constructed date
                        }
                    },
                    filterNumbers(event, cats_num) {
                        cats_num = event.target.value.replace(/\D/g, ''); // Remove non-numeric characters
                    },
                    getEmpType(designation_type) {
                        const map = {
                            hdiv: 'Hospital DPCR',
                            hos: 'HPCR',
                            hsec: 'Hospital SPCR'
                        };
                        return map[designation_type] || null;
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
