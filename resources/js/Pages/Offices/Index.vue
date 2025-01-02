<template>
    <!-- {{ offices }}
       -->

    <Head>
        <title>Offices</title>
    </Head>

    <div class="row gap-10 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>Summary of Ratings</h3>
            <div class="peers">

                <div class="peer">
                    <button class="btn btn-primary btn-sm mL-2 text-white" @click="showFilterP()">Print Summary</button>
                </div>
            </div>
        </div>
        <FilterPrinting v-if="filter_p" @closeFilter="filter_p = false">
            Employment type
            <select v-model="type_filter" class="form-control">
                <option value="RE">Regular</option>
                <option value="CE">Casual</option>
                <option value="JO">Job Order</option>
            </select>

            Semester
            <select v-model="sem_filter" class="form-control">
                <option value="1">January to June</option>
                <option value="2">July to December</option>
            </select>

            Year
            <select v-model="year_filter" class="form-control">
                <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
            </select>
            <button class="btn btn-sm btn-primary mT-5 text-white" @click="printSubmit()">Print Report</button>
        </FilterPrinting>
        <div class="col-12">
            <div class="bgc-white p-20 bd">
                <table class="table table-hover table-striped">
                    <thead style="background-color: #b7dde8;">
                        <tr>
                            <th>Office</th>
                            <th scope="col" style="text-align: right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="office in offices">
                            <td>{{ office.office }}</td>
                            <td style="text-align: right">
                                <div class="dropdown dropstart">
                                    <button class="btn btn-secondary btn-sm action-btn" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                            <path
                                                d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu action-dropdown" aria-labelledby="dropdownMenuButton1">
                                        <li class="dropdown-item">
                                            <Link :href="`/summary-rating/alloffices/${office.department_code}`">
                                            IPCR Summary
                                            </Link>
                                        </li>
                                        <li class="dropdown-item" v-if="auth.user.username=='8510' || auth.user.username=='8354'">
                                            <Link :href="`/offices/${office.department_code}`">
                                            Set PG Head
                                            </Link>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Modal v-if="displayModal" @close-modal-event="hideModal">
            <!-- {{ my_link }} -->
            <div class="d-flex justify-content-center">
                <iframe :src="my_link" style="width:100%; height:500px;" />
            </div>
        </Modal>
    </div>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";
import FilterPrinting from "@/Shared/FilterPrint";
import Modal from "@/Shared/PrintModal1";
export default {
    props: {
        auth: Object,
        Year: Object,
        can: Object,
        permissions_all: Object,
        offices: Object,
        // divisions: Object,
    },
    data() {
        return {
            displayModal: false,
            filter_p: false,
            type_filter: "",
            sem_filter: "",
            year_filter: new Date().getFullYear(), // default to the current year
            years: []
        }
    },
    watch: {

    },
    mounted() {
        this.populateYears();
    },
    components: {
        Modal, FilterPrinting,
    },
    methods: {
        showFilterP() {
            // alert("show filter");
            this.filter_p = !this.filter_p
        },
        populateYears() {
            const startYear = 2020;
            const endYear = 2031;
            for (let year = startYear; year <= endYear; year++) {
                this.years.push(year);
            }
        },
        printSubmit() {
            // console.log(this.auth.user.username);
            this.my_link = this.viewlink(this.year_filter, this.sem_filter, this.type_filter, this.auth.user.username);

            this.showModal();
        },
        viewlink(year, sem, type, emp_code) {
            var linkt = "http://";
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA%2CSales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2FIPCR&reportUnit=%2Freports%2FIPCR%2FSummaryRatingAllOffices&standAlone=true&decorate=no&output=pdf';
            var params = '&year=' + year + '&sem=' + sem + '&employment_type=' + type + '&emp_code=' + emp_code;
            var linkl = linkt + jasper_ip + jasper_link + params;
            console.log(linkl);
            return linkl;
        },
        showModal() {
            this.displayModal = true;
        },
        hideModal() {
            this.displayModal = false;
        },
    }
}
</script>
