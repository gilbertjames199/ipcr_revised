<template>
    <Head>
        <title>Home</title>
    </Head>

    <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
    <!-- id: {{ this.id }} -->
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <!-- {{ sem }} -->
            <h3>IPCR Targets - {{ getPeriod(sem.sem, sem.year) }} </h3>
            <div class="peers">
                <div class="peer mR-10">
                    <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search...">
                </div>
                <div class="peer">
                    <Link v-if="stat_num < 1" class="btn btn-primary btn-sm" :href="`/ipcrtargets/create/${id}`">Add IPCR
                    Codes</Link>&nbsp;
                    <Link v-if="stat_num > 1" class="btn btn-primary btn-sm"
                        :href="`/ipcrtargets/create/${id}/additional/ipcr/targets`">Additional IPCR Targets </Link>&nbsp;
                </div>
                <Link :href="`/ipcrsemestral/${emp.id}/direct`">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                    <path fill-rule="evenodd"
                        d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
                </svg>
                </Link>&nbsp;
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
                                <th>IPCR Code</th>
                                <th>MFO</th>
                                <th>Sub MFO</th>
                                <th>Division Output</th>
                                <th>Individual Final Output</th>
                                <th>Performance Measure</th>
                                <th>Remarks </th>
                                <th v-if="sem.status < 1">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td :colspan="sem.status < 1 ? 8 : 7">
                                    <b>CORE FUNCTION</b>
                                </td>
                            </tr>
                            <template v-for="ifo in data">
                                <tr v-if="ifo.ipcr_type === 'Core Function'">
                                    <td>{{ ifo.ipcr_code }} </td>
                                    <td>{{ ifo.mfo_desc }}</td>
                                    <td>{{ ifo.submfo_description }}</td>
                                    <td>{{ ifo.div_output }}</td>
                                    <td>{{ ifo.individual_output }}
                                        <span v-if="ifo.is_additional_target > 0">
                                            ( Additional Target)
                                        </span>
                                    </td>
                                    <td>{{ ifo.performance_measure }}</td>
                                    <td>{{ ifo.remarks }}</td>
                                    <td v-if="sem.status < 1">
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
                                                <li>
                                                    <Link class="dropdown-item" :href="`/ipcrtargets/edit/${ifo.id}`">Edit
                                                    </Link>
                                                </li>
                                                <li><button class="dropdown-item"
                                                        @click="deleteIPCR(ifo.id)">Delete</button></li>
                                                <!-- <li>
                                                    <button class="dropdown-item"
                                                        @click="showModal(functional.FFUNCCOD,functional.FFUNCTION,
                                                        functional.MOOE,
                                                        functional.PS)"
                                                        > View OPCR Standard
                                                    </button>
                                                </li> -->
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <tr>
                                <td :colspan="sem.status < 1 ? 8 : 7">
                                    <b>SUPPORT FUNCTION</b>
                                </td>
                            </tr>
                            <template v-for="ifo in data">
                                <tr v-if="ifo.ipcr_type === 'Support Function'">
                                    <td>{{ ifo.ipcr_code }} </td>
                                    <td>{{ ifo.mfo_desc }}</td>
                                    <td>{{ ifo.submfo_description }}</td>
                                    <td>{{ ifo.div_output }}</td>
                                    <td>{{ ifo.individual_output }}
                                        <span v-if="ifo.is_additional_target > 0">
                                            ( Additional Target)
                                        </span>
                                    </td>
                                    <td>{{ ifo.performance_measure }}</td>
                                    <td>{{ ifo.remarks }} </td>
                                    <td v-if="sem.status < 1">
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
                                                <li>
                                                    <Link class="dropdown-item" :href="`/ipcrtargets/edit/${ifo.id}`">Edit
                                                    </Link>
                                                </li>
                                                <li><button class="dropdown-item"
                                                        @click="deleteIPCR(ifo.id)">Delete</button></li>
                                                <!-- <li>
                                                    <button class="dropdown-item"
                                                        @click="showModal(functional.FFUNCCOD,functional.FFUNCTION,
                                                        functional.MOOE,
                                                        functional.PS)"
                                                        > View OPCR Standard
                                                    </button>
                                                </li> -->
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                    <!-- <pagination :next="data.next_page_url" :prev="data.prev_page_url" /> -->
                    <!-- <div class="row justify-content-center">
                        <div >
                           read the explanation in the Paginate.vue component
                            <pagination :links="users.links" /> >

                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <Modal v-if="displayModal" @close-modal-event="hideModal">
            <div class="d-flex justify-content-center">
                <h4>{{ modal_title }}</h4>
            </div>
        </Modal>
        <!-- {{ sem }} -->
    </div>
</template>
<script>
import Filtering from "@/Shared/Filter";
import Pagination from "@/Shared/Pagination";
import Modal from "@/Shared/PrintModal";
export default {
    props: {
        data: Object,
        // MOOE: String,
        // PS: String,
        filters: Object,
        sem: Object,
        id: String,
        emp: Object,
        division: Object,
    },
    data() {
        return {
            my_link: "",
            displayModal: false,
            modal_title: "Add",
            stat_num: 0,
            search: ""
            //search: this.$props.filters.search,
        }
    },
    watch: {
        search: _.debounce(function (value) {
            this.$inertia.get(
                "/ipcrtargets/" + this.id,
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
    mounted() {
        this.stat_num = parseFloat(this.sem.status)
    },
    methods: {
        deleteIPCR(ipcr_id) {
            let text = "WARNING!\nAre you sure you want to delete the Research Agenda?";
            // alert("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete")
            if (confirm(text) == true) {
                this.$inertia.delete("/ipcrtargets/" + ipcr_id + "/" + this.id + "/delete");
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
