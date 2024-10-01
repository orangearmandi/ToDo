// src/router.js
import Vue from 'vue';
import Router from 'vue-router';
import NoteCreate from './components/NoteCreate.vue';
import NoteEdit from './components/NoteEdit.vue';
import NoteList from './components/NoteList.vue';

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/',
      name: 'NoteList',
      component: NoteList
    },
    {
      path: '/create',
      name: 'NoteCreate',
      component: NoteCreate
    },
    {
      path: '/edit/:id',
      name: 'NoteEdit',
      component: NoteEdit
    }
  ]
});
