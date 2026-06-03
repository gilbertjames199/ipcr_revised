<template>
    <div class="row gap-20">
        <div class="col-md-12">
            <h2><b> {{ pageTitle }} Coaching Report Form</b></h2>

            <form @submit.prevent="submit">

                <!-- Header -->
                <fieldset class="border p-4 mb-3">
                    <legend class="float-none w-auto">
                        <b>Employee Information</b>
                    </legend>

                    <div class="row">
                        <div class="col-md-4">
                            <label>Date</label>
                            <input
                                type="date"
                                v-model="form.date"
                                class="form-control"
                            >
                        </div>

                        <div class="col-md-4">
                            <label>Name of Coachee</label>
                            <input
                                type="text"
                                v-model="form.coachee_name"
                                class="form-control"
                                readonly
                            >
                        </div>

                    </div>
                </fieldset>

                <!-- Critical Incident -->
                <fieldset class="border p-4 mb-3">
                    <legend class="float-none w-auto">
                        <b>Critical Incident Description</b>
                    </legend>

                    <textarea
                        rows="5"
                        v-model="form.critical_incident"
                        class="form-control"
                        placeholder="Describe actual events and behaviors..."
                    ></textarea>
                </fieldset>

                <!-- Goals -->
                <fieldset class="border p-4 mb-3">
                    <legend class="float-none w-auto">
                        <b>Goals</b>
                    </legend>

                    <textarea
                        rows="4"
                        v-model="form.goals"
                        class="form-control"
                        placeholder="What the coachee wants to achieve"
                    ></textarea>
                </fieldset>

                <!-- Reality -->
                <fieldset class="border p-4 mb-3">
                    <legend class="float-none w-auto">
                        <b>Reality</b>
                    </legend>

                    <textarea
                        rows="4"
                        v-model="form.reality"
                        class="form-control"
                        placeholder="Current situation and challenges"
                    ></textarea>
                </fieldset>

                <!-- Opportunities -->
                <fieldset class="border p-4 mb-3">
                    <legend class="float-none w-auto">
                        <b>Opportunities</b>
                    </legend>

                    <textarea
                        rows="4"
                        v-model="form.opportunities"
                        class="form-control"
                        placeholder="Possible solutions and remedies"
                    ></textarea>
                </fieldset>

                <!-- Way Forward -->
                <fieldset class="border p-4 mb-3">
                    <legend class="float-none w-auto">
                        <b>Way Forward</b>
                    </legend>

                    <textarea
                        rows="4"
                        v-model="form.way_forward"
                        class="form-control"
                        placeholder="Actions to be executed"
                    ></textarea>
                </fieldset>

                <!-- Follow-up Session -->
                <fieldset class="border p-4 mb-3">
                    <legend class="float-none w-auto">
                        <b>Follow-Up Coaching Session</b>
                    </legend>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Follow-up Date</label>
                            <input
                                type="date"
                                v-model="form.followup_date"
                                class="form-control"
                            >
                        </div>

                        <div class="col-md-6">
                            <label>Follow-up Time</label>
                            <input
                                type="time"
                                v-model="form.followup_time"
                                class="form-control"
                            >
                        </div>
                    </div>

                    <label class="mt-3">
                        Improved behavior, competency, development,
                        growth or new skills
                    </label>

                    <textarea
                        rows="4"
                        v-model="form.followup_notes"
                        class="form-control"
                    ></textarea>
                </fieldset>

                <!-- Supervisor -->
                <fieldset class="border p-4 mb-3">
                    <legend class="float-none w-auto">
                        <b>Supervisor Information</b>
                    </legend>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Supervisor Name</label>
                            <input
                                type="text"
                                v-model="form.supervisor_name"
                                class="form-control"
                                readonly
                            >
                        </div>

                        <div class="col-md-6">
                            <label>Position</label>
                            <input
                                type="text"
                                v-model="form.supervisor_position"
                                class="form-control"
                                readonly
                            >
                        </div>
                    </div>
                </fieldset>

                <button
                    type="submit"
                    class="btn btn-primary text-white"
                >
                    Save
                </button>

            </form>
        </div>
    </div>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";

export default {

    props: {
        sem: Object,
        auth: Object,
        immediate_head: String,
        immediate_position: String,
        coachee_name: String,
        emp_code: String,
        semester: String,
        year: String,
        month: String,
        editData: Object,
    },
    data() {
        return {
            form: useForm({
                date: new Date().toISOString().split('T')[0],
                coachee_name: this.coachee_name ?? "",
                critical_incident: "",
                goals: "",
                reality: "",
                opportunities: "",
                way_forward: "",
                followup_date: "",
                followup_time: "",
                followup_notes: "",

                supervisor_name: this.immediate_head ?? "",
                supervisor_position: this.immediate_position ?? "",
                emp_code: this.emp_code ?? "",
                month: this.month ?? "",
                year: this.sem?.[0]?.year ?? "",
                sem: this.sem?.[0]?.sem ?? "",
                department_code: this.auth?.user?.department_code ?? "",
            }),
            pageTitle: "",
        };
    },
    mounted() {
    this.form.month = this.month;
    this.form.department_code = this.auth?.user?.department_code;

    this.form.emp_code = this.emp_code;
        if (this.editData !== undefined) {
            if (this.bari) {
                this.bar = this.bari
            }
            this.pageTitle = "Edit"
            this.form.date = this.editData.date
            this.form.coachee_name = this.editData.employee_name
            this.form.critical_incident = this.editData.critical_incidence_description
            this.form.goals = this.editData.goal
            this.form.reality = this.editData.reality
            this.form.opportunities = this.editData.opportunities
            this.form.way_forward = this.editData.way_forward
            this.form.followup_date = this.editData.follow_up_date
            this.form.followup_time = this.editData.follow_up_time
            this.form.followup_notes = this.editData.way_forward
            this.form.supervisor_name = this.editData.coach_name
            this.form.supervisor_position = this.editData.position
            this.form.sem_id = this.editData.sem_id
            this.form.id = this.editData.id

            } else {
            this.pageTitle = "Create"
            this.form.date = new Date().toISOString().substr(0, 10);
        }
},

    methods: {
        submit() {
console.log(this.form);
            this.form.post("/coaching-report/store");
            if (this.editData !== undefined) {
                    this.form.patch("/coaching-report/" + this.form.id, this.form);
                } else {
                    // alert("Sample");
                    var url = "/coaching-report/store"
                    // alert('for store '+url);
                    this.form.post(url);
                }
        }
    }
};
</script>
