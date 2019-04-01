import {STORAGE_USER_INSTANCE, JWT_TOKEN_TITLE} from "@js/Common/config";

export const getToken = () => {
    let userInstance = window.localStorage.getItem(STORAGE_USER_INSTANCE);
    let token = "";
    if(userInstance !== null) {
        userInstance = JSON.parse(userInstance);
        token = userInstance[JWT_TOKEN_TITLE];
        token = token ? token : "";
    }
    return token;
};

export const getUser = () => {
    let userInstance = window.localStorage.getItem(STORAGE_USER_INSTANCE);
    if(!userInstance) return null;
    return JSON.parse(userInstance);
};

export const storeUser = (user) => {
    window.localStorage.setItem(STORAGE_USER_INSTANCE, JSON.stringify(user));
};

export const destroyUser = () => {
    window.localStorage.removeItem(STORAGE_USER_INSTANCE);
};

export default { getToken, getUser, storeUser, destroyUser};
