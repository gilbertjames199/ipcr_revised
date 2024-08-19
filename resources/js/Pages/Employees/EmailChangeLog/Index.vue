<template>

    <Head>
        <title>Email Change Log</title>
    </Head>
    <div class="row gap-10 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>Email Change Log</h3>
            <div class="peers">
                <div class="peer mR-10">
                    <!-- <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search..."> -->
                </div>
                <div class="peer">
                    <!-- <Link v-if="can.canInsertUsers" class="btn btn-primary btn-sm" href="/users/create">Add User</Link> -->
                    <!-- <Link class="btn btn-primary btn-sm mL-2 text-white" href="/user/employees/sync/employees/list">Sync Employees</Link> -->
                    <button class="btn btn-primary btn-sm mL-2 text-white" @click="showFilter()">Filter</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="bgc-white p-20 bd">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Acted by</th>
                        <th>Date Acted</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="email in emlog.data">
                        <td>{{ email.edited_by_name }}</td>
                        <td>{{ email.username_long }}</td>
                        <td>{{ email.created_at }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <!-- read the explanation in the Paginate.vue component -->
                    <!-- <pagination :links="users.links" /> -->
                    <!-- {{ emlog }} -->
                    <pagination :next="emlog.next_page_url" :prev="emlog.prev_page_url" />



                    <!-- <span>{{ (10 * (users.current_page - 1)) + 1 }}</span>
                    to <span v-if="users.current_page !== users.last_page">{{ users.current_page * 10 }} </span>
                    <span v-else>{{ users.total }}</span>
                    of {{ users.total }} results -->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";
import Filtering from "@/Shared/Filter";
import Pagination from "@/Shared/Pagination";
export default {
    components: { Pagination, Filtering },
    props: {
        auth: Object,
        users: Object,
        filters: Object,
        can: Object,
        permissions_all: Object,
        emlog: Object
    },
}
</script>
