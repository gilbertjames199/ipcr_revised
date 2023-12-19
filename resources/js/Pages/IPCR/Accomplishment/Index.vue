<template>
    <Head>
        <title>Home</title>
    </Head>

    <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <!--SEMESTRAL***************************************************************************************-->
            <h3>Accomplishment </h3>
            <div class="peers">
                <!-- <div class="peer mR-10">
                    <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search...">
                </div> -->
                <!-- <div class="peer"> -->
                <!-- /ipcrsemestral/create/{{ id }}/semestral {{ source }} -->
                <!-- <Link class="btn btn-primary btn-sm" :href="`/ipcrsemestral/create/${id}/${source}`">Add IPCR </Link>
                </div> -->
                <Link v-if="source !== 'direct'" :href="`/employees`">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                    <path fill-rule="evenodd"
                        d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
                </svg>
                </Link>
                <!-- <button class='btn btn-primary text-white' @click="generateIPCR()">Generate IPCR</button> -->
            </div>

        </div>
        <div>
            <div><b>Employee Name: </b><u>{{ emp.employee_name }}</u></div>
            <div><b>Position: </b><u>{{ emp.position_long_title }}</u></div>
            <div><b>Division: </b><u>{{ division }}</u></div>
        </div>

        <div class="masonry-sizer col-md-6"></div>
        <div class="masonry-item w-100">
            <div class="row gap-20"></div>
            <div class="bgc-white p-20 bd">
                <div class="table-responsive">
                    <!--table-borderless table-striped -->
                    <table class="table table-sm table-hover table-borderless table-striped">
                        <thead>
                            <tr style="background-color: #B7DEE8;">
                                <th>&nbsp;&nbsp;</th>
                                <th>Semester</th>
                                <th>Period</th>
                                <th>Status</th>
                                <!-- <th>Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="sem in sem_data">
                                <tr :class="{ opened: opened.includes(sem.id) }" @click="toggle(sem.id)"
                                    style="cursor: pointer">
                                    <td>
                                        <a class="dropdown-toggle" href="javascript:void(0);">
                                            <span class="icon-holder">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-clipboard-check-fill"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z" />
                                                    <path
                                                        d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1Zm6.854 7.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708Z" />
                                                </svg>
                                            </span>
                                            <span class="arrow">
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        {{ getSemester(sem.sem) }}
                                    </td>
                                    <td>
                                        {{ getPeriod(sem.sem, sem.year) }}
                                    </td>
                                    <td>
                                        {{ getStatus(sem.status) }}
                                    </td>

                                </tr>
                                <tr v-if="opened.includes(sem.id)">
                                    <td colspan="6" class="background-white">
                                        <!---->
                                        <Transition name="bounce">
                                            <!-- v-if="show" -->
                                            <p v-if="show">
                                            <table class="table-responsive full-width">
                                                <tbody>
                                                    <tr>
                                                        <th></th>
                                                        <th class="text-white text-center "
                                                            style="background-color: #727272;" colspan="4">
                                                            <h6>&nbsp;&nbsp;MONTHLY ACCOMPLISHMENT</h6>
                                                        </th>
                                                        <th></th>
                                                    </tr>
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <td rowspan="2"></td>
                                                        <th class="my-td text-center text-white"
                                                            style="background-color: #92a2a2;" rowspan="2">
                                                            &nbsp;&nbsp;PERIOD
                                                        </th>
                                                        <th class="my-td text-center text-white"
                                                            style="background-color: #92a2a2;" rowspan="2">STATUS</th>
                                                        <th class="my-td text-center text-white"
                                                            style="background-color: #92a2a2;" colspan="2">ACTIONS</th>
                                                        <td rowspan="2"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="my-td text-center text-white"
                                                            style="background-color: #727272;">SUBMIT</th>
                                                        <th class="my-td text-center text-white"
                                                            style="background-color: #727272;">VIEW</th>
                                                    </tr>
                                                </tbody>
                                                <tbody>
                                                    <tr v-for="my_sem in sem.monthly_accomplishment">
                                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                                        <td class="my-td text-center">&nbsp;&nbsp;{{
                                                            getMonthName(my_sem.month) }}, {{ my_sem.year }}</td>
                                                        <td class="my-td text-center">
                                                            {{ getStatus(my_sem.status) }}
                                                            <p v-if="getStatus(my_sem.status) == 'Returned'">
                                                                Remarks:
                                                                <span v-if="my_sem.rem">{{ my_sem.rem.remarks
                                                                }}</span>
                                                            </p>
                                                        </td>
                                                        <td class="my-td text-center">
                                                            <button class="btn btn-primary text-white"
                                                                :class="my_sem.status >= 0 ? 'btn btn-secondary text-white' : 'btn btn-primary text-white'"
                                                                @click="submitMonthlyAccomplishment(my_sem.id, sem.id)"
                                                                :disabled="my_sem.status >= 0">
                                                                Submit
                                                            </button>
                                                        </td>
                                                        <td class="my-td text-center">
                                                            <button
                                                                @click="JanuaryAccomplishment(getMonthName(my_sem.month), sem.year)"
                                                                class="btn btn-primary text-white">
                                                                View
                                                            </button>
                                                        </td>
                                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                                        <td class="my-td text-center">&nbsp;&nbsp;</td>
                                                        <td class="my-td text-center">

                                                        </td>
                                                        <td class="my-td text-center">
                                                            <button class="btn btn-primary text-white">
                                                                Generate Semestral
                                                            </button>
                                                        </td>

                                                        <td class="my-td text-center">
                                                            <Link :href="`/semester-accomplishment/semestral/accomplishment/${sem.id}`"
                                                                class="btn btn-primary text-white">
                                                                View
                                                            </Link>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            </p>
                                        </Transition>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                    <pagination :next="data.next_page_url" :prev="data.prev_page_url" />
                </div>
            </div>
        </div>
        <Modal v-if="displayModal" @close-modal-event="hideModal">
            <div class="d-flex justify-content-center">
                <h4>{{ modal_title }}</h4>
            </div>
        </Modal>
        <div v-if="show">show</div>
    </div>
</template>
<script>
import Filtering from "@/Shared/Filter";
import Pagination from "@/Shared/Pagination";
import Modal from "@/Shared/PrintModal";
export default {
    props: {
        data: Object,
        MOOE: String,
        PS: String,
        id: String,
        emp: Object,
        division: Object,
        source: String,
        sem_data: Object,
        shown_id: String
    },
    mounted() {
        // alert(this.shown_id)
    },
    data() {
        return {
            my_link: "",
            displayModal: false,
            modal_title: "Add",
            opened: [],
            sem1: ['January', 'February', 'March', 'April', 'May', 'June'],
            sem2: ['July', 'August', 'September', 'October', 'November', 'December'],
            show: false,
            //search: this.$props.filters.search,
        }
    },
    watch: {
        search: _.debounce(function (value) {
            this.$inertia.get(
                "/paps/" + this.idmfo,
                { search: value },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
        }, 300),
    },
    components: {
        Pagination, Filtering, Modal,
    },

    methods: {
        deleteIPCR(ipcr_id) {
            let text = "WARNING!\nAre you sure you want to delete this IPCR?";
            if (confirm(text) == true) {
                this.$inertia.delete("/ipcrsemestral/delete/" + ipcr_id + '/' + this.source);
            }
        },
        submitIPCR(ipcr_id) {
            // alert(ipcr_id);
            let text = "WARNING!\nAre you sure you want to submit this IPCR?";
            if (confirm(text) == true) {
                this.$inertia.post("/ipcrsemestral/submit/" + ipcr_id + '/' + this.source);
            }
        },
        showCreate() {
            this.$inertia.get(
                "/targets/create",
                {
                    raao_id: this.raao_id
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
        },
        deletePAPS(id) {
            let text = "WARNING!\nAre you sure you want to delete the Program and Projects? " + id;
            if (confirm(text) == true) {
                this.$inertia.delete("/paps/" + id + "/" + this.idmfo);
            }
        },
        getToRep(ffunccod, ffunction, MOOE, PS) {
            // alert(data[0].FFUNCCOD);
            var linkt = "http://";
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA,Sales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2Fplanning_system%2FOPCR_Standard&reportUnit=%2Freports%2Fplanning_system%2FOPCR_Standard%2FOPCR&standAlone=true&decorate=no&output=pdf';
            var params = '&id=' + ffunccod + '&FUNCTION=' + ffunction + '&MOOE=' + MOOE + '&PS=' + PS;
            var link1 = linkt + jasper_ip + jasper_link + params;
            return link1;
        },
        showModal(title_pass, emp_id) {
            //this.my_link = this.getToRep(ffunccod, ffunction, MOOE, PS);
            if (title_pass === "add") {
                this.modal_title = "Add";
            } else {
                this.modal_title = "Edit";
            }
            this.displayModal = true;

        },
        hideModal() {
            this.displayModal = false;
        },
        JanuaryAccomplishment(month, year) {
            this.$inertia.get(
                "/Accomplishment/",
                {
                    month: month,
                    year: year
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
        },
        toggle(id) {
            const index = this.opened.indexOf(id);
            if (index > -1) {
                // this.opened.splice(index, 1)
            } else {
                this.opened = [];
                this.opened.push(id)
            }
            // alert(this.show);
            setTimeout(() => {
                // alert(this.show);
                this.show = !this.show;
            }, 100);
        },
        submitMonthlyAccomplishment(my_id, id_shown) {
            // alert(id)
            let text = "WARNING!\nAre you sure you want to submit this Monthly Accomplishment? ";
            if (confirm(text) == true) {
                const params = {
                    id_shown: id_shown
                };
                const url = '/monthly-accomplishment/submit/monthly/accomplishment/' + my_id;
                // axios.get(url);
                this.$inertia.get(url, params, {
                    preserveState: true,
                });
            }

        },
        generateIPCR() {
            const url = '/monthly-accomplishment/generate/monthly';
            axios.get(url);
        }
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
