import Profile from "@views/management/Profile";
import CampaignCreate from "@views/management/CampaignCreate";
import CampaignEdit from "@views/management/CampaignEdit";
import EmailVerification from "@views/management/EmailVerification";

export default [
    {
        path: "/user/profile",
        name: "Profile",
        component: Profile,
        meta: {
            authRequired: true
        }
    },
    {
        path: "/user/campaigns/create",
        name: "CampaignCreate",
        component: CampaignCreate,
        meta: {
            authRequired: true
        }
    },
    {
        path: "/user/campaigns/:id/edit",
        name: "CampaignEdit",
        component: CampaignEdit,
        meta: {
            authRequired: true
        }
    },
    {
        path: "/user/verify-email",
        name: "EmailVerification",
        component: EmailVerification,
        meta: {
            authRequired: true
        }
    }
];

