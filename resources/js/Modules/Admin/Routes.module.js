import Index from "@views/admin/Index";

export default [
    {
        path: "/admin",
        name: "AdminIndex",
        component: Index,
        meta: {
            authRequired: true,
            adminRequired: true
        }
    }
];