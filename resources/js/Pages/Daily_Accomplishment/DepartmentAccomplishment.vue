<template>

    <Head>
        <title>Department Daily Accomplishments</title>
    </Head>
    <div class="row gap-20 masonry pos-r">
        <div class="peers fxw-nw jc-sb ai-c">
            <h3>Daily Accomplishment</h3>
            <div class="peers">

            </div>
        </div>
        <div class="masonry-item w-100">
            <div class="bgc-white p-20 bd">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless table-striped table-hover">
                        <thead>
                            <tr style="background-color: #B7DEE8;">
                                <th></th>
                                <th>Date</th>
                                <th>Employee</th>
                                <th>Individual Output</th>
                                <th>Accomplishment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="dat in data.data">
                                <td></td>
                                <td>{{ dat.date }}</td>
                                <td>{{ dat.user_employee.employee_name }}</td>
                                <td>
                                    {{
                                        (dat.individual_final_output?.performance_measure || '') +
                                        (dat.individual_output ? ' ' + dat.individual_output : '')
                                    }}
                                </td>
                                <td>{{ dat.description }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <!-- <Pagination_Preserved :links="data.links" /> -->
                        <pagination :next="data.next_page_url" :prev="data.prev_page_url" />
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <p>
                            {{ data.from }} to {{ data.to }} of
                            {{ data.total }} entries
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- {{ data }} -->
    </div>
</template>
<script>
import Pagination from "@/Shared/Pagination";
export default {
    props: {
        auth: Object,
        data: Object,
    },
    data() {
        return {}
    },
    components: {
        Pagination
    }
}
</script>
