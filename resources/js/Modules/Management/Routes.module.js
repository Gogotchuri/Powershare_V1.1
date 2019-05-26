import Profile from "@views/management/Profile";
import Campaigns from "@views/management/campaigns/Campaigns"
import CampaignCreate from "@views/management/campaigns/CampaignCreate";
import CampaignEdit from "@views/management/campaigns/CampaignEdit";
import EmailVerification from "@views/management/EmailVerification";
import Index from "@/views/management/Index";


export default [
    {
        path: "/user",
        component: Index,
        meta: {
            authRequired: true,
            userManagement: true
        },
        children:[
            {
                path: "profile",
                name: "User.Profile",
                component: Profile
            },
            {
                path: "campaigns",
                name: "User.Campaigns",
                component: Campaigns
            },
            {
                path: "verify-email",
                name: "User.EmailVerification",
                component: EmailVerification,
            }
        ]
    },
    {
        path: "/user/campaigns/create",
        name: "User.Campaigns.Create",
        component: CampaignCreate,
        meta: {
            authRequired: true
        },
    },
    {
        path: "/user/campaigns/:id/edit",
        name: "User.Campaigns.Edit",
        component: CampaignEdit,
        meta: {
            authRequired: true
        },
    }
];

