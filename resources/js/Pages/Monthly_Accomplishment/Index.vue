<template>
    <Head>
        <title>Home</title>
    </Head>

    <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>Monthly Accomplishment - {{ month }} {{ Average_Point_Core }}</h3>
            <!-- {{ emp_code }}
            {{ data }} -->
            <div class="peers">
                <div class="peer mR-10">

                    <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search...">
                </div>
                <div class="peer">
                    <!-- <Link class="btn btn-primary btn-sm" :href="`/Daily_Accomplishment/create`">Add Daily Accomplishment</Link> -->
                    <!-- <button class="btn btn-primary btn-sm mL-2 text-white" @click="showFilter()">Filter</button> -->
                    <button class="btn btn-primary btn-sm mL-2 text-white" @click="printSubmit1">Print Part 1</button>
                    <button class="btn btn-primary btn-sm mL-2 text-white" @click="printSubmit">Print Part 2</button>
                </div>
                <div class="peer">
                    <button class="btn btn-primary btn-sm mL-2 text-white"
                        @click="submitAccomplishmentFOrThisMonth()">Submit</button>
                </div>
            </div>

            <Link :href="'/monthly-accomplishment'">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                <path fill-rule="evenodd"
                    d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
            </svg>
            </Link>
        </div>
        <filtering v-if="filter" @closeFilter="filter = false">
            Filter by MFO
            <select v-model="mfosel" class="form-control" @change="filterData()">
                <option></option>
                <option v-for="mfo in mfos" :value="mfo.id">
                    {{ mfo.mfo_desc }}
                </option>
            </select>
            <button class="btn btn-sm btn-danger mT-5 text-white" @click="clearFilter">Clear Filter</button>
        </filtering>
        <div class="masonry-sizer col-md-6"></div>
        <div class="masonry-item w-100">
            <div class="row gap-20"></div>
            <div class="bgc-white p-20 bd">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless table-striped table-hover">
                        <thead>
                            <tr style="background-color: #B7DEE8;" class="text-center">
                                <th rowspan="2" colspan="1">IPCR Code</th>
                                <th rowspan="2" colspan="1">Major Final Output</th>
                                <th rowspan="2" colspan="1">Success Indicator</th>
                                <th colspan="4">Rating</th>
                            </tr>
                            <tr style="background-color: #B7DEE8;" class="text-center">
                                <th>Quantity Rating</th>
                                <th>Quality Rating</th>
                                <th>Timeliness Rating</th>
                                <th>Average</th>
                            </tr>
                            <tr>

                            </tr>
                        </thead>
                        <tbody>
                            <!--CORE FUNCTION-->
                            <tr>
                                <!-- <td colspan="9">
                                        <b>CORE FUNCTION</b> -->
                                <td colspan="9">
                                    <b>CORE FUNCTION</b>
                                </td>
                            </tr>
                            <template v-for="dat in data.data">
                                <tr v-if="dat.ipcr_type === 'Core Function'"
                                    :class="{ opened: opened.includes(dat.idIPCR) }" @click="toggle(dat.idIPCR)"
                                    style="cursor: pointer" class="text-center">
                                    <td>{{ dat.idIPCR }}</td>
                                    <td>{{ dat.mfo_desc }}</td>
                                    <td>{{ dat.success_indicator }}</td>
                                    <td>{{ QuantityRate(dat.quantity_type, dat.TotalQuantity, dat.month)
                                    }}</td>
                                    <td>{{ QualityRate(dat.quality_error, dat.total_quality, dat.quality_average) }}</td>
                                    <td>{{ }}</td>
                                    <td>{{ AverageRate(dat.quantity_type, dat.quality_error, dat.TotalQuantity, dat.month,
                                        dat.quality_average, dat.ipcr_type) }}</td>
                                    <td></td>
                                </tr>
                                <tr v-if="opened.includes(dat.idIPCR) && dat.ipcr_type === 'Core Function'">
                                    <td colspan="7" class="background-white">
                                        <Transition name="bounce">
                                            <p v-if="show">
                                            <table class="table-responsive full-width">
                                                <tbody>
                                                    <tr>
                                                        <th></th>
                                                        <th class="text-white text-center "
                                                            style="background-color: #727272;" colspan="9">
                                                            <h6>&nbsp;&nbsp;Accomplishment</h6>
                                                        </th>
                                                        <th></th>
                                                    </tr>
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <th> </th>
                                                        <th> </th>
                                                        <th></th>
                                                        <th>
                                                            Target
                                                        </th>
                                                        <th>
                                                            Quantity
                                                        </th>
                                                        <th>
                                                            Percentage
                                                        </th>
                                                        <th> </th>
                                                        <th> </th>
                                                        <th>
                                                            Quality
                                                        </th>
                                                        <th>
                                                            Total Error/Average Feedback
                                                        </th>
                                                        <th>
                                                            Time Type
                                                        </th>

                                                        <th>
                                                            Prescribed Period
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ dat.quantity_type }}</td>
                                                        <td>{{ QuantityType(dat.quantity_type) }}</td>
                                                        <td>{{ dat.month }}</td>
                                                        <td>{{ dat.TotalQuantity }}</td>

                                                        <td>
                                                            {{
                                                                dat.month === "0"
                                                                ? ""
                                                                : (dat.TotalQuantity / dat.month * 100).toFixed(0) + "%"
                                                            }}
                                                        </td>
                                                        <td>{{ dat.quality_error }}</td>
                                                        <td>{{ QualityType(dat.quality_error) }}</td>
                                                        <td>{{ dat.total_quality }}</td>
                                                        <td>{{ dat.quality_average }}</td>
                                                        <td>{{ dat.time_based }}</td>

                                                    </tr>

                                                </tbody>
                                            </table>
                                            </p>
                                        </Transition>
                                    </td>
                                </tr>



                            </template>
                            <!-- //SUPPORT -->
                            <tr>
                                <td colspan="9">
                                    <b>Support FUNCTION </b>
                                </td>
                            </tr>
                            <template v-for="dat in data.data">
                                <tr v-if="dat.ipcr_type === 'Support Function'"
                                    :class="{ opened: opened.includes(dat.idIPCR) }" @click="toggle(dat.idIPCR)"
                                    style="cursor: pointer" class="text-center">
                                    <td>{{ dat.idIPCR }}</td>
                                    <td>{{ dat.mfo_desc }}</td>
                                    <td>{{ dat.success_indicator }}</td>
                                    <td>{{ QuantityRate(dat.quantity_type, dat.TotalQuantity, dat.month) }}</td>
                                    <td>{{ QualityRate(dat.quality_error, dat.total_quality, dat.quality_average) }}</td>
                                    <td>{{ }}</td>
                                    <td>{{ AverageRate(dat.quantity_type, dat.quality_error, dat.TotalQuantity, dat.month,
                                        dat.quality_average, dat.ipcr_type) }}</td>
                                    <td></td>
                                </tr>
                                <tr v-if="opened.includes(dat.idIPCR) && dat.ipcr_type === 'Support Function'">
                                    <td colspan="7" class="background-white">
                                        <Transition name="bounce">
                                            <p v-if="show">
                                            <table class="table-responsive full-width">
                                                <tbody>
                                                    <tr>
                                                        <th></th>
                                                        <th class="text-white text-center "
                                                            style="background-color: #727272;" colspan="9">
                                                            <h6>&nbsp;&nbsp;Accomplishment</h6>
                                                        </th>
                                                        <th></th>
                                                    </tr>
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <th></th>
                                                        <th> </th>
                                                        <th> </th>
                                                        <th>
                                                            Target
                                                        </th>
                                                        <th>
                                                            Quantity
                                                        </th>
                                                        <th>
                                                            Percentage
                                                        </th>
                                                        <th> </th>
                                                        <th> </th>
                                                        <th>
                                                            Quality
                                                        </th>
                                                        <th>
                                                            Total Error/Average Feedback
                                                        </th>
                                                        <!-- <td rowspan="2"></td>
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
                                                                style="background-color: #727272;">VIEW</th> -->
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ dat.quantity_type }}</td>
                                                        <td>{{ QuantityType(dat.quantity_type) }}</td>
                                                        <td>{{ dat.month }}</td>
                                                        <td>{{ dat.TotalQuantity }}</td>

                                                        <td>
                                                            {{
                                                                dat.month === "0"
                                                                ? ""
                                                                : (dat.TotalQuantity / dat.month * 100).toFixed(0) + "%"
                                                            }}
                                                        </td>
                                                        <td>{{ dat.quality_error }}</td>
                                                        <td>{{ QualityType(dat.quality_error) }}</td>
                                                        <td>{{ dat.total_quality }}</td>
                                                        <td>{{ dat.quality_average }}</td>

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
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <pagination :next="data.next_page_url" :prev="data.prev_page_url" />
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <p>
                            {{ data.from }} to {{ data.to }} of
                            {{ data.total }} entries
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <Modal v-if="displayModal" @close-modal-event="hideModal">
            <div class="d-flex justify-content-center">
                <iframe :src="my_link" style="width:100%; height:450px" />
            </div>
        </Modal>

        <Modal v-if="displayModal1" @close-modal-event="hideModal1">
            <div class="d-flex justify-content-center">
                <iframe :src="my_link" style="width:100%; height:450px" />
            </div>
        </Modal>
        Average_Point_Core {{ Average_Point_Core }}
    </div>
</template>
<script>
import Filtering from "@/Shared/Filter";
import FilterPrinting from "@/Shared/FilterPrint";
import Pagination from "@/Shared/Pagination";
import Modal from "@/Shared/PrintModal";
export default {
    props: {
        auth: Object,
        emp_code: Object,
        data: Object,
        month: Object,
        data: Object,
        month_data: Object,
        dept: Object,
        pgHead: Object,

    },
    data() {
        return {
            // search: this.$props.filters.search,
            // filter: false,
            filter_p: false,
            displayModal: false,
            displayModal1: false,
            my_link: "",
            opened: [],
            show: false,
            Average_Point_Core: 0,
            Average_Point_Support: 0,
            // mfosel: "",
        }
    },
    watch: {
        //     search: _.debounce(function (value) {
        //     this.$inertia.get(
        //         "/AddAccomplishment",
        //         { search: value },
        //         {
        //             preserveScroll: true,
        //             preserveState: true,
        //             replace: true,
        //         }
        //     );
        // }, 300),
    },
    components: {
        Pagination, Filtering, Modal, FilterPrinting
    },
    mounted() {
        this.calculateAverageCore()
    },
    methods: {
        showFilter() {
            //alert("show filter");
            this.filter = !this.filter
        },
        showFilterP() {
            // alert("show filter");
            this.filter_p = !this.filter_p
        },
        AverageScore() {

        },
        QuantityRate(id, quantity, target) {
            var result;
            if (id == 1) {
                var total = quantity / target * 100
                if (total >= 130) {
                    result = "5"
                } else if (total <= 129 && total >= 115) {
                    result = "4"
                } else if (total <= 114 && total >= 90) {
                    result = "3"
                } else if (total <= 89 && total >= 51) {
                    result = "2"
                } else if (total <= 50) {
                    result = "1"
                } else
                    result = ""
            } else if (id == 2) {
                if (total = 100) {
                    result = 5
                } else {
                    result = 2
                }
            }
            return result;
        },
        QualityRate(id, quality, total) {
            var result;
            if (id == 1) {
                if (total == 0) {
                    result = "5"
                } else if (total >= .01 && total <= 2.99) {
                    result = "4"
                } else if (total >= 3 && total <= 4.99) {
                    result = "3"
                } else if (total >= 5 && total <= 6.99) {
                    result = "2"
                } else if (total >= 7) {
                    result = "1"
                }
            } else if (id == 2) {
                if (total == 5) {
                    result = "5"
                } else if (total >= 4 && total <= 4.99) {
                    result = "4"
                } else if (total >= 3 && total <= 3.99) {
                    result = "3"
                } else if (total >= 2 && total <= 2.99) {
                    result = "2"
                } else if (total >= 1 && total <= 1.99) {
                    result = "1"
                } else {
                    result = "0"
                }
            }
            return result;
        },
        QuantityType(id) {
            var result;
            if (id == 1) {
                result = "TO BE RATED"
            } else {
                result = "ACCURACY RULE (100%=5,2 if less than 100%)"
            }
            return result;
        },
        QualityType(id) {
            var result;
            if (id == 1) {
                result = "NO. OF ERROR"
            } else if (id == 2) {
                result = "AVE. FEEDBACK"
            } else if (id == 3) {
                result = "NOT TO BE RATED"
            } else if (id == 4) {
                result = "ACCURACY RULE"
            }
            return result;
        },
        AverageRate(QuantityID, QualityID, quantity, target, total, quality, type) {


            var Quantity = this.QuantityRate(QuantityID, quantity, target)
            var Quality = this.QualityRate(QualityID, quality, total)
            var Timeliness = 0
            var Average = (parseFloat(Quantity) + parseFloat(Quality) + parseFloat(Timeliness)) / 3


            // if (type == "Core Function"){
            //     this.Average_Point_Core = this.Average_Point_Core + Average
            // } else {
            //     this.Average_Point_Support = this.Average_Point_Support + Average
            // }



            return this.format_number_conv(Average, 2, true)
            // return this.format_number_conv
        },
        calculateAverageCore() {
            // AverageRate(dat.quantity_type, dat.quality_error, dat.TotalQuantity, dat.month,
            //     dat.quality_average, dat.ipcr_type)
            let sum = 0;
            let num_of_data = 0;
            let average = 0;
            if (Array.isArray(this.data.data)) {
                this.data.data.forEach(item => {
                    if (item.ipcr_type === 'Core Function') {
                        var val = this.AverageRate(item.quantity_type, item.quality_error, item.TotalQuantity, item.month,
                            item.quality_average, item.ipcr_type);
                        // alert(val);
                        num_of_data += 1;
                        sum += parseFloat(val);
                        average = sum / num_of_data
                    }
                });
            }
            this.Average_Point_Core = average;
        },
        calculateAverageSupport() {

            let sum = 0;
            let num_of_data = 0;
            let average = 0;
            if (Array.isArray(this.data.data)) {
                this.data.data.forEach(item => {
                    if (item.ipcr_type === 'Support Function') {
                        var val = this.AverageRate(item.quantity_type, item.quality_error, item.TotalQuantity, item.month,
                            item.quality_average, item.ipcr_type);
                        // alert(val);
                        num_of_data += 1;
                        sum += parseFloat(val);
                        average = sum / num_of_data
                    }
                });
            }
            this.Average_Point_Support = average;
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
            )
        },
        deleteOutput(id) {
            let text = "WARNING!\nAre you sure you want to delete this Accomplishment?" + id;
            if (confirm(text) == true) {
                this.$inertia.delete("/Daily_Accomplishment/" + id);
            }
        },
        getAccomplishment(tar_id) {
            this.$inertia.get(
                "/accomplishments",
                {
                    idtarget: tar_id
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
        },
        getPercent(accomp, targqty) {
            var accSum = 0;
            accomp.forEach(myFunction);
            function myFunction(item) {
                accSum += parseFloat(item.accomplishment_qty)
            }
            var percentt = (accSum / targqty) * 100
            percentt = this.format_number(percentt, 2, true)
            return percentt;
        },
        printSubmit1() {
            alert(this.Average_Point_Core);
            //var office_ind = document.getElementById("selectOffice").selectedIndex;

            // this.office =this.auth.user.office.office;
            // var pg_head = this.functions.DEPTHEAD;
            // var forFFUNCCOD = this.auth.user.office.department_code;
            this.my_link = this.viewlink1(this.emp_code, this.auth.user.name.first_name + " " + this.auth.user.name.last_name, this.auth.user.name.employment_type_descr, this.auth.user.name.position_long_title, this.dept.office, " ", this.month_data.imm.first_name + " " + this.month_data.imm.last_name, this.month_data.next.first_name + " " + this.month_data.next.last_name, this.month_data.sem, this.month_data.year, this.month_data.id, this.month, this.pgHead, this.Average_Point_Core);

            this.showModal1();
        },
        viewlink1(emp_code, employee_name, emp_status, position, office, division, immediate, next_higher, sem, year, idsemestral, period, pghead, Average_Score) {


            //var linkt ="abcdefghijklo534gdmoivndfigudfhgdyfugdhfugidhfuigdhfiugmccxcxcxzczczxczxczxcxzc5fghjkliuhghghghaaa555l&&&&-";
            var linkt = "http://";
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA%2CSales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2FIPCR%2FIPCR_Part1&reportUnit=%2Freports%2FIPCR%2FIPCR_Part1%2FAccomplishment_Part1&standAlone=true&decorate=no&output=pdf';
            var params = '&emp_code=' + emp_code + '&employee_name=' + employee_name + '&emp_status=' + emp_status + '&position=' + position + '&office=' + office + '&division=' + division + '&immediate=' + immediate + '&next_higher=' + next_higher + '&sem=' + sem + '&year=' + year + '&idsemestral=' + idsemestral + '&period=' + period + '&pghead=' + pghead + '&Average_Point_Core=' + this.Average_Point_Core + '&Average_Point_Support=' + this.Average_Point_Support;
            var linkl = linkt + jasper_ip + jasper_link + params;

            return linkl;
        },
        showModal1() {
            this.displayModal = true;
        },
        hideModal1() {
            this.displayModal = false;
        },
        printSubmit() {

            //var office_ind = document.getElementById("selectOffice").selectedIndex;

            // this.office =this.auth.user.office.office;
            // var pg_head = this.functions.DEPTHEAD;
            // var forFFUNCCOD = this.auth.user.office.department_code;
            this.my_link = this.viewlink(this.emp_code, this.auth.user.name.first_name + " " + this.auth.user.name.last_name, this.auth.user.name.employment_type_descr, this.auth.user.name.position_long_title, this.dept.office, null, this.month_data.imm.first_name + " " + this.month_data.imm.last_name, null, this.month_data.sem, this.month_data.year, this.month_data.id, this.month);

            this.showModal();
        },

        viewlink(emp_code, employee_name, emp_status, position, office, division, immediate, next_higher, sem, year, idsemestral, period,) {


            //var linkt ="abcdefghijklo534gdmoivndfigudfhgdyfugdhfugidhfuigdhfiugmccxcxcxzczczxczxczxcxzc5fghjkliuhghghghaaa555l&&&&-";
            var linkt = "http://";
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA%2CSales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2FIPCR%2FIPCR_Monthly&reportUnit=%2Freports%2FIPCR%2FIPCR_Monthly%2FMonthly_IPCR&standAlone=true&decorate=no&output=pdf';
            var params = '&emp_code=' + emp_code + '&employee_name=' + employee_name + '&emp_status=' + emp_status + '&position=' + position + '&office=' + office + '&division=' + division + '&immediate=' + immediate + '&next_higher=' + next_higher + '&sem=' + sem + '&year=' + year + '&idsemestral=' + idsemestral + '&period=' + period + '&Score=' + this.score;
            var linkl = linkt + jasper_ip + jasper_link + params;

            return linkl;
        },
        showModal() {
            this.displayModal = true;
        },
        hideModal() {
            this.displayModal = false;
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
        async filterData() {
            //alert(this.mfosel);

            this.$inertia.get(
                "/AddAccomplishment",
                {
                    mfosel: this.mfosel
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
        },
        clearFilter() {

            this.mfosel = "";
            this.search = "";
            this.filterData();
        },
        submitAccomplishmentFOrThisMonth() {
            alert("submitAccomplishmentFOrThisMonth");
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

