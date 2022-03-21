<style scoped>
.bg-green {
  background-color: #42b983;
  color: #FFF;
}

.list > li {
  padding: 0;
}

article.card {
  border: 1px solid #d0d0d0;
  background-color: #fff;
  cursor: pointer;
  overflow: auto;
  border-radius: 8px;
  box-shadow: 0 0 20px 1px #d0d0d0;
  text-align: left;
  padding: 1rem;
}

h2 {
  font-size: 1.5em;
}

p:first-of-type, p:last-of-type {
  font-weight: bold;
  overflow-wrap: break-word;
}

span {
  display: inline-block;
  margin-right: 2em;
}

.btn-check-task {
  margin-left: 5px;
}

.description-card {
  margin-top: 5px;
  margin-left: 10px;
}
</style>

<template>
  <div class="container">
    <h1 class="title">Lista dos itens da tarefa: </h1>
    <h5>{{ this.nameTask }}</h5>

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

    <div class="row d-flex justify-content-center">
      <div class="col-md-3">
        <div class="form-group">
          <label for="">Tarefa</label>
          <input
              type="text"
              class="form-control "
              name="task"
              id="todo-item"
              ref="todoInput"
              v-model="task"
          />
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="">Data</label>
          <input
              type="date"
              class="form-control "
              name="date"
              id="todo-item"
              ref="todoInput"
              v-model="date"
          />
        </div>
      </div>
    </div>

    <div class="row mt-2 d-flex justify-content-center">
      <div class="col-md-3">
        <button class="btn  bg-green btn-outline-success" @click.prevent="addItem">Adicionar</button>
      </div>
    </div>

    <div class="row mt-3 mb-3" v-show="this.showLoading">
      <div class="col-md-12 d-flex justify-content-center">
        <LoadingComponent />
      </div>
    </div>

    <div class="row mt-3" v-show="!this.showLoading">
      <p v-show="this.showLists">Você não tem itens cadastradas.</p>
      <div class="col-md-4 mb-3" v-for="task in this.listItems" :key="task.id">
        <article class="card">
          <span>
            <i class="fa-solid fa-list-check"></i>
            Item:
          </span>
          <div class="description-card">
            <h2>
              {{ task.task }}
              <i :class="task.status == '2' ? 'fa-solid fa-check text-success' : 'd-none' "></i>
            </h2>
            <p>Data: {{ formatDate(task.date_execution) }}</p>
            <div class="row">
              <div class="col-md-12">
                <button class="btn btn-sm btn-danger"
                        @click.prevent="removeItemTask(task.id)">
                  <i class="fa-solid fa-trash-alt"></i>
                </button>
                <button :class="task.status == '2' ? 'd-none' : 'btn btn-sm btn-success btn-check-task'"
                    @click.prevent="task.status == '2' ? '' : itemsTaskUpdate(task.id)">
                  <i class="fa-solid fa-check"></i>
                </button>
              </div>
            </div>
          </div>
        </article>
      </div>
    </div>


    <div class="row">
      <div class="col-md-12">
        <button class="btn bg-secondary text-white " @click.prevent="listTasksRoute">Voltar</button>
      </div>
    </div>
  </div>
</template>

<script>
import Cookie from 'js-cookie';
import {urlApi} from "@/main";
import LoadingComponent from '@/components/LoadingComponent.vue';
import moment from "moment";

export default {
  name: "ItemsTaskView",
  data() {
    return {
      nameTask: '',
      task: '',
      date: '',
      errors: [],
      listItems: [],
      showLists: true,
      showDelete: true,
      showLoading: true
    }
  },
  components: {
    LoadingComponent
  },
  methods: {
    addItem: function () {
      this.showLoading = true;
      const payload = {
        task: this.task,
        date: this.date,
      }
      this.errors = [];
      if (!payload.task) {
        this.errors.push('O nome do item é obrigatório.');
      }
      if (!payload.date) {
        this.errors.push('A data é obrigatória.');
      }
      this.axios({
        method: 'post',
        url: urlApi + 'itemTaskCreate/' + this.$route.params.id,
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + Cookie.get('_to_do_token')
        },
        data: JSON.stringify(payload)
      }).then((response) => {
        this.listItems.push(response.data.task);
        this.showLists = false;
      }).catch(function (error) {
        console.log(error);
      });
        this.showLoading = false;
    },
    tasks: function () {
      this.axios({
        method: 'get',
        url: urlApi + "task/" + this.$route.params.id,
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + Cookie.get('_to_do_token')
        }
      }).then((response) => {
        if (response.data.hasError) {
          return this.listItems = [{"task": "Error", "id": 1}];
        }
        this.listItems = response.data.itemsTask;
        this.nameTask = response.data.task.task;
        this.showLoading = false;
        if (response.data.itemsTask.length > 0) {
          this.showLists = false;
        }
      }).catch(function () {
        this.listItems = [{"task": "sem metodos", "id": 1}];
      });
    },
    itemsTaskUpdate: function (id) {
      this.showLoading = true;

      const payload = {
        status: '2',
      }
      this.axios({
        method: 'put',
        url: urlApi + "itemTaskUpdate/" + id,
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + Cookie.get('_to_do_token')
        },
        data: JSON.stringify(payload)
      }).then((response) => {
        console.log(response);
        this.showComplete = false;
        this.listItems = response.data.allTasks;
      }).catch(function () {
        this.listItems = [{"task": "sem metodos", "id": 1}];
      });
      this.showLoading = false;
    },
    removeItemTask: function (id) {
      this.showLoading = true;

      this.axios({
        method: 'delete',
        url: urlApi + "removeItemTask/" + id,
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + Cookie.get('_to_do_token')
        },
      }).then((response) => {
        console.log(response);
        this.showDelete = false;
        this.listItems = response.data.itemsTask;
      }).catch(function () {
        this.listItems = [{"task": "sem metodos", "id": 1}];
      });
      this.showLoading = false;
    },
    listTasksRoute: function () {
      this.$router.replace('/task/');
    },
    formatDate: function (value) {
      if (value) {
        return moment(String(value)).format('DD/MM/YYYY')
      }
    }
  },
  mounted() {
    this.listItems = this.tasks();
    this.errors = [];
  }
}
</script>

