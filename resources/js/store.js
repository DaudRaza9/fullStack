import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

export default new Vuex.Store({
    state :{
        counter: 1000,
        deleteModalObj :{
            showDeleteModal:false,
            deleteUrl : '',
            data:null,
            deletingIndex: -1,
            isDeleted:false,
        },
        user:false,
        userPermission:null
    },
    mutations:{
        changeTheCounter(state,data){
            state.counter += data
        },
        setDeleteModal(state,data){

            const deleteModalObj ={
                    showDeleteModal:false,
                    deleteUrl : '',
                    data:null,
                    deletingIndex: -1,
                    isDeleted:data,
            }
             state.deleteModalObj = deleteModalObj
        },
        setDeletingModalObj(state,data){
            state.deleteModalObj = data
        },
        setUpdateUser(state,data){
            state.user = data
        },
        setUserPermission(state,data){
            state.userPermission = data
        },

    },
    actions:{
        changeCounterAction({commit},data){
            commit('changeTheCounter',data)
        }
    },
    getters:{
        getCounter(state){
           return state.counter
        },
        getDeleteModalObj(state){
           return state.deleteModalObj
        },
        getUserPermission(state){
           return state.userPermission
        }

    }
})

// export const strict = false
// export const state=()=>({
//
// })
// //Common getters
// export const getters={
//
// }
//
// //mutations for changing data from action
// export const mutations={
//
// }
//
// //actions for committing mutations
// export const action={
//
// }
