import AdminDashboard from "../components/adminpanel/admindashboard";
import AdminLogin from "../components/adminpanel/adminlogin";
import AdminRegister from "../components/adminpanel/adminRegister";
import AdminCategory from "../components/adminpanel/adminCategory";
import AdminManga from "../components/adminpanel/adminManga";
import AdminMangaSetting from "../components/adminpanel/adminMangaSetting";
import AdminMangaEpisodes from "../components/adminpanel/adminEpisodes";
import AdminMultiImage from "../components/adminpanel/adminMangaImage";
import AdminReadImage from "../components/adminpanel/adminReadManga";
import MangaRoom from "../components/adminpanel/viewMangaWide";
import AdminTeam from "../components/adminpanel/adminTeams";
import Userindex from "../components/userpanel/index";
import store from "../vuex";
const routes = [
    {
        name: "admindashboard",
        path: "/admin/home",
        component: AdminDashboard,
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
        name: "adminlogin",
        path: "/admin/login",
        component: AdminLogin,
        beforeEnter: (to, from, next) => {
            if (store.getters.adminData) {
                next("/admin/home");
            } else {
                next();
            }
        },
    },
    {
        name: "adminRegister",
        path: "/admin/register",
        component: AdminRegister,
        beforeEnter: (to, from, next) => {
            if (store.getters.adminData) {
                next("/admin/home");
            } else {
                next();
            }
        },
    },
    {
        name: "adminCategory",
        path: "/admin/category",
        component: AdminCategory,
    },
    {
        name: "adminManga",
        path: "/admin/manga",
        component: AdminManga,
    },
    {
        name: "MangaSetting",
        path: "/admin/manga/setting/:id/admin/:aid",
        component: AdminMangaSetting,
    },
    {
        name: "MangaEpisode",
        path: "/admin/manga/volume/episodes/:id/:mid/:aid",
        component: AdminMangaEpisodes,
    },
    {
        name: "MultiImage",
        path: "/admin/manga/volume/episodes/insertImage/:eid/:mid/:vid",
        component: AdminMultiImage,
    },
    {
        name: "ReadImage",
        path: "/admin/manga/volume/images/:eid/:mid/:vid/:aid",
        component: AdminReadImage,
    },
    {
        name: "MangaRoom",
        path: "/admin/manga/volume/images/:eid/:mid/:vid/:aid/mangaRoom",
        component: MangaRoom,
    },
    {
        name: "Team",
        path: "/admin/team",
        component: AdminTeam,
    },
    {
        name: "Index",
        path: "/",
        component: Userindex,
    },
    {
        name: "Uindex",
        path: "/user/:category",
        component: Userindex,
    },
    {
        name: "Uindex",
        path: "/user/data/:date",
        component: Userindex,
    },
];
export default routes;
