<template>

    <Head>
        <title>Home</title>
    </Head>

    <!--<p style="text-align: justify;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur.
    </p>-->
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>Password Reset Log</h3>
            <div class="peers">
                <div class="peer mR-10">
                    <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search...">
                </div>

                <button class="btn btn-primary btn-sm mL-2 text-white" @click="showFilter()">Filter</button>
            </div>

        </div>
        <filtering v-if="filter" @closeFilter="filter = false">
            <!-- <label>Sample Inputs</label>
            <input type="text" class="form-control">
            <button class="btn btn-sm btn-primary mT-5 text-white" @click="">Filter</button> -->
            <!-- <div class="peer">
                <input type="checkbox" v-model="typeChecked" @change="filterByType"> Filter by Type
            </div> -->
            Filter by type
            <select v-model="type" class="form-select" @change="filterData">
                <option value="reset">Password reset request
                </option>
                <option value="changed">Changed by employee</option>
            </select>
            Date from
            <input v-model="date_from" type="date" class="form-control" @change="filterData" />
            Date to
            <input v-model="date_to" type="date" class="form-control" @change="filterData" />
            <br>
            <button class="btn btn-danger btn-sm mL-2 text-white" @click="clearFilters()">Clear Filters</button>
        </filtering>
        <div class="masonry-sizer col-md-6"></div>
        <div class="masonry-item w-100">
            <div class="row gap-20"></div>
            <div class="bgc-white p-20 bd">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless table-striped table-hover">
                        <thead>
                            <tr class="bg-secondary text-white">
                                <th>Employee Name</th>
                                <th>Changed/Reset by</th>
                                <th>Requested by</th>
                                <th>Date Acted</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr v-for="dat in data.data">
                                <td>{{ dat.emp }}</td>
                                <td>{{ dat.acted_by }}</td>
                                <td>{{ dat.requested_by }}</td>
                                <td>{{ formatMonthDayYear(formatDate(dat.created_at)) }} </td>
                                <td>
                                    <span v-if="dat.emp_cats == dat.acted_cats">Changed by employee</span>
                                    <span v-else>Password reset request</span>
                                </td>
                                <!-- <td>{{ dat.possible_risk }}</td>
                                <td>{{ dat.person_affected }}</td>
                                <td>{{ dat.management }}</td> -->
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
                                                <!-- <Link class="dropdown-item" :href="`/RiskManagement/${dat.id}/edit`"> -->
                                                <!-- Edit</Link> -->
                                            </li>
                                            <li>
                                                <!-- <Link class="text-danger dropdown-item"
                                                    @click="deleteRiskManagement(dat.id)">Delete</Link> -->
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
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

    </div>
</template>
<script>
import Filtering from "@/Shared/Filter";
import Pagination from "@/Shared/Pagination";
export default {
    props: {
        data: Object,
        revs: Object,
        revid: String
    },
    data() {
        return {
            filter: false,
            date_from: "",
            date_to: "",
            type: "",
        }
    },
    components: {
        Pagination, Filtering,
    },

    methods: {

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
        deleteRiskManagement(id) {
            let text = "WARNING!\nAre you sure you want to delete the Risk Management?" + id;
            if (confirm(text) == true) {
                this.$inertia.delete("/RiskManagement/" + id);
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
        formatDate(dattt) {
            // let dateStr = '2024-06-06T00:57:45.000000Z';

            // Parse the date string into a Date object
            let date = new Date(dattt);

            // Get the date part in 'YYYY-MM-DD' format
            return date.toISOString().split('T')[0];
        },
        showFilter() {
            this.filter = !this.filter;
        },
        filterByType() {
            alert('alerta')
        },
        async filterData() {

            this.$inertia.get(
                "/password/change/log",
                {
                    date_from: this.date_from,
                    date_to: this.date_to,
                    type: this.type,
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
        },
        clearFilters() {
            this.date_from = "";
            this.date_to = "";
            this.type = "";
            this.filterData();
        },
        timePlusTwo(my_val) {
            const originalDate = new Date(my_val);
            originalDate.setHours(originalDate.getHours() + 2);
            return originalDate.toISOString();
        }
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
