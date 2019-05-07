import Dashboard from "@/views/admin/Dashboard";
import Index from "@views/admin/Index";
import Campaigns from "@/views/admin/campaigns/Campaigns";
import Users from "@/views/admin/Users";
import Campaign from "@/views/admin/campaigns/Campaign";
import FAQQuestions from "@/views/admin/FAQQuestions";

export default [
    {
        path: "/admin",
        component: Index,
        meta: {
            authRequired: true,
            adminRequired: true
        },
        children:[
            {
                path: "",
                name: "Admin.Dash",
                component: Dashboard
            },
            {
                path: "campaigns",
                name: "Admin.Campaigns",
                component: Campaigns,
                children: [
                    {
                        path: ":id",
                        name: "Admin.Campaign",
                        component: Campaign
                    }
                ]
            },
            {
                path: "users",
                name: "Admin.Users",
                Component: Users
            },
            {
                path: "FAQ",
                name: "Admin.FAQ",
                component: FAQQuestions
            }
        ]
    }
];