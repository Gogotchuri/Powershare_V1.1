import Profile from "@views/user/Profile";
import Campaigns from "@views/user/campaigns/Campaigns"
import CampaignCreate from "@views/user/campaigns/CampaignCreate";
import CampaignEdit from "@views/user/campaigns/CampaignEdit";
import EmailVerification from "@views/user/EmailVerification";
import Index from "@/views/user/Index";
import ShowSurvey from "@views/user/surveys/ShowSurvey";
import PageNotFound from "@views/public/errors/PageNotFound";


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
            },
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
    },
    {
        path: "/user/survey",
        name: "User.Survey",
        component: ShowSurvey,
        meta: {
            authRequired: true
        }
    }
];

