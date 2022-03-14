<style scoped>
.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}

.form-signin .checkbox {
  font-weight: 400;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

.bg-green {
  background-color: #42b983;
  color: #FFF;
}

.color-green {
  color: #42b983;
}

</style>

<template>
  <main class="form-signin">
    <form @submit.stop.prevent="submit">
      <!--      <img class="mb-4" src="/docs/5.1/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">-->
      <h1 class="h3 mb-3 fw-normal color-green">Login</h1>

      <div class="form-floating">
        <input
            v-model="email"
            type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Email</label>
      </div>
      <div class="form-floating">
        <input
            v-model="password"
            type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Senha</label>
      </div>

      <button class="w-100 btn btn-lg bg-green btn-outline-success" type="submit">Entrar</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
    </form>
  </main>
</template>

<script>
import Cookie from 'js-cookie';

export default {
  name: "LoginView",
  data() {
    return {
      email: '',
      password: '',
    };
  },
  methods: {
    submit: function () {
      const $payload = {
        email: this.email,
        password: this.password,
      };
      this.axios({
        method: 'post',
        url: 'http://127.0.0.1:4000/api/login',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + Cookie.get('_to_do_token')
        },
        data: JSON.stringify($payload)
      }).then((response) => {
        Cookie.set('_to_do_token', response.data.access_token);
        this.$router.replace('/about');
      }).catch(function (error) {
        console.log(error);
      });
    },
  }
}
</script>