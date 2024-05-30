<template>

    <Head>
        <title>Home</title>
    </Head>

    <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>IPCR Tracking</h3>
            <!-- {{ emp_code }}
            {{ data }} -->
            <!-- {{ ipcr_codes }} -->
            <div class="peers">
                <!-- <div class="peer mR-10">

                    <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search...">
                </div> -->

            </div>
        </div>
        <filtering v-if="filter" @closeFilter="filter = false" @change="filterData()">
            Filter by Date From
            <input type="date" v-model="date_from" class="form-control" />
            Filter by Date To
            <input type="date" v-model="date_to" class="form-control" />
            Search IPCR Code
            <input v-model="ipcr_code_filter" type="text" class="form-control form-control-sm" placeholder="Search...">
            <button class="btn btn-sm btn-danger mT-5 text-white" @click="clearFilter">Clear Filter</button>
        </filtering>

        <filtering v-if="filter_month" @closeFilter="filter = false" @change="filterData()">
            Filter By IPCR Code
            <input type="text" class="form-control" />
            Filter By Month
            <select v-model="month_filter" class="form-control">
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
            Filter By year
            <input class="form-control" v-model="year_filter" />
            <button class="btn btn-sm btn-danger mT-5 text-white" @click="clearFilter">Clear Filter</button>
        </filtering>
        <FilterPrinting v-if="filter_p" @closeFilter="filter_p = false">
            Date From
            <input type="date" v-model="date_from" class="form-control" />
            Date To
            <input type="date" v-model="date_to" class="form-control" />
            <button class="btn btn-sm btn-primary mT-5 text-white" @click="printSubmit">Print Report</button>
        </FilterPrinting>
        <FilterPrinting v-if="filter_sync" @closeFilter="filter_sync = false">
            Date From
            <input type="date" v-model="date_from" class="form-control" />
            Date To
            <input type="date" v-model="date_to" class="form-control" />
            <button class="btn btn-sm btn-primary mT-5 text-white" @click="filterSyncing()">Sync Daily</button>
        </FilterPrinting>


        <div class="masonry-sizer col-md-6"></div>
        <div class="masonry-item w-100">
            <div class="row gap-20"></div>
            <div class="bgc-white p-20 bd">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless table-striped table-hover">
                        <thead>
                            <tr style="background-color: #B7DEE8;">
                                <th style="width: 15%;">Date</th>
                                <th style="width: 10%;">Semester</th>
                                <th style="width: 5%;">Month</th>
                                <th style="width: 15%;">Description</th>
                                <th style="width: 30%;">Remarks</th>
                                <th style="width: 15%;">Acted by</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="dat in data">
                                <td>{{ dat.formatted_created_at }}</td>
                                <td>{{ setSem(dat.sem) + " " +dat.year }}</td>
                                <td>{{ getMonthName(dat.month) == "Invalid Month"? "": getMonthName(dat.month) }}</td>
                                <td>{{ dat.type }}</td>
                                <td>{{ dat.remarks }}</td>
                                <td>{{ dat.employee_name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <!-- <Pagination_Preserved :links="data.links" /> -->
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
    </div>
</template>
<script>
import Filtering from "@/Shared/Filter";
import FilterPrinting from "@/Shared/FilterPrint";
import Pagination from "@/Shared/Pagination";
import Pagination_Preserved from "@/Shared/Pagination_Preserved";
import Modal from "@/Shared/PrintModal";
export default {
    props: {
        auth: Object,
        emp_code: Object,
        // mfos: Object,
        data: Object,
        ipcr_codes: Object,
        // paps: Object,
        // idpaps: String,
        // functions: Object,
        // filters: Object,
    },
    data() {
        return {
            // search: this.$props.filters.search,
            filter: false,
            filter_p: false,
            filter_sync: false,
            filter_month: false,
            date_from: "",
            date_to: "",
            month_filter: "",
            year_filter: "",
            ipcr_code_filter: "",
            displayModal: false,
            my_link: "",
            date: "",
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
        ipcr_code_filter: _.debounce(function (value) {
            this.$inertia.get(
                "/Daily_Accomplishment/",
                {
                    date_from: this.date_from,
                    date_to: this.date_to,
                    date: this.date,
                    month: this.month_filter,
                    year: this.year_filter,
                    ipcr_code: value
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
        }, 300),

    },
    components: {
        Pagination, Filtering, Modal, FilterPrinting, paginationPreserved: Pagination_Preserved
    },
    mounted() {
        this.setYear();
    },
    methods: {

        setSem(sem){
            var semester = "";
            if(sem == 1){
            semester = "January to June"
            } else {
            semester = "July to December"
            }

            return semester;
        },
        setYear() {
            var yr = new Date().getFullYear();
            this.year_filter = yr;
        },
        showFilter() {

            this.filter = !this.filter
        },
        showFilterP() {
            // alert("show filter");
            this.filter_p = !this.filter_p
        },

        showFilterSync() {
            // alert("show filter");
            this.filter_sync = !this.filter_sync
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
        printSubmit() {
            // alert(this.emp_code);
            //var office_ind = document.getElementById("selectOffice").selectedIndex;

            // this.office =this.auth.user.office.office;
            // var pg_head = this.functions.DEPTHEAD;
            // var forFFUNCCOD = this.auth.user.office.department_code;
            this.my_link = this.viewlink(this.emp_code, this.date_from, this.date_to);

            this.showModal();
        },

        viewlink(username, date_from, date_to) {
            //var linkt ="abcdefghijklo534gdmoivndfigudfhgdyfugdhfugidhfuigdhfiugmccxcxcxzczczxczxczxcxzc5fghjkliuhghghghaaa555l&&&&-";
            var linkt = "http://";
            var jasper_ip = this.jasper_ip;
            var jasper_link = 'jasperserver/flow.html?pp=u%3DJamshasadid%7Cr%3DManager%7Co%3DEMEA%2CSales%7Cpa1%3DSweden&_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2Freports%2FIPCR%2FDaily_Accomplishment&reportUnit=%2Freports%2FIPCR%2FDaily_Accomplishment%2FIPCR_Daily&standAlone=true&decorate=no&output=pdf';
            var params = '&username=' + username + '&date_from=' + date_from + '&date_to=' + date_to;
            var linkl = linkt + jasper_ip + jasper_link + params;

            return linkl;
        },
        showModal() {
            this.displayModal = true;
        },
        hideModal() {
            this.displayModal = false;
        },
        async filterData() {

            this.$inertia.get(
                "/Daily_Accomplishment/",
                {
                    date_from: this.date_from,
                    date_to: this.date_to,
                    date: this.date,
                    month: this.month_filter,
                    year: this.year_filter,
                    ipcr_code: this.ipcr_code_filter
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
        },
        clearFilter() {
            this.date = "";
            this.search = "";
            this.month_filter = "";
            this.year_filter = "";
            this.ipcr_code_filter = "";
            this.date_to = "";
            this.date_from = "";
            this.filterData();
        },

        async filterSyncing() {
            this.$inertia.get(
                "/Daily_Accomplishment/sync_daily/PM",
                {
                    date_from: this.date_from,
                    date_to: this.date_to,
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
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
