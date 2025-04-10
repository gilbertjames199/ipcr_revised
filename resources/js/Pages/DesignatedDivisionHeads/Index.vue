<template>

    <Head>
        <title>Designates</title>
    </Head>
    <div class="row gap-10 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>Designated Heads</h3>
            <div class="peers">
                <div class="peer mR-10">
                    <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search...">
                </div>
                <div class="peer">
                    <Link class="btn btn-primary btn-sm" href="/designated-division-head/create">Add Employee
                    </Link>
                    <!-- <Link class="btn btn-primary btn-sm mL-2 text-white" href="/user/employees/sync/employees/list">Sync Employees</Link> -->
                    <!-- <button class="btn btn-primary btn-sm mL-2 text-white" @click="showFilter()">Filter</button> -->
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="bgc-white p-20 bd">
            <!-- {{ data }} -->
            <!-- <span v-if="$page.props.auth.pcr_type ==='div'">DPCR Targets</span>
            <span v-if="$page.props.auth.pcr_type ==='hdiv'">DPCR Targets</span>
            <span v-if="$page.props.auth.pcr_type ==='emp'">IPCR Targets</span>
            <span v-if="$page.props.auth.pcr_type ==='hemp'">IPCR Targets</span>
            <span v-if="$page.props.auth.pcr_type ==='sec'">SPCR Targets</span>
            <span v-if="$page.props.auth.pcr_type ==='hsec'">SPCR Targets</span>
            <span v-if="$page.props.auth.pcr_type ==='hos'">HPCR Targets</span> -->
            <table class="table table-hover table-striped">
                <thead style="background-color: #b7dde8;">
                    <tr>
                        <th>Employee Name</th>
                        <th>Type</th>
                        <th>Office/Department</th>
                        <th>Division</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="dat in data.data">
                        <td>{{ dat.user_employee.employee_name }}</td>
                        <td>

                            <span v-if="dat.type==='dpcr'">Division Head</span>
                            <span v-if="dat.type==='spcr'">Section Head</span>
                            <span v-if="dat.type==='hpcr'">Chief of Hospital</span>
                            <span v-if="dat.type==='hdpcr'">Hospital Division Head</span>
                            <span v-if="dat.type==='hspcr'">Hospital Section Head</span>
                            <span v-if="dat.type==='ipcr'">Other designation </span>
                        </td>
                        <td>
                            <span v-if="dat.type==='hpcr'">
                                <span v-if="dat.office">{{ dat.office.office }}</span>
                            </span>
                            <span v-else-if="dat.type==='ipcr'"></span>
                            <span v-else>{{ dat.division.office.office }}</span>
                        </td>
                        <td>
                            <span v-if="dat.type==='hpcr'"></span>
                            <span v-else-if="dat.type==='ipcr'"></span>
                            <span v-else>{{ dat.division.division_name1 }}</span>
                        </td>
                        <td>
                            <div class="dropdown dropstart">
                                <button class="btn btn-secondary btn-sm action-btn" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-three-dots" viewBox="0 0 16 16">
                                        <path
                                            d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                    </svg>
                                </button>
                                <ul class="dropdown-menu action-dropdown" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <!-- /designated-division-head/{slug}/edit /designated-division-head/{{dat.slug}}/edit-->
                                        <Link :href="`/designated-division-head/${dat.slug}/edit`"
                                            class="dropdown-item">
                                        Edit </Link>
                                    </li>
                                    <li>
                                        <Button class="text-danger dropdown-item" @click="deleteEmployee(dat.id)">Delete
                                        </Button>
                                    </li>
                                    <!--<li>v-if="verifyPermissions(user.can.canEditUsers, user.can.canUpdateUserPermissions, user.can.canDeleteUsers)"<Link class="dropdown-item" :href="`/users/${user.id}/edit`">Permissions</Link></li>-->
                                    <!-- <li v-if="user.can.canEditUsers"><Link class="dropdown-item" :href="`/users/${user.id}/edit`">Edit</Link></li>
                                    <li v-if="user.can.canUpdateUserPermissions"><button class="dropdown-item" @click="showModal(user.id, user.name)">Permissions</button></li>
                                    <li v-if="user.can.canDeleteUsers"><hr class="dropdown-divider action-divider"></li>
                                    <li v-if="user.can.canDeleteUsers"><Link class="text-danger dropdown-item" @click="deleteUser(user.id)">Delete</Link></li> -->
                                </ul>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <!-- read the explanation in the Paginate.vue component -->
                    <!-- <pagination :links="users.links" /> -->
                    <pagination :next="data.next_page_url" :prev="data.prev_page_url" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Pagination from "@/Shared/Pagination";

export default {
    components: { Pagination },
    props: {
        filters: Object,
        data: Object
    },
    data() {
        return {
            search: this.$props.filters.search,
        }
    },
    mounted() { },
    watch: {
        search: _.debounce(function (value) {
            this.$inertia.get(
                "/employee/special/department",
                { search: value },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
        }, 300),
    },
    methods: {
        deleteEmployee(id) {
            let text = "WARNING!\nAre you sure you want to remove the employee from designated department heads?";
            if (confirm(text) == true) {
                this.$inertia.delete("/designated-division-head/delete/" + id);
            }
        },
    }
}
</script>
