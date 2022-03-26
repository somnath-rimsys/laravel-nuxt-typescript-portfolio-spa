import { MutationTree, ActionTree, Commit, GetterTree } from 'vuex'

export const state = () => {
  return {
    experiences: []
  }
}

export type State = ReturnType<typeof state>

export const mutations: MutationTree<State> = {
  setExperience (state: State, payload: any) {
    state.experiences = payload
  }
}

export const actions: ActionTree<State, State> = {
  updateExperience ({ commit }: { commit:Commit }, payload: any) {
    commit('setExperience', payload)
  }
}

export const getters: GetterTree<State, State> = {
  getExperience (state: State) {
    return state.experiences
  }
}
