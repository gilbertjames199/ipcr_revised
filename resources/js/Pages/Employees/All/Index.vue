<template>

    <Head>
        <title>Users</title>
    </Head>

    <div class="row gap-10 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>Employees</h3>
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
            <label>Filter by Department</label>
            <select v-model="office_selected" class="form-control" @change="getDivision()">
                <option value=""></option>
                <option v-for="office in offices" :value="office.department_code">
                    {{ office.office }}
                </option>
            </select>

            <label>Filter by Division</label>
            <!-- {{ division_selected }} -->
            <select v-model="division_selected" class="form-control" @change="filterData()">
                <option value=""></option>
                <option v-for="div in divisions" :value="div.division_code">
                    {{ div.division_name1 }}
                </option>
            </select>

            <label>Filter by Active Status</label>
            <select v-model="active_status" class="form-control" @change="filterData()">
                <option value=""></option>
                <option value="ACTIVE">Active</option>
                <option value="IN-ACTIVE">Inactive</option>
                <!-- <option value="Regular">Regular</option> -->
            </select>
            <!-- {{ divisions }} -->
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
                            <th>Active Status</th>
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
                                <!-- /ipcrsemestral2/{{user.empl_id_bcrypt}} -->
                                <!-- {{ user.credential.id }} -->

                                <!-- {{ auth.user.username }} -->
                            </td>
                            <td>
                                <span v-if="user.active_status=='ACTIVE'">{{ user.active_status }}</span>
                                <span v-else>INACTIVE</span>
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
                                        <!-- <li
                                            v-if="$page.props.auth.user.name.empl_id != '2003' && $page.props.auth.user.name.empl_id != '8447' && $page.props.auth.user.name.empl_id != '8753'">
                                            <Link :href="`/ipcrsemestral/${user.id}/employees`" class="dropdown-item">
                                            IPCR Targets
                                            </Link>
                                        </li> -->
                                        <li
                                            v-if="$page.props.auth.user.name.empl_id != '2730' && $page.props.auth.user.name.empl_id != '2960'">

                                            <button class="dropdown-item"
                                                @click="showModalPass(user.credential.id, user.employee_name)">
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
                                        <!-- <li>
                                            <a href="{{ route('impersonate', $user->id) }}"></a>
                                        </li> -->
                                        <li>
                                            <button class="dropdown-item" v-if="$page.props.auth.user.name.empl_id != '2730' && $page.props.auth.user.name.empl_id != '2960'"
                                                @click="impersonate(user.credential.id, user.empl_id, auth.user.username, user.employee_name)">
                                                Impersonate
                                            </button>
                                        </li>
                                        <li v-if="$page.props.auth.user.name.empl_id == '2730' || $page.props.auth.user.name.empl_id == '2960'">
                                            <button class="dropdown-item"
                                                @click="updateStatus(user.credential.id, user.employee_name, user.active_status)">
                                                Update status
                                            </button>
                                        </li>
                                        <li>
                                            <Link class="dropdown-item" :href="`/ipcrsemestral2?value=${user.empl_id_bcrypt}`">IPCR </Link>
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
        <ModalPass v-if="displayModalPass" @close-modal-event="hideModalPass" :title="`RESET PASSWORD`">
            <!-- {{ form }} -->
            <div class="peer mR-10 form-control-sm">
                Reset Password of: <input class="form-control form-control-sm" v-model="reset_name" disabled/><br>
            </div>
            <div class="peer mR-10 form-control-sm">
                Requested by: <input class="form-control form-control-sm" v-model="requestor_name" disabled/>
                <span class="font-weight-bold text-danger" v-if="!requestor_name">Please use the search box below to select and click the requester's name.</span>
            </div>
            <div class="peer mR-10 form-control-sm">
                Remarks: <input class="form-control form-control-sm" v-model="form.password_change_remarks" :disabled="!requestor_name"/><br>
            </div>
            <button class="btn btn-sm btn-primary mT-5 text-white" @click="resetPass(form.id, reset_name, requestor_name)"
                :disabled="!requestor_name"
            >Submit</button>
            <button class="btn btn-sm btn-danger mT-5 text-white" @click="cancelReset">Cancel</button>
            <div class="peer mR-10">
                Search:
                <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search..."  >
            </div>

            <div class="col-12">
                <div class="bgc-white p-20 bd">
                    <table class="table table-hover table-striped">
                        <thead style="background-color: #b7dde8;">
                            <tr>
                                <th>CATS Number</th>
                                <th scope="col">Name</th>
                                <!-- <th>Employment Status</th> -->
                                <!-- <th>Office</th> -->
                                <!-- <th scope="col" style="text-align: right">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users.data" @click="SelectEmployee(user.empl_id, user.employee_name, user.is_admin)"
                                style="cursor: pointer" onmouseover="this.style.backgroundColor='gold'; this.style.color='red';"
                                onmouseout="this.style.backgroundColor=''; this.style.color='';"
                            >
                                <td>{{ user.empl_id }}</td>
                                <td>{{ user.employee_name }}</td>
                                <!-- <td>{{ user.employment_type_descr }}</td> -->
                                <!-- <td>{{ user.position_long_title }} </td> -->
                                <!-- <td>
                                    <div v-if="user.division">{{ user.division.division_name1 }}</div>
                                </td>
                                <td>
                                    <span v-if="user.office">{{ user.office.office }}</span>
                                    {{ user.credential.id }}
                                    {{ user }}
                                    {{ auth.user.username }}
                                </td> -->
                                <!-- <td style="text-align: right">
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
                                                    @click="showModalPass(user.credential.id, user.employee_name)">
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
                                                <button class="dropdown-item"
                                                    @click="impersonate(user.credential.id, user.empl_id, auth.user.username, user.employee_name)">
                                                    Impersonate
                                                </button>
                                            </li>

                                        </ul>
                                    </div>
                                </td> -->
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
            <!-- <multiselect :options="requestor_sel" :searchable="true" v-model="form.requestor_id"
                                            label="label" track-by="label" @close="selected_ipcr">
                                        </multiselect> -->
        </ModalPass>
        <ModalStatus v-if="displayStatusModal" @close-modal-event="hideModalStat" :title="`UPDATE EMPLOYEE STATUS`">
            UPDATE STATUS OF: <input class="form-control form-control-sm" v-model="reset_name" disabled/><br>
            EMPLOYEE STATUS:
            <select class="form-select" v-model="disp_active_stat">
                <option value="ACTIVE">ACTIVE</option>
                <option value="IN-ACTIVE">INACTIVE</option>
            </select>
            <div class="peer mR-10 form-control-sm">
                Remarks: <input class="form-control form-control-sm" v-model="form.password_change_remarks" /><br>
            </div>
            <button class="btn btn-primary text-white" @click="updateStatusSave()">UPDATE STATUS</button>
        </ModalStatus>
        <!-- {{ auth.user.name.id }} -->
          <!-- {{  users }} -->
    </div>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
import Filtering from "@/Shared/Filter";
import Pagination from "@/Shared/Pagination";
import Modal from "@/Shared/ModalSmall";
import ModalPass from "@/Shared/ModalSmall";
import ModalStatus from "@/Shared/ModalSmall";

import Swal from 'sweetalert2'

//import PermissionsModal from './PermissionsModal.vue'
export default {
    components: { Pagination, Filtering, Modal, Swal, ModalPass, ModalStatus },
    props: {
        auth: Object,
        users: Object,
        filters: Object,
        can: Object,
        permissions_all: Object,
        offices: Object,
        // divisions: Object,
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
            //     ipaddress: 0,
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
            reset_name: "",
            reset_id: "",
            requestor_name: "",
            // remarks_initial: "",
            active_status: "",
            form: useForm({
                email: "",
                id: "",
                requestor_id: "",
                password_change_remarks: "",
                ipaddress: "",
            }),
            divisions: [],
            displayModalPass: false,
            displayStatusModal: false,
            disp_active_stat: "",
        };
    },
    computed: {
        requestor_sel() {
            let users1 = this.users;
            return users1.map((user) => ({
                value: user.empl_id,
                label: user.employee_name +  (user.office ? ' - ' + user.office:''),
                // FFUNCCOD: ipcr.FFUNCCOD,
                // department_code: ipcr.department_code,
                // department_code: ipcr.department_code,
                // department_code: ipcr.department_code,
                // department_code: ipcr.department_code,
                // department_code: ipcr.department_code,
            }));
        },
    },
    watch: {
        search: _.debounce(function (value) {
            this.$inertia.get(
                "/employees/all",
                {
                    search: value,
                    EmploymentStatus: this.EmploymentStatus,
                    office: this.office_selected,
                    division: this.division_selected,
                    active_status: this.active_status,
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
            // this.filterData();
        }, 300),
    },
    methods: {
        deleteUser(id) {
            let text = "WARNING!\nAre you sure you want to delete the record?";
            if (confirm(text) == true) {
                this.$inertia.delete("/users/" + id);
            }
        },
        resetPass(uid, name, requestor_name) {
            let text = "WARNING!\nAre you sure you want to reset password of the employee ( " + name + ") as requested by " + requestor_name +"?";
            if (confirm(text) == true) {
                // this.$inertia.delete("/users/" + id);
                this.form.post("/employees/all/reset/passwpord/" + uid);
                setTimeout(() => {
                    // this.displayModal = false;
                    this.cancelReset()
                }, 1000);
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
            this.office_selected = "";
            this.division_selected = "";
            this.active_status="";
            this.divisions = [];
            // this.search_text="";
            this.filterData();

        },
        async filterData() {
            //alert(this.mfosel);
            this.$inertia.get(
                "/employees/all",
                {
                    EmploymentStatus: this.EmploymentStatus,
                    office: this.office_selected,
                    division: this.division_selected,
                    active_status: this.active_status,
                    // search: this.search_text
                },
                {
                    preserveScroll: true,
                    preserveState: true,
                    replace: true,
                }
            );
        },
        async getDivision() {
            // await axios.get('/division')
            // alert(this.office_selected);
            this.divisions = [];
            this.division_selected = "";
            var url = '/employees/division/' + this.office_selected;
            await axios.get(url).then((response) => {
                // this.core_support = response.data;
                this.divisions = response.data
                console.log(response.data);
            });
            this.filterData();
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
        hideModalStat(){
            this.displayStatusModal=false;
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

            /*
            if (confirm("Are you sure you want to impersonate this user?")) {
                await this.$inertia.get(`/impersonate/take/${userId}`)
                    .then(() => {
                        // Redirect or handle success response as needed
                        window.location.reload(); // Optional: reload to apply changes
                    })
                    .catch(error => {
                        console.error('Error during impersonation:', error);
                    });
            }*/

        },
        showModalPass(uid, name){
            this.displayModalPass =true;
            this.form.id=uid;
            this.reset_id=uid;
            this.reset_name=name;
        },
        hideModalPass(){
            this.displayModalPass = false;
        },
        SelectEmployee(id, name, is_admin){
            // alert(id+' '+name)
            this.form.requestor_id=id;
            this.requestor_name=name;
            if(is_admin==0){
                alert(is_admin)
                // this.form.password_change_remarks='password change request '
                if(this.form.id == id){

                }else{
                    if(this.is_admin=='0'){
                        this.form.password_change_remarks
                    }
                }
            }
        },
        cancelReset(){
            this.reset_name=null;
            this.requestor_name=null;
            this.reset_name=null;
            this.requestor_name=null;
            this.form.email=null;
            this.id=null;
            this.requestor_id=null;
            this.disp_active_stat =null;
            setTimeout(() => {
                // this.displayModal = false;
                this.hideModalPass()
                this.hideModalStat()
            }, 1000);
        },
        updateStatus(u_id,name, active_stat){
            // user.credential.id, user.employee_name, user.active_status
            this.id=u_id
            this.reset_name=name;
            this.displayStatusModal=true;
            this.disp_active_stat =active_stat
        },
        async updateStatusSave( ){
            // emp_cats
            // requested_by_cats
            // reset_by_cats
            // ipaddress
            // remarks
            const response = await fetch('https://api.ipify.org?format=json');
            const data = await response.json();
            const ipAddress = data.ip;
            // alert(ipAddress);
            let text = "WARNING!\nAre you sure you want to update status of  " + this.reset_name + "?";
            if (confirm(text) == true) {
                // this.$inertia.delete("/users/" + id);
                this.form.post("/employees/all/update/status/" + this.id+"/"+this.disp_active_stat);
                setTimeout(() => {
                    // this.displayModal = false;
                    this.cancelReset()
                }, 1000);
            }
        },
        // makeUrlSafe(hash) {
        //     const base64Encoded = btoa(hash); // Encode to Base64
        //     const urlSafeHash = base64Encoded
        //     .replace(/\+/g, '-') // Replace '+' with '-'
        //     .replace(/\//g, '_') // Replace '/' with '_'
        //     .replace(/=+$/, ''); // Remove trailing '='
        //     return urlSafeHash;
        // },********************************************************
        // if (this.auth.user.name.id == userId) {
        //     alert('You are not allowed to impersonate yourself.')
        // } else {
        //     if (this.auth.impersonating == 'yes') {
        //         alert('You can\'t impersonate while impersonating!')
        //     } else {

        //     }
        // }
    },
};
</script>
