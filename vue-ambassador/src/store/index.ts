import Vue from 'vue'
import { User } from '@/models/user'
import {Commit, createStore} from 'vuex'
 
export default createStore({
  state: {
    user: new User()
  },
  mutations: {
    SET_USER( state: { user: User }, user: User ){
        state.user = user;
    }
  },
  actions: {
    setUser({commit}: {commit: Commit} , user: User) {
      return commit('SET_USER', user);
    }
  }
})
