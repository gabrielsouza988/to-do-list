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
        <button class="btn  bg-green btn-outline-success" @click.prevent="addTask">Adicionar</button>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-md-4 mb-3" v-for="task in this.listTasks" :key="task.id">
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
            <p>Criado: {{ task.date_execution }}</p>
            <div class="row">
              <div class="col-md-12">
                <button class="btn btn-sm btn-danger"
                        @click.prevent="removeSecondaryTask(task.id)">
                  <i class="fa-solid fa-trash-alt"></i>
                </button>
                <button :class="task.status == '2' ? 'd-none' : 'btn btn-sm btn-success btn-check-task'"
                    @click.prevent="task.status == '2' ? '' : secondaryTaskUpdate(task.id)">
                  <i class="fa-solid fa-check"></i>
                </button>
              </div>
            </div>
          </div>
        </article>
      </div>
    </div>

    <p v-show="this.showLists">Você não tem itens cadastradas.</p>

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

export default {
  name: "ListView",
  data() {
    return {
      nameTask: '',
      task: '',
      date: '',
      listTasks: [],
      showLists: true,
      showDelete: true,
    }
  },
  methods: {
    addTask: function () {
      const $payload = {
        task: this.task,
        date: this.date,
      }
      this.axios({
        method: 'post',
        url: urlApi + 'secondaryTaskCreate/' + this.$route.params.id,
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + Cookie.get('_to_do_token')
        },
        data: JSON.stringify($payload)
      }).then((response) => {
        this.listTasks.push(response.data.task);
        this.showLists = false;
      }).catch(function (error) {
        console.log(error);
      });
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
        this.listTasks = response.data.tasksSecondary;
        this.nameTask = response.data.task.task;

        if (response.data.tasksSecondary.length > 0) {
          this.showLists = false;
        }
      }).catch(function () {
        this.listTasks = [{"task": "sem metodos", "id": 1}];
      });
    },
    secondaryTaskUpdate: function (id) {
      const $payload = {
        status: '2',
      }
      this.axios({
        method: 'put',
        url: urlApi + "secondaryTaskUpdate/" + id,
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + Cookie.get('_to_do_token')
        },
        data: JSON.stringify($payload)
      }).then((response) => {
        console.log(response);
        this.showComplete = false;
        this.listTasks = response.data.allTasks;
      }).catch(function () {
        this.listTasks = [{"task": "sem metodos", "id": 1}];
      });
    },
    removeSecondaryTask: function (id) {
      this.axios({
        method: 'delete',
        url: urlApi + "removeSecondaryTask/" + id,
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + Cookie.get('_to_do_token')
        },
      }).then((response) => {
        console.log(response);
        this.showDelete = false;
        this.listTasks = response.data.secondaryTask;
      }).catch(function () {
        this.listTasks = [{"task": "sem metodos", "id": 1}];
      });

    },
    listTasksRoute: function () {
      this.$router.replace('/task/');
    }
  },
  mounted() {
    this.listTasks = this.tasks();
    this.nameTask = this.tasks();
  }
}
</script>

