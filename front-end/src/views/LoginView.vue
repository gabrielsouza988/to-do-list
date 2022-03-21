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
      <div class="row">
        <div class="col-md-12">
          <h1 class="h3 mb-3 fw-normal color-green">Login</h1>
        </div>
      </div>

      <div class="row" v-if="errors.length">
        <div class="col-md-12">
          <p>
            <b>Por favor, corrija o(s) seguinte(s) erro(s):</b>
          <ul>
            <li v-for="error in errors" :key="error">{{ error }}</li>
          </ul>
          </p>
        </div>
      </div>

      <div class="row mt-3 mb-3" v-show="this.showLoading">
        <div class="col-md-12 d-flex justify-content-center">
          <LoadingComponent/>
        </div>
      </div>

      <div class="form" v-show="!this.showLoading">
        <div class="row">
          <div class="col-md-12">
            <div class="form-floating">
              <input
                  v-model="email"
                  type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
              <label for="floatingInput">Email</label>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="form-floating">
              <input
                  v-model="password"
                  type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
              <label for="floatingPassword">Senha</label>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <router-link to="/register" class="mt-5 mb-3 text-muted">cadastrar</router-link>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <button class="w-100 btn btn-lg bg-green btn-outline-success" type="submit">Entrar</button>
          </div>
        </div>
      </div>
    </form>
  </main>
</template>

<script>
import Cookie from 'js-cookie';
import {urlApi} from "@/main";
import LoadingComponent from "@/components/LoadingComponent.vue";

export default {
  name: "LoginView",
  data() {
    return {
      email: '',
      password: '',
      errors: [],
      showLoading: false
    };
  },
  components: {
    LoadingComponent
  },
  methods: {
    submit: function () {
      this.showLoading = true;

      const payload = {
        email: this.email,
        password: this.password,
      };
      this.errors = [];
      if (!payload.email) {
        this.errors.push('O email é obrigatório.');
      }
      if (!payload.password) {
        this.errors.push('A senha é obrigatória.');
      }
      this.axios({
        method: 'post',
        url: urlApi + 'login',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + Cookie.get('_to_do_token')
        },
        data: JSON.stringify(payload)
      }).then((response) => {
        if (response.data.error) {
          this.errors.push('E-mail ou senha invalidos!');
          return;
        }
        Cookie.set('_to_do_token', response.data.access_token);
        this.$router.replace('/task');
        this.login = false;
        this.logoff = true;
      }).catch(function (error) {
        if (error.response.data.errors) {
          this.errors.push('E-mail ou senha invalidos!');
        }
      });
      this.showLoading = false;
    },
  },
  mounted() {
    this.errors = [];
  }
}
</script>