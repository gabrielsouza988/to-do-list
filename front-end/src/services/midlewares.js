import Cookie from "js-cookie";
import {urlApi} from "@/main";
import axios from "axios";

export default {
    auth(to, from, next) {
        const token = Cookie.get('_to_do_token');
        if (!token) {
            next('/login');
        }

        axios({
            method: 'POST',
            url: urlApi + "refresh",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token
            }
        }).then((response) => {
            Cookie.set('_to_do_token', response.data.access_token);
        }).catch(function (error) {
            console.log(error);
        });

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