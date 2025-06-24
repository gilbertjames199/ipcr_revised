<template>
    <div>
        <Sidebar></Sidebar>
        <div class="page-container">

            <Notification></Notification>

            <Nav></Nav>

            <!-- <Loading :active="$isLoading" :is-full-page="true" /> -->

            <main class="main-content bgc-grey-100">
                <div id="mainContent">
                    <slot></slot>
                </div>
            </main>

            <Footer></Footer>
        </div>
    </div>
</template>
<script>
import Nav from "@/Shared/Nav";
import Footer from "@/Shared/Footer";
import Sidebar from "@/Shared/Sidebar.vue";
import { inject } from 'vue'

export default {
    components: {
        Nav,
        Footer,
        Sidebar,
    },
    data() {
        return {
        // loading: false
        }
    },
    // setup() {
    //     const isLoading = inject('isLoading')
    //     return { isLoading }
    // }
    // provide() {
    //     // Allow child components to access a global loading toggle
    //     return {
    //     showLoading: () => this.loading = true,
    //     hideLoading: () => this.loading = false
    //     }
    // }
};
</script>
