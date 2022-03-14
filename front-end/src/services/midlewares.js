import Cookie from "js-cookie";
export default {
    auth(to, from, next) {
        const token = Cookie.get('_to_do_token');

        if (!token) {
            next('/login');
        }

        next();
    },
    blockLogin(to, from, next) {
        const token = Cookie.get('_to_do_token');

        if (token) {
            next('/');
        }

        next();
    }
};