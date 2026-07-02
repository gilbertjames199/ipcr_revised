<template>
    <Head>
        <title>Users</title>
    </Head>

    <div class="row gap-10 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>Probationary/Temporary Employees </h3>
            <div class="peers">
                <div class="peer mR-10">
                <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search...">
                </div>
                <div class="peer">
                    <Link class="btn btn-primary btn-sm" href="/probationary/create">Add Employee</Link>
                    <!-- <Link class="btn btn-primary btn-sm mL-2 text-white" href="/probationary/create">Add Employees 2</Link> -->
                    <button class="btn btn-primary btn-sm mL-2 text-white" @click="showFilter()">Filter</button>
                </div>
            </div>
        </div>

        <filtering v-if="filter" @closeFilter="filter = false">
            <label>Filter by Employement Status</label>
            <input type="text" v-model="EmploymentStatus" class="form-control" @change="filterData()">
            <button class="btn btn-sm btn-danger mT-5 text-white" @click="clearFilter">Clear Filter</button>
        </filtering>

        <div class="col-12">
            <div class="bgc-white p-20 bd">
                <table class="table table-hover table-striped">
                    <thead style="background-color: #b7dde8">
                        <tr>
                            <th scope="col">Name</th>
                            <th>Status</th>
                            <th>Period</th>
                            <th>Division</th>
                            <th>Office</th>
                            <!-- <th>Generate IPCR</th> -->
                            <th scope="col" style="text-align: right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users.data">
                            <td>{{ user.employee_name }}</td>
                            <td>{{ user.prob_status }}</td>
                            <td>{{ setPeriod(user.date_from, user.date_to) }}</td>
                            <td>
                                <div v-if="user.Division">{{ user.Division.division_name1 }}</div>
                                <!-- {{ user }} -->
                            </td>
                            <td>
                                <!-- {{user.Office}} -->
                                 <!-- {{auth.user}} -->
                                <div v-if="user.Office">{{ user.Office.office}}</div>
                            </td>

                            <td style="text-align: right">
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
                                            <Link :href="`/ipcrsemestral/${user.id}/employees`" class="dropdown-item">
                                            IPCR Targets {{ user.username }}</Link>
                                        </li>
                                        <li v-if="!user.sem_id">
                                            <Link class="dropdown-item" :href="`/probationary/${user.p_id}/edit`">Edit</Link>
                                        </li>
                                        <li>
                                            <Link class="text-danger dropdown-item" @click="deleteEmp(user.p_id)">Delete
                                            </Link>
                                        </li>
                                        <li>
                                            <!-- v-if="$page.props.auth.user.name.empl_id != '2730' && $page.props.auth.user.name.empl_id != '2960'" -->
                                            <button class="dropdown-item"
                                                @click="impersonate(user.credential.id, user.empl_id, auth.user.username, user.employee_name)">
                                                Impersonate
                                            </button>
                                        </li>
                                        <!--<li>v-if="verifyPermissions(user.can.canEditUsers, user.can.canUpdateUserPermissions, user.can.canDeleteUsers)"<Link class="dropdown-item" :href="`/users/${user.id}/edit`">Permissions</Link></li>-->
                                        <!--
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
import Swal from 'sweetalert2'

//import PermissionsModal from './PermissionsModal.vue'
export default {
    components: { Pagination, Filtering, Swal },
    props: {
        auth: Object,
        users: Object,
        filters: Object,
        can: Object,
        permissions_all: Object,
    },
    mounted() {
        //this.getPermissionAll();
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
                "/probationary",
                { search: value },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
        }, 300),
    },
    computed: {

    },
    methods: {
        deleteEmp(id) {
            let text = "WARNING!\nAre you sure you want to delete the record?";
            if (confirm(text) == true) {
                this.$inertia.delete("/probationary/delete/" + id);
            }
        },

        showFilter() {
            this.filter = !this.filter
        },
        async clearFilter() {
            this.EmploymentStatus = "";
            this.filterData();
        },
        async filterData() {
            this.$inertia.get(
                "/employees/",
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
        showFilter() {
            this.filter = !this.filter;
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
        setPeriod(dtfrom, dtto) {
            try {
                var dt_from = JSON.parse(dtfrom); // Convert the JSON string to a JavaScript object
                var dt_to = JSON.parse(dtto);
                var last_ind = parseFloat(dt_to.length) - 1;
                var period = this.formatDateRange(dt_from[0], dt_to[last_ind])
                return period;
            } catch (error) {
                console.error('Error parsing JSON:', error);
                return null; // Handle the error gracefully
            }
        },
        async impersonate(userId, empl_id, current_user, emp_name) {
            if (empl_id == current_user) {
                // alert("You can't impersonate yourself!")
                this.$swal({
                    icon: 'error',
                    title: 'You can\'t impersonate yourself!',
                    timer: 5000, // Set duration
                    timerProgressBar: true,
                    // showCancelButton: true,
                    customClass: {
                        popup: `bg-gradient-danger`
                    }
                });
            } else {
                this.$swal({
                    title: "Are you sure?",
                    text: "Do you want to impersonate " + emp_name + "?",
                    type: "warning",
                    // buttons: true,
                    // dangerMode: true,
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                })
                    .then((result) => {
                        if (result.isConfirmed) {
                            this.$inertia.get(`/impersonate/take/${userId}`, {}, {
                                onSuccess: () => {
                                    // Redirect or handle success response as needed
                                    window.location.reload(); // Optional: reload to apply changes
                                },
                                onError: (errors) => {
                                    console.error('Error during impersonation:', errors);
                                }
                            });
                        } else {
                            // this.$swal("Impersonation cancelled!", {
                            //     title: "Impersonation cancelled",
                            //     icon: "info",
                            // });
                        }
                    });
                // if (confirm("Are you sure you want to impersonate this user?")) {
                //     this.$inertia.get(`/impersonate/take/${userId}`, {}, {
                //         onSuccess: () => {
                //             // Redirect or handle success response as needed
                //             window.location.reload(); // Optional: reload to apply changes
                //         },
                //         onError: (errors) => {
                //             console.error('Error during impersonation:', errors);
                //         }
                //     });
                // }
            }
        }
    },
};
</script>
