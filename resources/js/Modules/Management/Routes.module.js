import Profile from "@views/management/Profile";
import CampaignCreate from "@views/management/CampaignCreate";
import CampaignEdit from "@views/management/CampaignEdit";

export default [
    {
        path: "/profile",
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
    }
];

