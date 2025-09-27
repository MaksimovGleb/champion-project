import { createStore } from 'vuex';

const store = createStore({
    state: {
        conditionAmount: null, // Здесь будет ваша общая переменная
    },
    mutations: {
        setConditionAmount(state, value) {
            state.conditionAmount = value;
        },
    },
});

export default store;

