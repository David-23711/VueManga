const state = {
    userData: null,
};
export default {
    state,
    getters: {
        userData: (state) => {
            return state.userData;
        },
    },
    mutations: {
        getUser(state, userData) {
            state.userData = userData;
        },
    },
    actions: {
        setUser(context, userData) {
            context.commit("getAdmin", userData);
        },
    },
};
