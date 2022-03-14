<style scoped>
.bg-green {
  background-color: #42b983;
  color: #FFF;
}

.color-green {
  color: #42b983;
}

.list {
  padding: 0;
  max-width: 90%;
  margin: 0 auto;

}

.list > li {
  padding: 0;
}

/*.wrapper {*/
/*  display: flex;*/
/*  gap: 0.5rem 1rem;*/
/*  max-width: 90%;*/
/*  margin: 0 auto 16px;*/
/*}*/
/*.title {*/
/*  color: $blue-700;*/
/*  margin-bottom: 16px;*/
/*}*/
/*.input {*/
/*  margin: 0;*/
/*  display: block;*/
/*  flex: 1;*/
/*  padding: 0.5rem;*/
/*  padding-left: 0.2rem;*/
/*  color: $blue-100;*/
/*  background: $blue-1000;*/
/*  outline: none;*/
/*  border: 2px solid $blue-700;*/
/*  border-radius: 4px;*/
/*  &:focus-visible,*/
/*  &:hover {*/
/*    box-shadow: 0 0 0 2px $blue-400;*/
/*    border-color: $blue-500;*/
/*  }*/
/*}*/
/*.button {*/
/*  padding: 8px 16px;*/
/*  border: none;*/
/*  background: $blue-900;*/
/*  color: $blue-200;*/
/*  font-weight: 550;*/
/*}*/
</style>

<template>
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

  <ul class="list">
    <ListItem/>
    {{ listTasks }}
  </ul>
  <p>You don't have any tasks yet.</p>
</template>

<script>
import Cookie from 'js-cookie';

export default {
  name: "ListView",
  data() {
    return {
      task: '',
      date: '',
      modulos: []
    };
  },
  methods: {
    addTask: function () {
      const $payload = {
        task: this.task,
        date: this.date,
      }
      this.axios({
        method: 'post',
        url: 'http://127.0.0.1:4000/api/taskCreate',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + Cookie.get('_to_do_token')
        },
        data: JSON.stringify($payload)
      }).then((response) => {
        // console.log(response);
        this.modulos = response.data;
      }).catch(function (error) {
        console.log(error);
      });
    }
  },
  computed: {
    listTasks: function () {
      this.axios({
        method: 'get',
        url: 'http://127.0.0.1:4000/api/list-tasks',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + Cookie.get('_to_do_token')
        }
      }).then((response) => {
        console.log(response);
      }).catch(function (error) {
        console.log(error);
      });
    }
  }
}
</script>

