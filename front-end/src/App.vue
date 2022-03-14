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
    <router-link to="/">Home</router-link>
    |
    <router-link to="/about">About</router-link>
    |
    <router-link to="/login">Login</router-link>
    |
    <router-link to="/list">List</router-link>
    |
    <router-link to="/logout" @click="logout">Logout</router-link>
  </nav>
  <router-view/>
</template>

<script>
import Cookie from 'js-cookie';

export default {
  name: "LogoutComponent",
  methods: {
    logout: function () {
      this.axios({
        method: 'post',
        url: 'http://127.0.0.1:4000/api/logout',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + Cookie.get('_to_do_token')
        }
      }).then(() => {
        Cookie.remove('_to_do_token');
        this.$router.replace('/login');
      }).catch(function (error) {
        console.log(error);
      });

    },
  }
}
</script>
