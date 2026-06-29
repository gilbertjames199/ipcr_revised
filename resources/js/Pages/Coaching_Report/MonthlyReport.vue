<template>

    <Head>
        <title>Home</title>
    </Head>
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>Employee's Monthly Coaching Report - {{ month }}</h3>
            <div class="peers">
                <div class="peer mR-10">

                </div>
                <div class="peer">
<!--
                    <button class="btn btn-primary btn-sm mL-2 text-white" @click="printSubmit1">Print Summary
                    </button> -->

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
                                <th style="width: 40%;">Full Name</th>
                                <th style="width: 20%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
    <template v-for="(dat, index) in data" :key="index">
        <tr>
            <td>{{ dat.Fullname }}</td>
            <td class="text-center">
                <div class="dropdown">
                    <button
                        class="btn btn-primary btn-sm dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Actions
                    </button>

                    <ul class="dropdown-menu">

    <!-- If NO coaching report -->
    <li v-if="!dat['Has Coaching Report']">
        <a
            class="dropdown-item"
            :href="`/coaching-report/create?year=${year}&month=${month}&department_code=${office}&emp_code=${dat['Employee Code']}`"
        >
            Create Coaching Report
        </a>
    </li>

    <!-- If EXISTS coaching report -->
    <template v-else>
        <li>
            <a
                class="dropdown-item"
                :href="`/coaching-report/${dat['Coaching Report ID']}/edit`"
            >
                Edit Coaching Report
            </a>
        </li>

        <li>
            <a
                class="dropdown-item text-danger"
                @click.prevent="deleteOutput(dat['Coaching Report ID'])"
            >
                Delete Coaching Report
            </a>
        </li>

        <li>
            <a
                class="dropdown-item text-danger"
                @click="printSubmit1(dat['Employee Code'])"
            >
                View and Print Form
            </a>
        </li>
    </template>

</ul>
                </div>
            </td>
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
        deleteOutput(id) {
            let text = "WARNING!\nAre you sure you want to delete this Accomplishment?" + id;
            if (confirm(text) == true) {
                this.$inertia.delete("/coaching-report/" + id);
            }
        },
        printSubmit1(emp_code) {
            const monthMap = {
                    January: 1,
                    February: 2,
                    March: 3,
                    April: 4,
                    May: 5,
                    June: 6,
                    July: 7,
                    August: 8,
                    September: 9,
                    October: 10,
                    November: 11,
                    December: 12
                };

            const monthNumber = monthMap[this.month];
            console.log(this.year, monthNumber, this.office, emp_code);
            this.my_link = this.viewlink1(this.year, monthNumber, this.office, emp_code);
            this.showModal1();

            console.log(this.my_link)

        },
        viewlink1(year, month, office, emp_code) {
            var linkt = "https://";
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA%2CSales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2FIPCR&reportUnit=%2Freports%2FIPCR%2FCoaching_Report&standAlone=true&decorate=no&output=pdf';
            var params = '&emp_code=' + emp_code + '&month=' + month + '&year=' + year;
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
