<template>
    <!-- {{ offices }}
       -->

    <Head>
        <title>Offices</title>
    </Head>

    <div class="row gap-10 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>Summary of Ratings</h3>
            <div class="peers">
                <!-- <div class="peer mR-10">
                    <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search...">
                </div> -->
                <div class="peer">
                    <!-- <Link v-if="can.canInsertUsers" class="btn btn-primary btn-sm" href="/users/create">Add User</Link> -->
                    <!-- <Link class="btn btn-primary btn-sm mL-2 text-white" href="/user/employees/sync/employees/list">Sync Employees</Link> -->
                    <!-- <button class="btn btn-primary btn-sm mL-2 text-white" @click="showFilter()">Filter</button> -->
                    <button class="btn btn-primary btn-sm mL-2 text-white" @click="showFilterP()">Print Summary</button>
                </div>
            </div>
        </div>
        <FilterPrinting v-if="filter_p" @closeFilter="filter_p = false">
            Filter By Employment type
            <select v-model="type_filter" class="form-control">
                <option value="RE">Regular</option>
                <option value="CE">Casual</option>
                <option value="JO">Job Order</option>
            </select>
            <button class="btn btn-sm btn-primary mT-5 text-white" @click="printSubmit">Print Report</button>
        </FilterPrinting>
        <div class="col-12">
            <div class="bgc-white p-20 bd">
                <table class="table table-hover table-striped">
                    <thead style="background-color: #b7dde8;">
                        <tr>
                            <th>Office</th>
                            <th scope="col" style="text-align: right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="office in offices">
                            <td>{{ office.office }}</td>
                            <td style="text-align: right">
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
                                        <li class="dropdown-item">

                                            <Link :href="`/summary-rating/alloffices/${office.department_code}`">
                                            IPCR Summary
                                            </Link>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";
import FilterPrinting from "@/Shared/FilterPrint";
export default {
    props: {
        auth: Object,

        can: Object,
        permissions_all: Object,
        offices: Object,
        // divisions: Object,
    },
    data() {
        return {
            filter_p: false,
            type_filter: "",
        }
    },
    watch: {

    },
    components: {
        FilterPrinting,
    },
    methods: {
        showFilterP() {
            // alert("show filter");
            this.filter_p = !this.filter_p
        },
    }
}
</script>
