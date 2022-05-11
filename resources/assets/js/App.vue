<template>
  <div :class="{'nav-open': $sidebar.showSidebar}">
    <router-view></router-view>
  </div>
</template>

<script>
export default{
	// created() {
	// 	if (this.$cookies.isKey('access_token') == true) {
	// 		this.auth =  axios.interceptors.request.use(function (config) {
	//           config.headers.Authorization ='Bearer ' + this.$cookies.get('access_token');
	//           config.headers.email = this.$cookies.get('email');
	//       	  // console.log(config.headers);
	//           return config;
	//         });
	// 	} else {
	// 		this.$router.go({ path: '/login' });
	// 	}
	// }
}
</script>
