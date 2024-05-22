<template>

    <Head>
        <title>Special Department</title>
    </Head>
    <div class="row gap-10 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>Employees -Special Department</h3>
            <div class="peers">
                <div class="peer mR-10">
                    <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search...">
                </div>
                <div class="peer">
                    <Link class="btn btn-primary btn-sm" href="/employee/special/department/create">Add Employee
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
            <table class="table table-hover table-striped">
                <thead style="background-color: #b7dde8;">
                    <tr>
                        <th>Employee Name</th>
                        <th>Designated Special Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="dat in data.data">
                        <td>{{ dat.employee_name }}</td>
                        <td>{{ dat.office }}</td>
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
                                        <Link :href="`/employee/special/department/${dat.id}/edit`"
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
        </div>
    </div>
</template>
<script>

export default {
    components: {},
    props: {
        data: Object
    },
    data() {
        return {

        }
    },
    mounted() { },
    watch: {},
    methods: {
        deleteEmployee(id) {
            let text = "WARNING!\nAre you sure you want to delete the employee special department?";
            if (confirm(text) == true) {
                this.$inertia.delete("/employee/special/department/delete/" + id);
            }
        },
    }
}
</script>
