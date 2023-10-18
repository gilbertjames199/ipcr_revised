<template>
    <Head>
        <title>Users</title>
    </Head>

    <div class="row gap-10 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>IPCR Score Import</h3>
            <div class="peers">
                <div class="peer mR-10">
                    <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search...">
                </div>
                <div class="peer">
                    <button class="btn btn-primary btn-sm mL-2 text-white" @click="showModal()">Import</button>
                    <button class="btn btn-primary btn-sm mL-2 text-white" @click="showFilter()">Filter</button>
                </div>
            </div>
        </div>

        <filtering v-if="filter" @closeFilter="filter = false">
            <label>Sample Inputs</label>
            <input type="text" class="form-control">
            <button class="btn btn-sm btn-primary mT-5 text-white" @click="">Filter</button>
        </filtering>

        <div class="col-12">
            <div class="bgc-white p-20 bd">
                <table class="table table-hover table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col" style="text-align: right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr >
                            <td></td>
                            <td>{{ user.id }}</td>
                            <td style="text-align: right">
                                <div class="dropdown dropstart" >
                                  <button class="btn btn-secondary btn-sm action-btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                      <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                    </svg>
                                  </button>
                                  <ul class="dropdown-menu action-dropdown"  aria-labelledby="dropdownMenuButton1">
                                    <li>v-if="verifyPermissions(user.can.canEditUsers, user.can.canUpdateUserPermissions, user.can.canDeleteUsers)"<Link class="dropdown-item" :href="`/users/${user.id}/edit`">Permissions</Link></li>
                                    <li v-if="user.can.canEditUsers"><Link class="dropdown-item" :href="`/users/${user.id}/edit`">Edit</Link></li>
                                    <li v-if="user.can.canUpdateUserPermissions"><button class="dropdown-item" @click="showModal(user.id, user.name)">Permissions</button></li>
                                    <li v-if="user.can.canDeleteUsers"><hr class="dropdown-divider action-divider"></li>
                                    <li v-if="user.can.canDeleteUsers"><Link class="text-danger dropdown-item" @click="deleteUser(user.id)">Delete</Link></li>
                                  </ul>
                                </div>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <!-- read the explanation in the Paginate.vue component -->
                        <!-- <pagination :links="users.links" /> -->
                        <!-- <pagination :next="users.next_page_url" :prev="users.prev_page_url" /> -->
                    </div>
                </div>
            </div>
        </div>
        <Modal v-if="displayModal" @close-modal-event="hideModal">
            <h1>Upload Excel File</h1><br>
            <form @submit.prevent="submit">
                <input type="file" ref="myFile" @input="form.myfile = $event.target.files[0]" @change="onFileChanged()" />
                <progress v-if="form.progress" class="form-control" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                </progress>
                <button type="submit" class="btn btn-primary btn-sm mL-2 text-white">Submit</button>
            </form>
        </Modal>
    </div>
</template>

<script>
// import { useForm } from "@inertiajs/inertia-vue3";
import Filtering from "@/Shared/Filter";
import Pagination from "@/Shared/Pagination";
import Modal from "@/Shared/PrintModal";

export default {
    components: { Pagination, Filtering, Modal },
    props: {

    },
    mounted() {

    },
    data() {
        return {
            displayModal: false,
            form: this.$inertia.form({
                myfile: null,
                name: null,
                avatar: null,
                type: true,
            }),
        };
    },
    watch: {

    },
    methods: {
        submit() {
            if (!this.form.myfile) {
                alert("No file chosen!");
            } else {
                this.form.post('/ipcr/score/import')
                this.hideModal()
            }
        },
        onFileChanged() {
            this.form.myfile = this.$refs.myFile.files[0];
            console.log(this.form.myfile)
        },
        showModal() {
            this.displayModal = true
        },
        hideModal() {
            this.displayModal = false
        }
    },
};
</script>
