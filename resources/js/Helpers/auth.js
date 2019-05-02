import HTTP from "@js/Common/Http.service"

export const checkAdmin = () => {
    return new Promise((resolve, reject) => {
       HTTP.POST("/user/is_admin")
           .then(() => resolve())
           .catch(() => reject());
    });
};