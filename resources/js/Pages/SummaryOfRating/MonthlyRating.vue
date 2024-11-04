<template>

    <Head>
        <title>Home</title>
    </Head>
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>Employee's Monthly Rating - {{ month }}</h3>
            <div class="peers">
                <div class="peer mR-10">

                </div>
                <div class="peer">

                    <button class="btn btn-primary btn-sm mL-2 text-white" @click="printSubmit1">Print Summary
                    </button>

                </div>
                <div class="peer">

                </div>
            </div>

            <Link :href="'/summary-rating'">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                <path fill-rule="evenodd"
                    d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
            </svg>
            </Link>
        </div>

        <div class="masonry-sizer col-md-6"></div>
        <div class="masonry-item w-100">
            <div class="row gap-20"></div>
            <div class="bgc-white p-20 bd">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered border-dark table-hover">
                        <thead>
                            <tr style="background-color: #B7DEE8;" class="text-center table-bordered">
                                <th style="width: 5%;" rowspan="2" colspan="1">Full Name</th>
                                <th style="width: 20%;" colspan="2">Rating</th>
                                <th style="width: 5%;" rowspan="2" colspan="1">Points</th>
                            </tr>
                            <tr style="background-color: #B7DEE8;" class="text-center">
                                <th style="width: 5%;">Numerical Rating</th>
                                <th style="width: 5%;">Adjectival Rating</th>
                            </tr>
                            <tr>

                            </tr>
                        </thead>
                        <tbody>

                            <template v-for="(dat, index) in data" :key="index">
                                <tr>
                                    <td>{{ dat.Fullname }}</td>
                                    <td>{{ dat.numericalRating }}</td>
                                    <td>{{ dat.adjectivalRating == ""? 'No Rating': dat.adjectivalRating }}</td>
                                    <td>{{ Points(dat.numericalRating) }}</td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Modal v-if="displayModal" @close-modal-event="hideModal">
            <!-- {{ my_link }} -->
            <div class="d-flex justify-content-center">
                <iframe :src="my_link" style="width:100%; height:450px" />
            </div>
        </Modal>


    </div>
</template>
<script>

import { useForm } from "@inertiajs/inertia-vue3";
import Modal from "@/Shared/PrintModal";
import Modals from "@/Shared/Modal"
export default {
    props: {
        auth: Object,
        emp_code: String,
        data: Object,
        month: String,
        year: String,
        office: String,
        month_data: Object,
        dept: Object,
        pgHead: String,
        sem_id: String,
        status: String
    },
    data() {
        return {
            displayModal: false,
            my_link: "",
            form: useForm({
                remarks: "",
                remarks_id: "",
                year: "",
                month: "",
                idIPCR: "",
                idSemestral: "",
                emp_code: "",
            })

        }
    },
    components: {
       Modal, Modals,
    },

    methods: {
        Points(score){
            var result = 0;
            if(score >= 4.51 && score <= 5.00){
                result = 25;
            } else if (score >= 4.46 && score <= 4.5){
                result = 24;
            } else if (score >= 4.41 && score <= 4.45) {
                result = 23;
            } else if (score >= 4.36 && score <= 4.4) {
                result = 22;
            } else if (score >= 4.31 && score <= 4.35) {
                result = 21;
            } else if (score >= 4.26 && score <= 4.3) {
                result = 20;
            } else if (score >= 4.21 && score <= 4.25) {
                result = 19;
            } else if (score >= 4.16 && score <= 4.2) {
                result = 18;
            } else if (score >= 4.11 && score <= 4.15) {
                result = 17;
            } else if (score >= 4.06 && score <= 4.1) {
                result = 16;
            } else if (score >= 4.01 && score <= 4.05) {
                result = 15;
            } else if (score >= 3.51 && score <= 4) {
                result = 13;
            } else if (score >= 2.51 && score <= 3.5) {
                result = 10;
            } else if (score >= 1 && score <= 2.5) {
                result = 5;
            }

            return result;
        },
        printSubmit1() {

            this.my_link = this.viewlink1(this.year, this.month, this.office);
            this.showModal1();

            console.log(this.my_link)

        },
        viewlink1(year, month, office) {
            var linkt = "http://";
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA%2CSales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2FIPCR&reportUnit=%2Freports%2FIPCR%2FMonthlyRating&standAlone=true&decorate=no&output=pdf';
            var params = '&year=' + year + '&month=' + month + '&department_code=' + office;
            var linkl = linkt + jasper_ip + jasper_link + params;

            return linkl;
        },
        showModal1() {
            this.displayModal = true;
        },
        hideModal() {
            this.displayModal = false;
        },
    }
};
</script>
<style>
/***TABLE FULL WIDTH */
.full-width {
    width: 100%;
}

/**ACCORDION BEGIN*********************/
.my-table {
    width: 100%;
    border: 1px solid #ccc;
}

.my-td {
    padding: 2px;
    border: 1px solid #ccc;
}

.opened {
    background-color: rgb(2, 255, 251);
}

/**ACCORDION END*********************/
.row-centered {
    text-align: center;
}

.col-centered {
    display: inline-block;
    float: none;
    text-align: left;
    margin-right: -4px;
}

.pos {
    position: top;
    top: 240px;
}

/*TOGGLE FADE TRANSITION*/
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

/* transition */
.bounce-enter-active {
    animation: bounce-in 0.5s;
}

.bounce-leave-active {
    animation: bounce-in 0.5s reverse;
}

@keyframes bounce-in {
    0% {
        transform: scale(0);
    }

    50% {
        transform: scale(1.1);
    }

    100% {
        transform: scale(1);
    }


}
</style>
