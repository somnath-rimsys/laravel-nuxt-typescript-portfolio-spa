import { ActionTree, GetterTree, MutationTree, Commit } from 'vuex'
import Cookies from 'js-cookie'

export interface State {
  isLogedIn: boolean,
  token: string|null,
  user: object|null
}

export const state = () => {
  return {
    isLogedIn: false,
    token: null,
    user: null
  }
}

export const mutations: MutationTree<State> = {
  setToken (state: State, payload: any) {
    state.isLogedIn = true
    state.token = payload.token
    Cookies.set('auth_token', payload.token, { expires: 7 })
  },
  clearToken (state: State) {
    state.isLogedIn = false
    state.token = null
    state.user = null
    Cookies.remove('auth_token')
  },
  setUser (state: State, payload: any) {
    state.user = payload
  }
}

export const actions: ActionTree<State, State> = {
  login ({ commit }: { commit: Commit}, payload: any): void {
    commit('setToken', payload)
  },
  register ({ commit }: { commit: Commit}, payload) {
    commit('setToken', payload)
  },
  logout ({ commit }: { commit: Commit}) {
    commit('clearToken')
  }
}

export const getters: GetterTree<State, State> = {
  getToken (state: State) {
    return state.token
  },
  getAuthStatus (state: State) {
    return state.isLogedIn
  },
  getUser (state: State) {
    return state.user
  }
}
