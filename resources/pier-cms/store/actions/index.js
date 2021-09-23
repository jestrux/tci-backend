import { handleNetworkError, showSuccessToast, toPascalCase } from '../../Utils';
import { fetchModelRecords, insertRecord, deleteRecord, populateModel, updateRecord } from '../../API';
import router from '../../router';

export const setModels = ({ commit }, models) => {
    commit('SET_MODELS', models);
}

export const setSelectedModel = ({ commit }, model) => {
    commit('SET_SELECTED_MODEL', model);
}

export const setFilter = ({ commit }, filter) => {
    const key = Object.keys(filter)[0];
    const value = Object.values(filter)[0];

    commit('SET_FILTER', {key, value});
}

export const populateRecords = async ({ state, commit, dispatch }, itemCount) => {
    if(!state.selectedModelName)
        return;

    commit('POPULATING_RECORDS', true);
    try {
        await populateModel(state.selectedModelName, itemCount);
        commit('POPULATING_RECORDS', false);
        dispatch('fetchRecords');
    } catch (error) {
        handleNetworkError(error, `Error populating ${state.selectedModelName}:`);
        commit('POPULATING_RECORDS', false);
    }
}

export const fetchRecords = async ({ state, getters, commit }, page = 1) => {
    if(!state.selectedModelName || !getters.selectedModel)
        return;

    commit('SET_RECORDS', {data: null, pagination: null});
    commit('FETCHING_RECORDS', true);
    try {
        let {data, ...pagination} = await fetchModelRecords(state.selectedModelName, {page, ...state.modelFilters});
        commit('FETCHING_RECORDS', false);
        commit('SET_RECORDS', {data, pagination});
    } catch (error) {
        handleNetworkError(error, `Error fetching ${state.selectedModelName}:`);
        commit('FETCHING_RECORDS', false);
    }
}

export const setSelectedRecord = ({ commit }, recordId) => {
    commit('SET_SELECTED_RECORD', recordId);
}

export const createRecord = async ({ commit, state }, data) => {
    commit('SAVING_RECORD', true);
    try {
        let record = await insertRecord(state.selectedModelName, data);
        
        commit('SAVING_RECORD', false);
        let records = state.records;
        if (!records)
            records = [];

        records.unshift(record);

        commit('SET_RECORDS', records);
        router.replace(`/${state.selectedModelName}`);
        showSuccessToast(`${state.selectedModelName} created`);
    } catch (error) {
        handleNetworkError(error, `Error creating ${state.selectedModelName}:`);
        commit('SAVING_RECORD', false);
    }
}

export const editRecord = async ({ commit, state }, data) => {
    commit('SAVING_RECORD', true);
    try {
        let record = await updateRecord(state.selectedModelName, data);
        
        commit('SAVING_RECORD', false);
        let records = state.records;
        if (!records)
            records = [];

        records = records.map(record => {
            if(record._id == data._id)
                return data;

            return record;
        });

        commit('SET_RECORDS', records);
        router.replace(`/${state.selectedModelName}`);
        showSuccessToast(`${state.selectedModelName} updated`);
    } catch (error) {
        handleNetworkError(error, `Error creating ${state.selectedModelName}:`);
        commit('SAVING_RECORD', false);
    }
}

export const updateModel = async ({ commit, state }, updatedRecord) => {
    commit('SAVING_RECORD', true);
    try {
        // await saveModel(state.selectedModelName, updatedRecord);
        // commit('SAVING_RECORD', false);

        // let records = state.records;
        // if (!records)
        //     records = [];

        // records = records.map(record => {
        //     if (record._id === updatedRecord._id)
        //         return updatedrecord;

        //     return record;
        // });

        // commit('SET_RECORDS', records);
        // router.replace(`/${state.selectedModelName}`);
        // showSuccessToast(`${state.selectedModelName} updated`);
    } catch (error) {
        // handleNetworkError(error, `Error updating ${state.selectedModelName}:`);
        // commit('SAVING_RECORD', false);
    }
}

export const removeRecord = async ({ commit, state }, recordId) => {
    if(!state.selectedModelName)
        return;
        
    commit('DELETING_RECORD', true);
    try {
        await deleteRecord(state.selectedModelName, recordId);
        commit('DELETING_RECORD', false);

        let records = state.records;
        if (!records)
            records = [];

        records = records.filter(({_id}) => _id !== recordId);

        commit('SET_RECORDS', records);
        router.replace(`/${state.selectedModelName}`);
        showSuccessToast(`${state.selectedModelName} deleted`);
    } catch (error) {
        handleNetworkError(error, `Error deleting ${state.selectedModelName}:`);
        commit('DELETING_RECORD', false);
    }
}