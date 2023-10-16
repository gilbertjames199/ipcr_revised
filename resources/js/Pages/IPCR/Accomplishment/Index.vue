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
                <div class="peer mR-10">
                    <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search...">
                </div>
                <div class="peer">
                    <!-- /ipcrsemestral/create/{{ id }}/semestral {{ source }} -->
                    <Link class="btn btn-primary btn-sm" :href="`/ipcrsemestral/create/${id}/${source}`">Add IPCR </Link>
                </div>
                <Link v-if="source !== 'direct'" :href="`/employees`">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                    <path fill-rule="evenodd"
                        d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
                </svg>
                </Link>
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
                    <table class="table table-sm table-borderless table-striped table-hover">
                        <thead>
                            <tr style="background-color: #B7DEE8;">
                                <th>Semester</th>
                                <th>Period</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="sem in sem_data.data">
                                <td>
                                    <div v-if="sem.sem === '1'">First Semester</div>
                                    <div v-else>Second Semester</div>
                                </td>
                                <td>
                                    <div v-if="sem.sem === '1'">January to June {{ sem.year }}</div>
                                    <div v-else>July to December {{ sem.year }} </div>
                                    <!-- {{ sem }} -->
                                </td>
                                <td>
                                    <div v-if="sem.status === '-1'">Saved</div>
                                    <div v-if="sem.status === '0'">Submitted</div>
                                    <div v-if="sem.status === '1'">Reviewed</div>
                                    <div v-if="sem.status === '2'">Approved</div>
                                    <!-- {{ sem.status }} -->
                                </td>
                                <td>
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
                                            <li v-if="sem.sem === '1'">
                                                <Link class="dropdown-item" :href="`/link`">January </Link>
                                            </li>
                                            <li v-if="sem.sem === '1'">
                                                <Link class="dropdown-item" :href="`/link`">February </Link>
                                            </li>
                                            <li v-if="sem.sem === '1'">
                                                <Link class="dropdown-item" :href="`/link`">March </Link>
                                            </li>
                                            <li v-if="sem.sem === '1'">
                                                <Link class="dropdown-item" :href="`/link`">April </Link>
                                            </li>
                                            <li v-if="sem.sem === '1'">
                                                <Link class="dropdown-item" :href="`/link`">May </Link>
                                            </li>
                                            <li v-if="sem.sem === '1'">
                                                <Link class="dropdown-item" :href="`/link`">June </Link>
                                            </li>
                                            <li v-if="sem.sem === '2'">
                                                <Link class="dropdown-item" :href="`/link`">July </Link>
                                            </li>
                                            <li v-if="sem.sem === '2'">
                                                <Link class="dropdown-item" :href="`/link`">August </Link>
                                            </li>
                                            <li v-if="sem.sem === '2'">
                                                <Link class="dropdown-item" :href="`/link`">September </Link>
                                            </li>
                                            <li v-if="sem.sem === '2'">
                                                <Link class="dropdown-item" :href="`/link`">October </Link>
                                            </li>
                                            <li v-if="sem.sem === '2'">
                                                <Link class="dropdown-item" :href="`/link`">November </Link>
                                            </li>
                                            <li v-if="sem.sem === '2'">
                                                <Link class="dropdown-item" :href="`/link`">December </Link>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
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
    },
    data() {
        return {
            my_link: "",
            displayModal: false,
            modal_title: "Add"
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
    }
};
</script>
<style>
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
</style>
