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
<!--    <router-link to="/task" v-show="this.logoff">-->
<!--      List-->
<!--      |-->
<!--    </router-link>-->

    <router-link to="/logout" v-show="this.logoff" @click="logout">
      Logout
    </router-link>
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
      Cookie.remove('_to_do_token');
      this.$router.replace('/');
      this.logoff = false;
      this.login = true;
    },
  },
  mounted() {
    this.logoff = Cookie.get('_to_do_token') ? true : false;
    console.log(Cookie.get('_to_do_token') ? true : false)
  }
}
</script>
