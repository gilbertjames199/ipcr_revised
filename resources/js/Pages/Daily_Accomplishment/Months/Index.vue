<template>
    <Head>
        <title>Monthly Deadline</title>
    </Head>
    <div class="row gap-10 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>MONTHLY DEADLINE</h3>
            <div class="peers">
                <div class="peer mR-10">
                    <input v-model="search" type="text" class="form-control form-control-sm" placeholder="Search...">
                </div>
                <div class="peer d-flex align-items-center gap-2">
                    <!-- Year Selector -->
                    <select v-model="selectedYear" class="form-select form-select-sm" style="width: 120px;">
                        <option value="">-- Year --</option>
                        <option v-for="year in yearOptions" :key="year" :value="year">{{ year }}</option>
                    </select>

                    <!-- Generate Button -->
                    <button
                        class="btn btn-success btn-sm"
                        @click="generateDeadlines"
                    >
                        Generate Monthly Deadlines
                    </button>

                    <!-- <Link class="btn btn-primary btn-sm" href="/employee/special/department/create">
                        Add Employee
                    </Link> -->
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="bgc-white p-20 bd">
            <table class="table table-hover table-striped">
                <thead style="background-color: #b7dde8;">
                    <tr>

                        <th>Period</th>
                        <th>Deadline</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="dat in data" :key="dat.id">
                        <!-- <td></td> -->
                        <td>{{ getMonthName(dat.month) }}, {{ dat.year }}</td>
                        <td>
                            <input
                                class="form-control"
                                type="date"
                                :value="dat.deadline"
                                @change="updateDeadline(dat.id, $event.target.value)"
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row justify-content-center">
                <div class="col-md-12">
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
        data: Object,
    },

    data() {
        return {
            search: this.$props.filters?.search ?? '',
            selectedYear: '',
            yearOptions: [2025, 2026, 2027],
        };
    },

    methods: {
        generateDeadlines() {
            // Guard: do not send if no year is selected
            if (!this.selectedYear) {
                alert('Please select a year before generating monthly deadlines.');
                return;
            }

            this.$inertia.post(
                '/monthly_daily_deadlines/generate',
                { year: this.selectedYear },
                {
                    preserveScroll: true,
                    preserveState: false,
                    onSuccess: () => {
                        alert(`Monthly deadlines for ${this.selectedYear} generated successfully.`);
                    },
                    onError: (errors) => {
                        alert(errors?.message ?? 'An error occurred while generating deadlines.');
                    },
                }
            );
        },

        deleteEmployee(id) {
            const text = "WARNING!\nAre you sure you want to delete the employee special department?";
            if (confirm(text)) {
                this.$inertia.delete('/employee/special/department/delete/' + id);
            }
        },

        updateDeadline(recordId, newDeadline) {
            // Option 1: Using full URL (hardcoded)
            this.$inertia.patch(`/monthly_daily_deadlines/${recordId}`, {
                deadline: newDeadline,
            }, {
                preserveScroll: true,  // keep scroll position
                onSuccess: () => {
                console.log('Deadline updated successfully');
                },
                onError: (errors) => {
                console.error('Update failed:', errors);
                },
            });

            // Option 2: Using named route with Ziggy (recommended)
            // this.$inertia.patch(route('monthly_daily_deadlines.update', recordId), {
            //   deadline: newDeadline,
            // });
        },
    },
};
</script>
