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
                <option value=""></option>
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
                            <td>{{ user.position_long_title }} </td>
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
                                        <li
                                            v-if="$page.props.auth.user.name.empl_id != '2003' && $page.props.auth.user.name.empl_id != '8447' && $page.props.auth.user.name.empl_id != '8753'">
                                            <Link :href="`/ipcrsemestral/${user.id}/employees`" class="dropdown-item">
                                            IPCR Targets
                                            </Link>
                                        </li>
                                        <li
                                            v-if="$page.props.auth.user.name.empl_id != '2730' && $page.props.auth.user.name.empl_id != '2960'">

                                            <button class="dropdown-item"
                                                @click="resetPass(user.id, user.employee_name)">
                                                Reset Password
                                            </button>
                                        </li>
                                        <li
                                            v-if="$page.props.auth.user.name.empl_id != '2730' && $page.props.auth.user.name.empl_id != '2960'">
                                            <button class="dropdown-item"
                                                @click="showModalEmail(user.credential.username, user.credential.email, user.employee_name)">
                                                Update email
                                            </button>
                                        </li>
                                        <li>
                                            <a href="{{ route('impersonate', $user->id) }}"></a>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" @click="impersonate(user.id)">
                                                Impersonate
                                            </button>
                                        </li>

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
        <Modal v-if="displayModal" @close-modal-event="hideModal" :title="`UPDATE EMAIL`">
            Name: <u>{{ my_name }}</u><br> <br>
            <!-- Office: <u> {{ my_office }}</u><br> <br> -->
            Email: <br><input type="email" class="form-class" v-model="my_email" style="width: calc(100% - 30px); /* Adjust width to match modal width with 15px padding on each side */
    padding: 10px 15px;" />
            <br> <br>
            <button class="btn btn-primary text-white" @click="updateEmail(my_name)">Update email</button>&nbsp;&nbsp;
            <button class="btn btn-danger text-white" @click="hideModalDisplay">Cancel</button>
            <!-- <div class="d-flex justify-content-center">

            </div> -->
        </Modal>
    </div>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
import Filtering from "@/Shared/Filter";
import Pagination from "@/Shared/Pagination";
import Modal from "@/Shared/ModalSmall";

//import PermissionsModal from './PermissionsModal.vue'
export default {
    components: { Pagination, Filtering, Modal },
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
            // form: useForm({
            //     my_id: 0,
            //     value: [],
            // }),
            my_name: '',
            selected_user_id: null,
            permissions_selected_user: [],
            displayModal: false,
            search: this.$props.filters.search,
            confirm: false,
            filter: false,
            my_email: '',
            my_id: '',
            my_name: "",
            my_office: "",
            form: useForm({
                email: "",
                id: "",
            })
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
        showModalEmail(u_id, u_email, u_name) {
            this.my_email = u_email;
            this.my_id = u_id;
            this.my_name = u_name;


            this.displayModal = true;
        },
        hideModal() {
            this.displayModal = false;
        },
        hideModalDisplay() {
            this.displayModal = false;
            this.my_email = "";
            this.my_id = "";
            this.my_name = "";
        },
        async updateEmail(name) {
            let text = "WARNING!\nAre you sure you want to update the email of the employee ( " + name + ")?";
            if (confirm(text) == true) {
                try {

                    this.form.email = this.my_email;
                    this.form.id = this.my_id;
                    this.form.post('/employees/updateEmail')
                    // console.log('Email updated successfully:', response.data);
                    if (this.search == '') {
                        this.search = this.my_name;

                        window.location.reload();
                    } else {
                        this.retypeSearchValue();
                    }

                } catch (error) {
                    console.error('There was an error updating the email:', error);
                }

            }


        },
        retypeSearchValue() {
            const searchValue = this.search;
            this.search = ''; // Clear the search input

            // Retype the search value letter by letter
            for (let i = 0; i < searchValue.length; i++) {
                setTimeout(() => {
                    this.search += searchValue[i];
                }, i * 5); // Adjust the delay as needed
            }
        },
        impersonate(userId) {
            if (this.auth.impersonating == 'yes') {
                alert('You can\'t impersonate while impersonating!')
            } else {
                if (confirm("Are you sure you want to impersonate this user?")) {
                    this.$inertia.get(`/impersonate/take/${userId}`)
                        .then(() => {
                            // Redirect or handle success response as needed
                            window.location.reload(); // Optional: reload to apply changes
                        })
                        .catch(error => {
                            console.error('Error during impersonation:', error);
                        });
                }
            }

        }
    },
};
</script>
