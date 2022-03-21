<template>
  <nav>
    <router-link to="/logout" @click="logout">
      Sair
    </router-link>
  </nav>
</template>

<script>
import Cookie from 'js-cookie';

export default {
  name: "LogoutComponent",
  methods: {
    logout: function () {
      Cookie.remove('_to_do_token');
      this.$router.replace('/');
    }
  }
}
</script>

<style scoped>

</style>