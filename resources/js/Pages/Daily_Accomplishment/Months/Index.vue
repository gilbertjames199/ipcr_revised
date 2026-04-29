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
                        class="btn btn-success btn-sm text-white"
                        @click="generateDeadlines"
                    >
                        Generate Monthly Deadlines
                    </button>
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
            selectedYear: this.$props.filters?.year ?? '',  // ← restore from filters
            yearOptions: [2025, 2026, 2027],
        };
    },

    watch: {
        // ← fires whenever the year dropdown changes
        selectedYear(value) {
            this.$inertia.get(
                '/monthly_daily_deadlines',
                { year: value || null },    // send null to clear the filter
                {
                    preserveScroll: true,
                    preserveState: true,    // keeps other UI state intact
                    replace: true,          // replaces browser history entry
                }
            );
        },
    },

    methods: {
        getMonthName(month) {
            const months = [
                'January','February','March','April','May','June',
                'July','August','September','October','November','December'
            ];
            return months[month - 1] ?? month;
        },

        generateDeadlines() {
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

        updateDeadline(recordId, newDeadline) {
            this.$inertia.patch(`/monthly_daily_deadlines/${recordId}`, {
                deadline: newDeadline,
            }, {
                preserveScroll: true,
                onSuccess: () => {
                    console.log('Deadline updated successfully');
                },
                onError: (errors) => {
                    console.error('Update failed:', errors);
                },
            });
        },
    },
};
</script>
