import Dashboard from "@/views/admin/Dashboard";
import Index from "@views/admin/Index";
import Users from "@/views/admin/Users";
import Campaign from "@/views/admin/campaigns/Campaign";
import FAQQuestions from "@/views/admin/FAQQuestions";
import CreateSurvey from "@views/admin/surveys/CreateSurvey";
import EditSurvey from "@views/admin/surveys/EditSurvey";
import Surveys from "@views/admin/surveys/Surveys";
import CampaignEdit from "@views/shared/campaigns/CampaignEdit";
import Campaigns from "@views/shared/campaigns/Campaigns";

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
                component: Campaigns
            },
            {
                path: "campaigns/:id",
                name: "Admin.Campaigns.Show",
                component: Campaign
            },
            {
                path: "campaigns/:id/edit",
                name: "Admin.Campaigns.Edit",
                component: CampaignEdit
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
            },
            {
              path: "surveys",
              name: "Admin.Surveys",
              component: Surveys
            },
            {
                path: "surveys/create",
                name: "Admin.CreateSurvey",
                component: CreateSurvey
            },
            {
                path: "surveys/:id",
                name: "Admin.EditSurvey",
                component: EditSurvey
            }
        ]
    }
];