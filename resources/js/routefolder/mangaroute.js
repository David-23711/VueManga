import AdminDashboard from '../components/adminpanel/admindashboard';
import AdminLogin from '../components/adminpanel/adminlogin';
import AdminRegister from '../components/adminpanel/adminRegister';
import store from '../vuex';
const routes=[
 {
     name:'admindashboard',
     path:'/admin/home',
     component:AdminDashboard,
    //  beforeEnter:(to,from,next)=>{
    //      if(!store.getters.adminData)
    //      {
    //       next('/admin/login');
    //      }else{
    //          next();
    //      }
    //  }
 },
 {
     name:'adminlogin',
     path:'/admin/login',
     component:AdminLogin,
     beforeEnter:(to,from,next)=>{
     if(store.getters.adminData)
     {
         next('/admin/home');
     }else{
         next();
     }
     }
 },
 {
     name:'adminRegister',
     path:'/admin/register',
     component:AdminRegister,
     beforeEnter:(to,from,next)=>{
         if(store.getters.adminData)
         {
             next('/admin/home')
         }else{
             next();
         }
     }
 },
]
export default routes;