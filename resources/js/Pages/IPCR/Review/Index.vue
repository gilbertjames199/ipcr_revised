<template>
    <Head>
        <title>Home</title>
    </Head>

    <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <!--SEMESTRAL***************************************************************************************-->
            <h3>Review/Approve Submissions</h3>
            <div class="peers">
                <div class="peer mR-10">
                    <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search...">
                </div>
            </div>

        </div>


        <div class="masonry-sizer col-md-6"></div>
        <div class="masonry-item w-100">
            <div class="row gap-20"></div>
            <div class="bgc-white p-20 bd">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless table-striped table-hover">
                        <thead>
                            <tr class="bg-secondary text-white">
                                <th></th>
                                <th>Name</th>
                                <th>Period</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr v-for="target in targets.data">
                                <td></td>
                                <td>{{ target.employee_name }}</td>
                                <td>
                                    <span v-if="target.sem==='1'">January to June, </span>
                                    <span v-if="target.sem==='2'">July to December, </span>
                                    {{ target.year }}
                                </td>
                                <td>
                                    <div v-if="target.status==='0'">Submitted</div>
                                    <div v-if="target.status==='1'">Reviewed</div>
                                </td>
                                <td>
                                    <div class="dropdown dropstart" >
                                        <button class="btn btn-secondary btn-sm action-btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                            <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu action-dropdown"  aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <button class="dropdown-item"
                                                    @click="showModal(target.id, target.empl_id, target.employee_name, target.year, target.sem, target.status)">
                                                        View Submission
                                                </button>
                                            </li>
                                            <li v-if="target.status==='1'">
                                                <Link class="dropdown-item" :href="`/ipcrtargets/${target.id}`" >Approve </Link>
                                            </li>
                                            <li v-if="target.status==='0'">
                                                <Link class="dropdown-item" :href="`/ipcrtargets/${target.id}`" >Review </Link>
                                            </li>
                                            <!-- <li><Link class="dropdown-item" :href="`/ipcrtargets/edit/${ifo.id}`">Edit</Link></li> -->
                                            <!-- <li><button class="dropdown-item" @click="deleteIPCR(ifo.id)">Delete</button></li> -->
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
                        </tbody>
                    </table>
                    <!-- <pagination :next="data.next_page_url" :prev="data.prev_page_url" /> -->
                </div>
            </div>
        </div>
        <Modal v-if="displayModal" @close-modal-event="hideModal">
            <div class="justify-content-center">
                <div style="text-align: center"><h4>IPCR Targets</h4></div>
                <br>
                <div><b>Employee Name: </b><u>{{ emp_name }}</u></div>
                <div>
                    <b>Period: </b>
                    <u>
                        <span v-if="emp_sem==='1'">January to June, </span>
                        <span v-if="emp_sem==='2'">July to December, </span>
                        {{ emp_year }}
                    </u>
                </div>
                <div>
                    <b>Status: </b>
                    <u>
                        <span v-if="emp_status==='0'">Submitted</span>
                        <span v-if="emp_status==='1'">Reviewed</span>
                    </u>
                </div>
                <div class="masonry-item w-100">
                    <div class="bgc-white p-20 bd">

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered border-dark">
                                <tr class="text-dark" style="background-color: #B7DEE8;">
                                    <th rowspan="2" style="text-align: center; background-color: #edd29d !important;">IPCR Code</th>
                                    <th rowspan="2">Individual Final Output</th>
                                    <th colspan="6" rowspan="1" style="text-align: center">Monthly Targets</th>
                                    <th rowspan="2" style="text-align: center">Semestral Target</th>
                                </tr>
                                <tr class="text-dark" style="background-color: #B7DEE8;">
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4</th>
                                    <th>5</th>
                                    <th>6</th>
                                </tr>
                                <tr class="bg-secondary text-white">
                                    <td ></td>
                                    <td colspan="8"><b>Core Function</b></td>
                                </tr>
                                <tr v-for="ipc in ipcr_targets">
                                    <td v-if="ipc.ipcr_type=='Core Function'" style="text-align: center; background-color: #edd29d">{{ ipc.ipcr_code }}</td>
                                    <td v-if="ipc.ipcr_type=='Core Function'">{{ ipc.individual_output }}</td>
                                    <td v-if="ipc.ipcr_type=='Core Function'">{{ ipc.month_1 }}</td>
                                    <td v-if="ipc.ipcr_type=='Core Function'">{{ ipc.month_2 }}</td>
                                    <td v-if="ipc.ipcr_type=='Core Function'">{{ ipc.month_3 }}</td>
                                    <td v-if="ipc.ipcr_type=='Core Function'">{{ ipc.month_4 }}</td>
                                    <td v-if="ipc.ipcr_type=='Core Function'">{{ ipc.month_5 }}</td>
                                    <td v-if="ipc.ipcr_type=='Core Function'">{{ ipc.month_6 }}</td>
                                    <td v-if="ipc.ipcr_type=='Core Function'" style="text-align: center">{{ ipc.quantity_sem }}</td>
                                </tr>
                                <tr class="bg-secondary text-white">
                                    <td ></td>
                                    <td colspan="8"><b>Support Function</b></td>
                                </tr>
                                <tr v-for="ipc in ipcr_targets">
                                    <td v-if="ipc.ipcr_type=='Support Function'" style="text-align: center; background-color: #edd29d">{{ ipc.ipcr_code }}</td>
                                    <td v-if="ipc.ipcr_type=='Support Function'">{{ ipc.individual_output }}</td>
                                    <td v-if="ipc.ipcr_type=='Support Function'">{{ ipc.month_1 }}</td>
                                    <td v-if="ipc.ipcr_type=='Support Function'">{{ ipc.month_2 }}</td>
                                    <td v-if="ipc.ipcr_type=='Support Function'">{{ ipc.month_3 }}</td>
                                    <td v-if="ipc.ipcr_type=='Support Function'">{{ ipc.month_4 }}</td>
                                    <td v-if="ipc.ipcr_type=='Support Function'">{{ ipc.month_5 }}</td>
                                    <td v-if="ipc.ipcr_type=='Support Function'">{{ ipc.month_6 }}</td>
                                    <td v-if="ipc.ipcr_type=='Support Function'" style="text-align: center">{{ ipc.quantity_sem }}</td>
                                </tr>
                            </table>

                        </div>

                    </div>

                </div>
                <div style="align: center">
                    <button class="btn btn-primary text-white"
                            @click="submitAction('1')"
                            v-if="emp_status==='0'"
                    >
                        Review
                    </button>
                    <button class="btn btn-primary text-white"
                            @click="submitAction('2')"
                            v-if="emp_status==='1'"
                    >
                        Approve
                    </button>
                </div>
                <!-- {{ ipcr_targets }} -->
            </div>
        </Modal>
    </div>
</template>
<script>
import Filtering from "@/Shared/Filter";
import Pagination from "@/Shared/Pagination";
import Modal from "@/Shared/PrintModal";
import Modal2 from "@/Shared/PrintModal";
export default {
    props: {
        targets: Object,
    },
    data() {
        return{
            my_link: "",
            displayModal: false,
            modal_title: "Add",
            ipcr_targets: [],
            emp_sem_id: "",
            emp_name:"",
            emp_year: "",
            emp_sem: "",
            emp_status: "",
            //search: this.$props.filters.search,
        }
    },
    watch: {
            search: _.debounce(function (value) {
            this.$inertia.get(
                "/paps/"+this.idmfo,
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

    methods:{
        deleteIPCR(ipcr_id) {
            // let text = "WARNING!\nAre you sure you want to delete the Research Agenda?";
            // // alert("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete")
            // if (confirm(text) == true) {
            //     this.$inertia.delete("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete");
            // }
        },
        showCreate(){
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
        deletePAPS(id) {
            // let text = "WARNING!\nAre you sure you want to delete the Program and Projects? "+id;
            //   if (confirm(text) == true) {
            //     this.$inertia.delete("/paps/" + id+"/"+this.idmfo);
            // }
        },
        getToRep(ffunccod, ffunction, MOOE, PS){
            // alert(data[0].FFUNCCOD);
            // var linkt="http://";
            // var jasper_ip = this.jasper_ip;
            // var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA,Sales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2Fplanning_system%2FOPCR_Standard&reportUnit=%2Freports%2Fplanning_system%2FOPCR_Standard%2FOPCR&standAlone=true&decorate=no&output=pdf';
            // var params = '&id=' + ffunccod + '&FUNCTION=' + ffunction + '&MOOE=' + MOOE + '&PS=' + PS;
            // var link1 = linkt + jasper_ip +jasper_link + params;
            // return link1;
        },

        showModal(my_id, empl_id, e_name, e_year, e_sem, e_stat){
            // alert('my_id: '+my_id+" "+empl_id);
            this.emp_name=e_name;
            this.emp_year=e_year;
            this.emp_sem=e_sem;
            this.emp_status=e_stat;
            this.emp_sem_id=my_id;
            axios.get("/ipcrtargets/get/ipcr/targets",{
                    params:{
                        sem_id: my_id,
                        empl_id: empl_id
                    }
            }).then((response)=>{
                this.ipcr_targets = response.data;
            }).catch((error) => {
                console.error(error);
            });
            this.displayModal = true;

        },

        hideModal() {
            this.displayModal = false;
        },
        submitAction(stat){
            //alert(stat);
            let text = "WARNING!\nAre you sure you want to delete the Research Agenda?";
            // alert("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete")
            if (confirm(text) == true) {
                this.$inertia.post("/review/approve/" + stat + "/"+ this.emp_sem_id);
            }
            this.hideModal();
        }
    }
};
</script>
<style>
            .row-centered {
                text-align:center;
            }
            .col-centered {
                display:inline-block;
                float:none;
                text-align:left;
                margin-right:-4px;
            }
            .pos{
                position: top;
                top: 240px;
            }
</style>
