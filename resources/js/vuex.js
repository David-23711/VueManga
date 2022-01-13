import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import adminLogin from './modules/adminLogin'

Vue.use(Vuex);
const store = new Vuex.Store({
 modules: {
     adminLogin
 },
 plugins:[
     createPersistedState({
         key:['setAdmin'],
         paths:['adminLogin.adminData'],
         storage:{
             getItem:(key)=>localStorage.getItem(key),
             setItem:(key,value)=>localStorage.setItem(key,value),
             removeItem:(key)=>localStorage.removeItem(key)
         }
     })
 ],
})
export default store;