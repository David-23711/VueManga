const state={
    adminData:null
}

export default({
    state,
    getters:{
    adminData:(state)=>{
        return state.adminData;
    }
    },
    mutations:{
     getAdminData(state,adminData){
         state.adminData=adminData;
     }
    },
    actions:{
    setAdminData(context,adminData){
        context.commit('getAdminData',adminData);
    }
    } 
})