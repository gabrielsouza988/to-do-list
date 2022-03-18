<!--<template>-->
<!--  <main class="form-signin">-->
<!--    <form @submit.stop.prevent="submit">-->
<!--      &lt;!&ndash;      <img class="mb-4" src="/docs/5.1/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">&ndash;&gt;-->
<!--      <h1 class="h3 mb-3 fw-normal color-green">Login</h1>-->

<!--      <div class="form-floating">-->
<!--        <input-->
<!--            v-model="email"-->
<!--            type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">-->
<!--        <label for="floatingInput">Email</label>-->
<!--      </div>-->
<!--      <div class="form-floating">-->
<!--        <input-->
<!--            v-model="password"-->
<!--            type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">-->
<!--        <label for="floatingPassword">Senha</label>-->
<!--      </div>-->

<!--      <button class="w-100 btn btn-lg bg-green btn-outline-success" type="submit">Entrar</button>-->
<!--      <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>-->
<!--    </form>-->
<!--  </main>-->
<!--</template>-->

<script>
import Cookie from 'js-cookie';

export default {
  name: "LogoutComponent",
  methods: {
    logout: function () {
      // axios
      //     .post('http://127.0.0.1:4000/api/logut')
      //     .then(response => {
      //       this.info = response.data.bpi
      //       Cookie.delete('_to_do_token');
      //     })
      //     .catch(error => {
      //       console.log(error)
      //       this.errored = true
      //     })
      //     .finally(() => this.loading = false)
      fetch('http://127.0.0.1:4000/api/logout', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer '+ Cookie.get('_to_do_token'),
        }
      }).then(response => response.json())
          .then(res => {
            console.log(res)
            Cookie.delete('_to_do_token');
            this.$router.go('/');
          });
    },
  }
}
</script>

<style scoped>

</style>