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
          <h1 class="h3 mb-3 fw-normal color-green">Cadastro</h1>
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

        <div class="row mb-2">
          <div class="col-md-12">
            <div class="form-floating">
              <input
                  v-model="name"
                  type="text" name="name" class="form-control" id="floatingInput" placeholder="name">
              <label for="floatingInput">Nome</label>
            </div>
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-12">
            <div class="form-floating">
              <input
                  v-model="email"
                  type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
              <label for="floatingInput">Email</label>
            </div>
          </div>
        </div>

        <div class="row mb-2">
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
            <router-link to="/" class="mt-5 mb-3 text-muted">Já tem conta? clique aqui!</router-link>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <button class="w-100 btn btn-lg bg-green btn-outline-success" type="submit">Cadastrar</button>
          </div>
        </div>
      </div>
    </form>
  </main>
</template>

<script>
// import Cookie from 'js-cookie';
import {urlApi} from "@/main";
import LoadingComponent from "@/components/LoadingComponent.vue";

export default {
  name: "RegisterView",
  data() {
    return {
      email: '',
      password: '',
      name: '',
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
        name: this.name,
      };
      this.errors = [];
      if (!payload.email) {
        this.errors.push('O email é obrigatório.');
      }
      if (!payload.name) {
        this.errors.push('O nome é obrigatório.');
      }
      if (!payload.password) {
        this.errors.push('A senha é obrigatória.');
      }

      this.axios({
        method: 'post',
        url: urlApi + 'register',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        data: JSON.stringify(payload)
      }).then((response) => {
        console.log(response);
        this.$router.replace('/');
      }).catch(function (error) {
        console.log(error);
      });
      this.showLoading = false;
    },
  },
  mounted() {
    this.errors = [];
  }
}
</script>