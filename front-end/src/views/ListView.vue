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

article.card:hover {
  background-color: #42b983;
  border: 2px solid #028d56;
  color: #FFF;
}

.remove:hover {
  color: #bb2d3b;
}

.description-card {
  margin-top: 5px;
  margin-left: 10px;
}
</style>

<template>
  <div class="container">

    <h1 class="title">To-do list</h1>

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
        <button class="btn  bg-green btn-outline-success" @click.prevent="addTask">Add item</button>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-md-12 d-flex justify-content-center">
        <LoadingComponent v-show="this.showLoading"/>
      </div>
    </div>

    <div class="row mt-3" v-show="!this.showLoading">
      <p v-show="this.showLists">Você não tem tarefas cadastradas.</p>
      <div class="col-md-4 mb-3" v-for="task in this.listTasks" :key="task.id" @click.prevent="redirectTask(task.id)">
        <article class="card">
          <span>
            <i class="fa-solid fa-list-check"></i>
            Tarefa:
          </span>
          <div class="description-card">
            <h2>{{ task.task }}</h2>
            <p>Data: {{ task.date }}</p>
            <div class="row">
              <div class="col-md-12">
                <div class="remove" @click.prevent="removeTask(task.id)">
                  <i class="fa-solid fa-trash-alt"></i>
                  <strong>Remover</strong>
                </div>
              </div>
            </div>
          </div>
        </article>
      </div>
    </div>

  </div>
</template>

<script>
import Cookie from 'js-cookie';
import {urlApi} from "@/main";
import LoadingComponent from '@/components/LoadingComponent.vue';

export default {
  name: "ListView",
  data() {
    return {
      task: '',
      date: '',
      listTasks: [],
      showLists: true,
      showDelete: true,
      showLoading: true
    }
  },
  components: {
    LoadingComponent
  },
  methods: {
    addTask: function () {
      const $payload = {
        task: this.task,
        date: this.date,
      }
      this.axios({
        method: 'post',
        url: urlApi + 'taskCreate',
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
        url: urlApi + "list-tasks",
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + Cookie.get('_to_do_token')
        }
      }).then((response) => {
        this.listTasks = response.data.tasks;
        this.showLoading = false;
        if (response.data.tasks.length > 0) {
          this.showLists = false;
        }
      }).catch(function () {
        this.listTasks = [{"task": "sem metodos", "id": 1}];
      });
    },
    redirectTask: function (id) {
      this.$router.replace('/task/' + id);
    },
    removeTask: function (id) {
      this.showLoading = true;

      this.axios({
        method: 'delete',
        url: urlApi + "removeTask/" + id,
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + Cookie.get('_to_do_token')
        },
      }).then((response) => {
        console.log(response);
        this.showDelete = false;
        this.showLoading = false;
        this.listTasks = this.tasks();
      }).catch(function () {
        this.listTasks = [{"task": "sem metodos", "id": 1}];
      });
      this.showLoading = false;
    }
  },
  mounted() {
    this.listTasks = this.tasks();
  }
}
</script>

