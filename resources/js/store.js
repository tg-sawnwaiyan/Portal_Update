const getters = {
  getCategoryFormGetters: (state) => state.category
};
export default {

	state: {

       category: []

	},

	getters,

	actions: {
       allCategory(context){

          axios.get("api/home")

               .then((response)=>{
                  context.commit("categories",response.data) //categories will be run from mutation

               })

               .catch(()=>{
                  
                  console.log("Error........")
                  
               })
       }
	},

	mutations: {
       categories(state,data) {
          return state.category = data
       }
	}
}