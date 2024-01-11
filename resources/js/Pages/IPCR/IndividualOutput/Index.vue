<template>
    <Head>
        <title>Home</title>
    </Head>

    <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <!--SEMESTRAL***************************************************************************************-->
            <h3>Individual Final Outputs</h3>
            <div class="peers">
                <div class="peer mR-10">
                    <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search...">
                </div>
                <div class="peer">
                    <!-- /ipcrsemestral/create/{{ id }}/semestral {{ source }} -->
                    <Link class="btn btn-primary btn-sm" :href="`/individual-final-output-crud/create`">
                    Add IPCR
                    </Link>
                    <button class="btn btn-primary btn-sm mL-2 text-white" @click="showFilter()">Filter</button>
                </div>
                <!-- <Link>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                    <path fill-rule="evenodd"
                        d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
                </svg>
                </Link> -->
            </div>

        </div>
        <!-- {{ offices }} -->
        <filtering v-if="filter" @closeFilter="filter = false">
            <h4>Filter By</h4>
            <!-- office_selected: {{ office_selected }} -->
            <!-- {{ offices[0].ffunccod }} -->
            Office:
            <select class="form-select" v-model="office_selected" @change="filterOffices">
                <option value=""></option>
                <option v-for="office in offices" :value="office.ffunccod">
                    {{ office.office }}
                </option>
            </select>
            <!-- Major Final Outputs
            {{ mfos }}
            <select class="form-select" v-model="idmfo" @change="loadSubMFOs">
                <option value=""></option>
                <option v-for="mfo in mfos" :value="mfo.id">
                    {{ mfo.mfo_desc }}
                </option>
            </select> -->
        </filtering>
        <div class="masonry-sizer col-md-6"></div>
        <div class="masonry-item w-100">
            <div class="row gap-20"></div>
            <div class="bgc-white p-20 bd">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless table-striped table-hover">
                        <thead>
                            <tr style="background-color: #B7DEE8;">
                                <th>IPCR Code</th>
                                <th>MAJOR FINAL OUTPUT</th>
                                <th>SUB-MFO</th>
                                <th>Division Output</th>
                                <th>Individual Output</th>
                                <th>Performance Measure</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="dat in data.data">
                                <tr>
                                    <td>
                                        {{ dat.ipcr_code }}
                                    </td>
                                    <td>
                                        {{ dat.mfo_desc }}
                                    </td>
                                    <td>
                                        {{ dat.submfo_description }}
                                    </td>
                                    <td>
                                        {{ dat.output }}
                                    </td>
                                    <td>
                                        {{ dat.individual_output }}
                                    </td>
                                    <td>
                                        {{ dat.performance_measure }}
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
                                                <li>
                                                    <Link class="dropdown-item"
                                                        :href="`/individual-final-output-crud/${dat.id}/edit`">
                                                    Edit
                                                    </Link>
                                                </li>
                                                <li>
                                                    <Button class="dropdown-item" @click="deleteIPCR(dat.id)">
                                                        Delete
                                                    </Button>
                                                </li>
                                            </ul>
                                        </div>
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
                <iframe :src="my_link" style="width:100%; height:500px" />
            </div>
        </Modal>
        <!-- PGHEAD: {{ pgHead }} -->
    </div>
</template>
<script>
import Filtering from "@/Shared/Filter";
import Pagination from "@/Shared/Pagination";
import Modal from "@/Shared/PrintModal";
// import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        auth: Object,
        data: Object,
        offices: Object
    },
    data() {
        return {
            my_link: "",
            displayModal: false,
            modal_title: "Add",
            sem_id: "",
            period: "",
            sem: "",
            year: "",
            nxt: "",
            imm: "",

            //Data VARIABLES NEW*****
            filter: false,
            office_selected: "",
            search: "",
            mfos: [],
            sub_mfos: []
        }
    },
    watch: {
        search: _.debounce(function (value) {
            this.$inertia.get(
                "/individual-final-output-crud",
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
        Pagination, Filtering, Modal
    },

    methods: {
        deleteIPCR(ipcr_id) {
            let text = "WARNING!\nAre you sure you want to delete this IPCR?";
            if (confirm(text) == true) {
                this.$inertia.delete("/individual-final-output-crud/delete/" + ipcr_id);
            }
        },

        showCreate() {
            // this.$inertia.get(
            //     "/targets/create",
            //     {
            //         raao_id: this.raao_id
            //     },
            //     {
            //         preserveScroll: true,
            //         preserveState: true,
            //         replace: true,
            //     }
            // );
        },
        // deleteIPCR(id) {
        //     // let text = "WARNING!\nAre you sure you want to delete the Program and Projects? " + id;
        //     // if (confirm(text) == true) {
        //     //     this.$inertia.delete("/paps/" + id + "/" + this.idmfo);
        //     // }
        // },
        getToRep() {
            // alert(data[0].FFUNCCOD);
            var linkt = "http://";
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA,Sales%7Cpa1%3DSweden&_flowId=viewReportFlow&reportUnit=%2Freports%2FIPCR%2FIPCR_Target&standAlone=true&ParentFolderUri=%2Freports%2FIPCR&standAlone=true&decorate=no&output=pdf';
            this.position_long_title = this.auth.user.name.position_long_title
            var params = '&id=' + this.sem_id +
                '&employee_name=' + this.emp.employee_name +
                '&emps_status=' + this.emp.employment_type_descr.toUpperCase() +
                '&office=' + this.office.FFUNCTION.toUpperCase() +
                '&division=' + this.division +
                '&immediate=' + this.imm +
                '&next_higher=' + this.nxt +
                '&sem=' + this.sem +
                '&year=' + this.year +
                '&position=' + this.position_long_title +
                '&period=' + this.period.toUpperCase() +
                '&pghead=' + this.pgHead;
            var link1 = linkt + jasper_ip + jasper_link + params;
            return link1;
        },

        showModal(my_sem_id, sem, my_year, next, immed) {
            //this.my_link = this.getToRep(ffunccod, ffunction, MOOE, PS);
            this.sem_id = my_sem_id;
            this.period = this.getPeriod(sem, my_year);
            this.sem = this.getSemester(sem);
            this.year = my_year;
            this.nxt = next;
            this.imm = immed;
            // if (title_pass === "add") {
            //     this.modal_title = "Add";
            // } else {
            //     this.modal_title = "Edit";
            // }
            this.my_link = this.getToRep();
            this.displayModal = true;


        },

        hideModal() {
            this.displayModal = false;
        },
        showFilter() {
            this.filter = !this.filter;
        },
        filterOffices() {
            alert(this.office_selected)
            this.$inertia.get(
                "/individual-final-output-crud",
                {
                    // search: value,
                    office: this.office_selected
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );

            // this.loadMFOs();
            this.$nextTick(() => {
                this.loadMFOs();
            });

        },
        async loadMFOs() {
            this.mfos = [];
            this.sub_mfos = [];
            this.div_outputs = [];
            this.idmfo = "";
            this.idsubmfo = "";
            // alert(this.office_selected);
            try {
                if (this.ffunccod) {
                    const response = await axios.post('/fetch/data/major/final/outputs', {
                        FFUNCCOD: this.office_selected,
                    });

                    this.mfos = response.data;

                    // Ensure reactivity if needed (consider Vue.set for nested data)
                    this.$forceUpdate();
                }
            } catch (error) {
                console.error("Error fetching MFOs:", error);
                // Handle the error appropriately (e.g., display an error message)
            }
        },
        // async loadMFOs() {
        //     this.mfos = [];
        //     this.sub_mfos = [];
        //     this.div_outputs = [];
        //     this.idmfo = "";
        //     this.idsubmfo = "";
        //     alert(this.office_selected);
        //     if (this.ffunccod) {
        //         await axios.post('/fetch/data/major/final/outputs', {
        //             FFUNCCOD: this.office_selected
        //         }).then((response) => {
        //             this.mfos = response.data
        //         })
        //     }
        // },
        async loadSubMFOs() {
            this.sub_mfos = [];
            this.form.idsubmfo = "";
            // alert("idmfo: " + this.form.idmfo)
            if (this.form.idmfo) {
                await axios.post('/fetch/data/sub/mfos', {
                    idmfo: this.form.idmfo
                }).then((response) => {
                    this.sub_mfos = response.data
                })
            }


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
