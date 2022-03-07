require("./bootstrap");
import Vue from "vue";
import VueRouter from "vue-router";
import { routes } from "./routes";
Vue.use(VueRouter);

import User from "./Helpers/User";
window.User = User;

// sweet alert start ------------------------------------------
import Swal from "sweetalert2";
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});
window.Toast = Toast;

import Notification from "./Helpers/Notification"; 
window.Notification = Notification;

window.Reload = new Vue();

const router = new VueRouter({
    mode: "history",
    routes,
});
const app = new Vue({
    el: "#app",
    router,
});
