<template>
    <div class="accordion" v-bind:class="theme">
        <div class="header" v-on:click="toggle">
            <slot name="header"></slot>
            <i class="fa fa-2x fa-angle-down header-icon" v-bind:class="{ rotate: show }"></i>
        </div>
        <transition name="accordion" v-on:before-enter="beforeEnter" v-on:enter="enter" v-on:before-leave="beforeLeave"
            v-on:leave="leave">
            <div class="body" v-show="show">
                <div class="body-inner">
                    <slot></slot>
                </div>
            </div>
        </transition>
    </div>
</template>
<script>
export default {
    data() {
        return {
            show: false
        };
    },

    methods: {
        toggle: function () {
            this.show = !this.show;
        },

        beforeEnter: function (el) {
            el.style.height = '0';
        },
        enter: function (el) {
            el.style.height = el.scrollHeight + 'px';
        },
        beforeLeave: function (el) {
            el.style.height = el.scrollHeight + 'px';
        },
        leave: function (el) {
            el.style.height = '0';
        }
    }
}
</script>
