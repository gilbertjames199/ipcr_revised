<template>

    <Head>
        <title>Home</title>
    </Head>
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>Employee's Semestral Rating - {{ Semester(sem) + " " + year }}</h3>
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
            <!-- {{ office }} oofice -->
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
        <div class="masonry-sizer col-md-6">
            <div class="peers fxw-nw jc-sb ai-c">
                <div>
                    <b>Office:</b>&nbsp;<u><span v-if="data">{{ data[0].office.office }}</span></u><br>
                </div>
            </div>
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
                                <th style="width: 20%;" colspan="4">Rating</th>
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
                                    <td>{{ dat.adjectivalRating }}</td>
                                </tr>

                            </template>
                            <tr>
                                <td colspan="2"><b style="float:right">Employee's Total Average Rating</b></td>
                                <td>{{ averageRate }}</td>
                            </tr>
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
        data: Object,
        year: String,
        sem: String,
        office: String,
        pgHead: String,
    },
    data() {
        return {
            displayModal: false,
            my_link: "",
            averageRate: 0,
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
    mounted() {
        this.calculateAverageRate()
    },

    methods: {
        Semester(sem) {
            var result = "";
            if (sem == "1") {
                result = "January to June";
            } else if (sem == "2") {
                result = "July to December"
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
        calculateAverageRate() {
            let sum = 0;
            let num_of_data = 0;
            let average = 0;

            if (Array.isArray(this.data)) {
                this.data.forEach(item => {
                    if (item.numericalRating !== 0) {
                        num_of_data += 1;
                        sum += parseFloat(item.numericalRating);
                        average = sum / num_of_data;
                    }
                    // console.log(num_of_data);
                });
            }
            this.averageRate = average.toFixed(2);
            // console.log(this.averageRate)
            return this.averageRate;
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
