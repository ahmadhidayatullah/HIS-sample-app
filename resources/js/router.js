// src/router.js or src/router/index.js
import { createRouter, createWebHistory } from "vue-router";
import LiveQueue from "@/components/LiveQueue.vue"; // Adjust the path to your component
import LoginPage from "@/components/Login.vue"; // Adjust the path to your component
import BaseLayout from "@/components/BaseLayout.vue";

const routes = [
    {
        path: "/",
        name: "BaseLayout",
        component: BaseLayout,
        
    },
    {
        path: "/live-queue",
        name: "LiveQueue",
        component: LiveQueue,
    },
    {
        path: "/login",
        name: "Login",
        component: LoginPage,
    },
    // Add more routes here
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Navigation Guard
router.beforeEach((to, from, next) => {
    console.log(`Navigating from ${from.path} to ${to.path}`);
    next();
});

export default router;
