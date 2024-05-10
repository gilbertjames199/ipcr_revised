<template>

    <Head>
        <title>Users</title>
    </Head>

    <div class="row gap-10 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>Employees -Password Reset</h3>
            <div class="peers">
                <div class="peer mR-10">
                    <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search...">
                </div>
                <div class="peer">
                    <!-- <Link v-if="can.canInsertUsers" class="btn btn-primary btn-sm" href="/users/create">Add User</Link> -->
                    <!-- <Link class="btn btn-primary btn-sm mL-2 text-white" href="/user/employees/sync/employees/list">Sync Employees</Link> -->
                    <button class="btn btn-primary btn-sm mL-2 text-white" @click="showFilter()">Filter</button>
                </div>
            </div>
        </div>

        <filtering v-if="filter" @closeFilter="filter = false">
            <label>Filter by Employement Status</label>

            <select v-model="EmploymentStatus" class="form-control" @change="filterData()">
                <option value="Job Order">Job Order</option>
                <option value="Casual">Casual</option>
                <option value="Regular">Regular</option>

            </select>

            <!-- <input type="text" v-model="EmploymentStatus" class="form-control" @change="filterData()"> -->
            <button class="btn btn-sm btn-danger mT-5 text-white" @click="clearFilter">Clear Filter</button>
        </filtering>
        <!-- {{ auth }} -->
        <div class="col-12">
            <div class="bgc-white p-20 bd">
                <table class="table table-hover table-striped">
                    <thead style="background-color: #b7dde8;">
                        <tr>
                            <th>CATS Number</th>
                            <th scope="col">Name</th>
                            <th>Employment Status</th>
                            <th>Position</th>
                            <th>Division</th>
                            <th>Office</th>
                            <th scope="col" style="text-align: right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users.data">
                            <td>{{ user.empl_id }}</td>
                            <td>{{ user.employee_name }}</td>
                            <td>{{ user.employment_type_descr }}</td>
                            <td>{{ user.position_long_title }}</td>
                            <td>
                                <div v-if="user.division">{{ user.division.division_name1 }}</div>
                            </td>
                            <td>
                                <span v-if="user.office">{{ user.office.office }}</span>
                            </td>
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
                                        <li>
                                            <Link :href="`/ipcrsemestral/${user.id}/employees`" class="dropdown-item">
                                            IPCR Targets
                                            </Link>
                                        </li>
                                        <li>
                                            <button class="dropdown-item"
                                                @click="resetPass(user.id, user.employee_name)">
                                                Reset Password
                                            </button>
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
                        <pagination :next="users.next_page_url" :prev="users.prev_page_url" />
                        <span>{{ (10 * (users.current_page - 1)) + 1 }}</span>
                        to <span v-if="users.current_page !== users.last_page">{{ users.current_page * 10 }} </span>
                        <span v-else>{{ users.total }}</span>
                        of {{ users.total }} results
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
import Filtering from "@/Shared/Filter";
import Pagination from "@/Shared/Pagination";
//import PermissionsModal from './PermissionsModal.vue'
export default {
    components: { Pagination, Filtering },
    props: {
        auth: Object,
        users: Object,
        filters: Object,
        can: Object,
        permissions_all: Object,
    },
    mounted() {
        this.getPermissionAll();
    },
    data() {
        return {
            selected_permissions: [],
            permission_index: [],
            permission_particular: [],
            permission_option: [],
            form: useForm({
                my_id: 0,
                value: [],
            }),
            my_name: '',
            selected_user_id: null,
            permissions_selected_user: [],
            displayModal: false,
            search: this.$props.filters.search,
            confirm: false,
            filter: false
        };
    },
    watch: {
        search: _.debounce(function (value) {
            this.$inertia.get(
                "/employees/all",
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
        deleteUser(id) {
            let text = "WARNING!\nAre you sure you want to delete the record?";
            if (confirm(text) == true) {
                this.$inertia.delete("/users/" + id);
            }
        },
        resetPass(uid, name) {
            let text = "WARNING!\nAre you sure you want to reset password of the employee ( " + name + ")?";
            if (confirm(text) == true) {
                // this.$inertia.delete("/users/" + id);
                this.$inertia.post("/employees/all/reset/passwpord/" + uid)
            }
        },
        getPermissionAll() {
            // this.permission_particular =[];
            // this.permissions_all.forEach(i=>{
            //     //alert(i.permission);
            //     this.permission_particular.push({
            //         'id': i.id,
            //         'value': i.id,
            //         'label': i.permission,
            //     });
            // });
        },
        showFilter() {
            //alert("show filter");
            this.filter = !this.filter
        },
        async clearFilter() {
            this.EmploymentStatus = "";
            this.filterData();
        },
        async filterData() {
            //alert(this.mfosel);
            this.$inertia.get(
                "/employees/all",
                {
                    EmploymentStatus: this.EmploymentStatus
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
        },
        getPermInd() {
            //
        },
        fetchingUserPermissions(u_id) {
            this.form.my_id = u_id;
            //alert(u_id);
            axios.post("/users/user-permissions", { id: u_id }).then((response) => {
                this.form.value = response.data;
            });
        },

        verifyPermissions(ed, del, perm) {
            if (ed === true || del === true || perm === true) {
                alert("dropdown will show!")
                return true
            } else {
                return false
            }
        },
        showFilter() {
            this.filter = !this.filter;
        },
        showModal(id, name) {
            this.fetchingUserPermissions(id, name);
            this.my_name = name;
            this.displayModal = true;
        },
        hideModal() {
            this.displayModal = false;
        },
        submitChanges() {
            let text = "WARNING!\nAre you sure you want to save changes in user permissions for " + this.my_name + "?";
            if (confirm(text) == true) {
                this.form.get("/users/update-permissions", this.form);
            }
        },
    },
};
</script>
