import { createStore, Commit, Dispatch, ActionContext } from 'vuex';
const user = JSON.parse(localStorage.getItem('user') || 'null');

// Kiểu của state trong store
interface RootState {
  user: null,
  brands: null,
  figures: null,
  gears: null,
  colors: null,
}

export const store = createStore({
  state: {
    user: user,
    brands: null,
    figures: null,
    gears: null,
    colors: null,
  } as RootState, 

  modules: {},

  mutations: {
    setUser(state: RootState, user: any) {
      if (user !== null) {
        state.user = user;
        localStorage.setItem('user', JSON.stringify(user)); // Lưu vào Local Storage
      }
    },
    brands(state: RootState, brands: any ) {
      state.brands = brands;
    },
    figures(state: RootState, figures: any ) {
      state.figures = figures;
    },
    gears(state: RootState, gears: any ) {
      state.gears = gears;
    },
    colors(state: RootState, colors: any ) {
      state.colors = colors;
    },
  },

  actions: {
    userAction(context: ActionContext<RootState, RootState>, user: any) {
      context.commit('setUser', user);
    },
    brandsAction(context: ActionContext<RootState, RootState>, brands: any) {
      context.commit('brands', brands);
    },
    figuresAction(context: ActionContext<RootState, RootState>, figures: any) {
      context.commit('figures', figures);
    },
    gearsAction(context: ActionContext<RootState, RootState>, gears: any) {
      context.commit('gears', gears);
    },
    colorsAction(context: ActionContext<RootState, RootState>, colors: any) {
      context.commit('colors', colors);
    },
  },

  getters: {
    user(state: RootState): any {
      const user = state.user || JSON.parse(localStorage.getItem('user') || 'null'); // Lấy từ Vuex hoặc Local Storage
      return user;
    },
    brands(state: RootState): null {
      return state.brands;
    },
    figures(state: RootState): null {
      return state.figures;
    },
    gears(state: RootState): null {
      return state.gears;
    },
    colors(state: RootState): null {
      return state.colors;
    },
    
  },
});
