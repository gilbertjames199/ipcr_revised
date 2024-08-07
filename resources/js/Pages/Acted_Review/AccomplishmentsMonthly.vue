<template>

    <Head>
        <title>Home</title>
    </Head>

    <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <!--SEMESTRAL***************************************************************************************-->
            <h3>Acted Monthly Accomplishments</h3>
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
                                <!-- <th>Activities</th> -->
                                <th>Period</th>
                                <th>Remarks</th>
                                <th>Date Acted</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="dat in data.data">
                                <!-- :style="{ backgroundColor: getRowColorActedTargets(dat.type) }" -->
                                <tr :style="{ backgroundColor: getRowColorActed(dat.type) }">
                                    <td></td>
                                    <td>{{ dat.employee_name }}</td>
                                    <td>
                                        <div v-if="dat.ipcr_monthly_accomplishment_id !== null">
                                            <!-- dat.month: {{ dat.month }} -- -->
                                            {{ getMonthName(dat.month) }}, {{ dat.year }}
                                        </div>
                                        <div v-if="dat.ipcr_monthly_accomplishment_id == null">
                                            {{ getPeriod(dat.sem, dat.year) }}
                                        </div>

                                    </td>
                                    <td>
                                        <!-- {{ dat.remarks }} -->
                                        <span v-if="dat.remarks">{{ truncatedDescriptionSpecificLength(dat.remarks, 5)
                                            }}</span>
                                        <!--  -->
                                    </td>
                                    <td>{{ formatDateTimeDTS(dat.date_acted) }}</td>
                                    <td>{{ getActivityType(dat.type) }}</td>
                                    <td>
                                        <div class="dropdown dropstart">
                                            <button class="btn btn-secondary btn-sm action-btn" type="button"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                    <path
                                                        d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu action-dropdown"
                                                aria-labelledby="dropdownMenuButton1">

                                                <!-- <button class="dropdown-item"
                                                    @click="showModal(target.id, target.empl_id, target.employee_name, target.year, target.sem, target.status)">
                                                    View Submission
                                                </button> -->
                                                <li>
                                                    <button class="dropdown-item" @click="showModal(dat.ipcr_semestral_id,
                        dat.empl_id,
                        dat.employee_name,
                        dat.year,
                        dat.sem,
                        dat.a_status,
                        dat.accomp_id,
                        dat.month,
                        dat.position,
                        dat.office,
                        dat.division,
                        dat.immediate,
                        dat.next_higher,
                        dat.id,
                        dat.employment_type_descr,
                        dat.type
                    )">
                                                        View Submission
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item"
                                                        @click="viewDailyAccomplishments(dat.empl_id, dat.month, dat.year)">
                                                        View Daily Accomplishments
                                                    </button>
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
            <div class="justify-content-center">
                <!-- {{ report_link }} -->
                <div style="text-align: center">
                    <h4>IPCR Accomplishment</h4>
                </div>
                <br>
                <div><b>Employee Name: </b><u>{{ emp_name }}</u></div>
                <div>
                    <b>Semester/Period: </b>
                    <!-- {{ ret_type }} -->
                    <u>
                        <span v-if="emp_sem === '1'">First Semester -January to June, </span>
                        <span v-if="emp_sem === '2'">Second Semester -July to December, </span>
                        {{ emp_year }}
                    </u>
                </div>
                <div>
                    <b>Status: </b>
                    <u>
                        <span v-if="emp_status === '0'">Submitted</span>
                        <span v-if="emp_status === '1'">Reviewed</span>
                    </u>
                </div>
                <div class="masonry-item w-100">
                    <div class="bgc-white p-20 bd">
                        <!-- {{ report_link }} -->
                        <div class="table-responsive">
                            <iframe :src="report_link" style="width:100%; height:450px" />
                        </div>
                    </div>
                </div>
                <div>
                    <b>Remarks:</b>
                    <input type="text" v-model="form.remarks" class="form-control" autocomplete="chrome-off"><br>
                </div>
                <div style="align: center">
                    <button class="btn btn-primary text-white" @click="submitAction('1')" v-if="emp_status === '0'">
                        Review
                    </button>
                    <button class="btn btn-primary text-white" @click="submitAction('2')" v-if="emp_status === '1'">
                        Approve
                    </button>&nbsp;
                    <button class="btn btn-primary text-white" @click="submitAction('3')" v-if="emp_status === '2'">
                        Final Approve
                    </button>&nbsp;

                    <button class="btn btn-danger text-white" @click="submitAction('-2')"
                        v-if="ret_type != 'return accomplishment' && ret_type != 'review semestral accomplishment'">
                        Return
                    </button>
                </div>
            </div>
        </Modal>
        <ModalDaily v-if="displayModalDaily" @close-modal-event="hideModalDaily">
            <div class="d-flex justify-content-center">
                <iframe :src="my_link" style="width:100%; height:450px" />
            </div>
        </ModalDaily>
        <!-- {{ data }} -->
    </div>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";
import Filtering from "@/Shared/Filter";
import Pagination from "@/Shared/Pagination";
import Modal from "@/Shared/PrintModal";
import Modal2 from "@/Shared/PrintModal";
import Modal3 from "@/Shared/PrintModal";
import ModalDaily from "@/Shared/PrintModal";

export default {
    props: {
        data: Object,
        targets: Object,
        filters: Object,
    },
    computed: {
        quantityArray() {
            // Parse the quantity values as arrays
            const allArrays = this.ipcr_targets.map(target => JSON.parse(target.quantity));
            const mergedArray = [].concat(...allArrays);
            var quant = JSON.parse(this.ipcr_targets[0].quantity)
            // const cleanedString = this.ipcr_targets[0].quantity.replace(/[\[\]]/g, '');
            // const numberArray = cleanedString.split(',').map(Number);
            // this.length = this.ipcr_targets[0].length
            // return Array.from(new Set(mergedArray));
            return mergedArray
        },
    },
    data() {
        return {
            my_link: "",
            displayModal: false,
            modal_title: "Add",
            ipcr_targets: [],
            emp_sem_id: "",
            emp_name: "",
            emp_year: "",
            emp_sem: "",
            emp_status: "",
            empl_id: "",
            displayModal2: false,
            displayModal3: false,
            displayModalDaily: false,
            length: 0,
            ret_type: "",
            form: useForm({
                type: "",
                remarks: "",
                ipcr_semestral_id: "",
                employee_code: ""
            }),
            search: this.$props.filters.search,
            //search: this.$props.filters.search,
        }
    },
    watch: {
        search: _.debounce(function (value) {
            this.$inertia.get(
                "/acted/particulars/accomp/lishments/monthly",
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
        Pagination, Filtering, Modal, Modal2, Modal3, ModalDaily
    },

    methods: {
        deleteIPCR(ipcr_id) {
            // let text = "WARNING!\nAre you sure you want to delete the Research Agenda?";
            // // alert("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete")
            // if (confirm(text) == true) {
            //     this.$inertia.delete("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete");
            // }
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
        deletePAPS(id) {
            // let text = "WARNING!\nAre you sure you want to delete the Program and Projects? "+id;
            //   if (confirm(text) == true) {
            //     this.$inertia.delete("/paps/" + id+"/"+this.idmfo);
            // }
        },
        getToRep(ffunccod, ffunction, MOOE, PS) {
            // alert(data[0].FFUNCCOD);
            // var linkt="http://";
            // var jasper_ip = this.jasper_ip;
            // var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA,Sales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2Fplanning_system%2FOPCR_Standard&reportUnit=%2Freports%2Fplanning_system%2FOPCR_Standard%2FOPCR&standAlone=true&decorate=no&output=pdf';
            // var params = '&id=' + ffunccod + '&FUNCTION=' + ffunction + '&MOOE=' + MOOE + '&PS=' + PS;
            // var link1 = linkt + jasper_ip +jasper_link + params;
            // return link1;
        },
        async showModal(my_id, empl_id, e_name, e_year, e_sem, e_stat, accomp_id, month, position, office, division, immediate, next_higher, idsemestral, employment_type_descr, type) {
            this.ret_type = type;
            this.emp_name = e_name;
            this.emp_year = e_year;
            this.emp_sem = e_sem;
            this.emp_status = e_stat;
            this.employment_type_descr = employment_type_descr;
            this.emp_sem_id = my_id;
            this.empl_id = empl_id;
            this.id_accomp_selected = accomp_id;
            this.form.ipcr_monthly_accomplishment_id = accomp_id;
            let my_month = this.getMonthName(month)
            this.form.employee_code = empl_id;
            let url = '/calculate-total/accomplishments/monthly/' + my_month + '/' + e_year + '/' + empl_id;
            // alert(url);
            // alert(empl_id);
            await axios.get(url).then((response) => {
                this.core_support = response.data;
                // console.log(this.core_support.ave_core);
            });

            var per = this.getMonthName(month)

            this.viewlink1(empl_id, e_name, e_stat, position, office, division, immediate, next_higher, e_sem, e_year, idsemestral, per, this.pghead, '33')
            this.displayModal = true;
        },
        viewlink1(emp_code, employee_name, emp_status, position, office, division, immediate, next_higher, sem, year, idsemestral, period, pghead, Average_Score) {

            var linkt = "http://";
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA%2CSales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2FIPCR%2FIPCR_Part1&reportUnit=%2Freports%2FIPCR%2FIPCR_Part1%2FAccomplishment_Part1&standAlone=true&decorate=no&output=pdf';
            var params = '&emp_code=' + emp_code + '&employee_name=' + employee_name + '&emp_status=' + this.employment_type_descr + '&position=' + position +
                '&office=' + office + '&division=' + division + '&immediate=' + immediate +
                '&next_higher=' + next_higher + '&sem=' + sem + '&year=' + year +
                '&idsemestral=' + idsemestral + '&period=' + period + '&pghead=' + pghead +
                '&Average_Point_Core=' + this.core_support.ave_core +
                '&Average_Point_Support=' + this.core_support.ave_support;
            var linkl = linkt + jasper_ip + jasper_link + params;
            this.report_link = linkl;
            return linkl;
        },
        // showModal(my_id, empl_id, e_name, e_year, e_sem, e_stat) {
        //     // alert('my_id: '+my_id+" "+empl_id);
        //     this.emp_name = e_name;
        //     this.emp_year = e_year;
        //     this.emp_sem = e_sem;
        //     this.emp_status = e_stat;
        //     this.emp_sem_id = my_id;
        //     this.empl_id = empl_id;
        //     axios.get("/ipcrtargets/get/ipcr/targets", {
        //         params: {
        //             sem_id: my_id,
        //             empl_id: empl_id
        //         }
        //     }).then((response) => {
        //         this.ipcr_targets = response.data;
        //     }).catch((error) => {
        //         console.error(error);
        //     });
        //     this.displayModal = true;
        // },
        hideModal() {
            this.displayModal = false;
        },
        hideModal2() {
            this.displayModal2 = false;
        },
        showModalDaily() {
            this.displayModalDaily = true;
        },
        hideModalDaily() {
            this.displayModalDaily = false;
        },
        // submitAction(stat) {
        //     //alert(stat);
        //     var acc = "";
        //     if (stat < 1) {
        //         acc = "return";
        //         this.form.type = "return target";
        //     } else if (stat < 2) {
        //         acc = "review";
        //         this.form.type = "review target";
        //     } else if (stat < 3) {
        //         acc = "approve";
        //         this.form.type = "approve target";
        //     }
        //     let text = "Are you sure you want to " + acc + " the IPCR Target?";
        //     this.form.ipcr_semestral_id = this.emp_sem_id
        //     this.form.employee_code = this.empl_id
        //     // alert("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete")
        //     if (confirm(text) == true) {
        //         this.$inertia.post("/review/approve/" + stat + "/" + this.emp_sem_id, this.form);
        //     }
        //     this.hideModal();
        // },
        submitAction(stat) {
            // alert(stat);
            var acc = "";
            if (stat < 0) {
                acc = "return";
            } else if (stat < 2) {
                acc = "review";
            } else if (stat < 3) {
                acc = "approve";
            } else {
                acc = "final approve";
            }
            let text = "Are you sure you want to " + acc + " the IPCR Target?";
            // alert(this.id_accomp_selected)
            // alert("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete")/review/approve/
            if (confirm(text) == true) {
                var myurl = "/approve/accomplishments/" + stat + "/" + this.id_accomp_selected + "/acted/monthly"
                // await axios
                this.$inertia.post(myurl, {
                    params: {
                        remarks: this.form.remarks,
                        employee_code: this.form.employee_code,
                        core_support: this.core_support
                    }
                });
            }
            this.hideModal();
        },
        async showModal2(my_id, empl_id, e_name, e_year, e_sem, e_stat) {
            this.emp_name = e_name;
            this.emp_year = e_year;
            this.emp_sem = e_sem;
            this.emp_status = e_stat;
            this.emp_sem_id = my_id;
            this.empl_id = empl_id;
            // alert('ipcr_sem: '+my_id+' emp_code: '+empl_id)
            await axios.get("/ipcrtargets/get/ipcr/targets/2", {
                params: {
                    sem_id: my_id,
                    empl_id: empl_id
                }
            }).then((response) => {
                this.ipcr_targets = response.data;
            }).catch((error) => {
                console.error(error);
            });
            this.displayModal2 = true;
        },
        parseQuantity(quantarr) {
            // Remove brackets and split by commas, then convert to numbers
            const cleanedString = quantarr.replace(/[\[\]]/g, '');
            const numberArray = cleanedString.split(',').map(Number);
            //this.length = numberArray[0].quantity.length
            return numberArray;
        },
        submitActionProb(stat) {
            //alert(stat);
            var acc = "";
            if (stat < 2) {
                acc = "review";
            } else {
                acc = "approve";
            }
            let text = "Are you sure you want to " + acc + " the IPCR Target?";
            // alert("/ipcrtargets/" + ipcr_id + "/"+ this.id+"/delete")
            if (confirm(text) == true) {
                this.$inertia.post("/review/approve/" + stat + "/" + this.emp_sem_id + "/probationary");
            }
            this.hideModal2();
        },
        showModal3() {
            // alert("empl_id: " + this.empl_id + " id: " + this.emp_sem_id + " e_sem: " + this.emp_sem);
            //if(this.sem==="1" || this.e)
            //this.form.type
            //this.form.remarks
            if (this.emp_sem === "1" || this.emp_sem === "2") {
                this.form.type = "ipcr_semestrals";
            } else {
                this.form.type = "probationary/temporary"
            }
            this.form.ipcr_semestral_id = this.emp_sem_id
            this.form.employee_code = this.empl_id
            this.hideModal2()
            this.hideModal()
            // alert("ipcr_semestral_id: " + this.form.ipcr_semestral_id +
            //     " ipcr_semestral_id: " + this.form.ipcr_semestral_id +
            //     " ipcr_semestral_id: " + this.form.ipcr_semestral_id)
            this.displayModal3 = true
        },
        hideModal3() {
            this.displayModal3 = false;
        },
        submitReturnReason() {
            // alert("Type: " + this.form.type + "; ipcr_semestral_id: " +
            //     this.form.ipcr_semestral_id + "; employee_code: " +
            //     this.form.employee_code + "; remarks: " +
            //     this.form.remarks)
            let text = "Are you sure you want to return this IPCR?";

            if (confirm(text) == true) {
                if (this.form.remarks) {
                    //this.$inertia.post("/return/remarks" + id+"/"+this.idmfo);
                    this.form.post("/return/remarks", this.form);
                } else {
                    alert("Input remarks!")
                }
            }
            this.hideModal()
            this.hideModal2()
            this.cancelReason()

        },
        cancelReason() {
            this.hideModal3()
            this.form.remarks = "";
            this.form.type = "";
            this.form.ipcr_semestral_id = "";
            this.form.employee_code = "";
        },
        reviewAdditionalTarget(id_target, target_status) {
            // alert(target_status);
            var act = "";
            if (target_status == 0) {
                act = "review";
            } else if (target_status == 1) {
                act = "approve";
            } else {
                act = "return";
            }
            // alert(act);
            let text = "WARNING!\nAre you sure you want to " + act + " this IPCR?";
            if (confirm(text) == true) {
                this.$inertia.post("/ipcrtargetsreview/targetid/" + id_target + '/status/' + target_status);
            }
        },
        viewDailyAccomplishments(emp_code, mo_val, yval) {
            // alert(this.emp_code);
            //var office_ind = document.getElementById("selectOffice").selectedIndex;

            // this.office =this.auth.user.office.office;
            // var pg_head = this.functions.DEPTHEAD;
            // var forFFUNCCOD = this.auth.user.office.department_code;
            this.my_link = this.viewlink(emp_code, mo_val, yval);

            this.showModalDaily();
        },
        viewlink(username, mo_val, yval) {
            //var linkt ="abcdefghijklo534gdmoivndfigudfhgdyfugdhfugidhfuigdhfiugmccxcxcxzczczxczxczxcxzc5fghjkliuhghghghaaa555l&&&&-";
            // var date_from =
            // alert(yval);
            var linkt = "http://";
            var date_from = new Date(yval, mo_val - 1, 1).toISOString().split('T')[0];
            var dateObj = new Date(date_from);
            dateObj.setDate(dateObj.getDate() + 1);
            var nextDay = dateObj.toISOString().split('T')[0];

            var date_to = new Date(yval, mo_val, 0).toISOString().split('T')[0];
            var jasper_ip = this.jasper_ip;

            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA%2CSales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2FIPCR%2FDaily_Accomplishment&reportUnit=%2Freports%2FIPCR%2FDaily_Accomplishment%2FIPCR_Daily&standAlone=true&decorate=no&output=pdf';
            var params = '&username=' + username + '&date_from=' + nextDay + '&date_to=' + date_to;
            var linkl = linkt + jasper_ip + jasper_link + params;

            return linkl;
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
