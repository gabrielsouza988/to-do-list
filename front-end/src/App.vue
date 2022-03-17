<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>

<template>
  <nav>
    <router-link to="/login" v-show="this.login">
      Login
      |
    </router-link>

    <router-link to="/task">
      List
      |
    </router-link>

    <router-link to="/logout" v-show="this.logoff" @click="logout">Logout</router-link>
  </nav>
  <router-view/>
</template>

<script>
import Cookie from 'js-cookie';
// import {urlApi} from "@/main";

export default {
  name: "LogoutComponent",
  data() {
    return {
      login: true,
      logoff: true
    }
  },
  methods: {
    logout: function () {
      // this.axios({
      //   method: 'post',
      //   url: urlApi + 'logout',
      //   headers: {
      //     'Content-Type': 'application/json',
      //     'Accept': 'application/json',
      //     'Authorization': 'Bearer ' + Cookie.get('_to_do_token')
      //   }
      // }).then(() => {
      //   Cookie.remove('_to_do_token');
      //   this.$router.replace('/login');
      // }).catch(function (error) {
      //   console.log(error);
      // });
      Cookie.remove('_to_do_token');
      this.$router.replace('/login');
      this.logoff = false;
      this.login = true;
    },
  },
  mounted() {
    this.login = Cookie.get('_to_do_token') ? false : true;
    this.logoff = Cookie.get('_to_do_token') ? true : false;
  }
}
</script>
