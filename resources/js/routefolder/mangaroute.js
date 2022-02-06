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
import userLogin from "../components/userpanel/login";
import userRegister from "../components/userpanel/register";
import viewInfo from "../components/userpanel/viewInfo";
import userReadManga from "../components/userpanel/userReadManga";
import userBookmark from "../components/userpanel/userBookmark";
import userSlideView from "../components/userpanel/slideView";
import HotManga from "../components/userpanel/hotmanga";
import NewestManga from "../components/userpanel/newestManga";
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
        path: "/user",
        component: Userindex,
    },
    {
        name: "Uindex",
        path: "/user/:category",
        component: Userindex,
    },
    {
        name: "Uindexdate",
        path: "/user/data/:date",
        component: Userindex,
    },
    {
        name: "paginationDate",
        path: "/user/data/:date/:current/:total",
        component: Userindex,
    },
    {
        name: "pagination",
        path: "/user/pagination/:pageCurrent/:pageTotal",
        component: Userindex,
    },
    {
        name: "Datepagination",
        path: "/user/pagination/:current/:total/:date",
        component: Userindex,
    },
    {
        name: "Genrepagination",
        path: "/user/:category/:current/:total",
        component: Userindex,
    },
    {
        name: "UserLogin",
        path: "/index/login",
        component: userLogin,
        beforeEnter: (to, form, next) => {
            if (store.getters.userData) {
                next("/user");
            } else {
                next();
            }
        },
    },
    {
        name: "UserRegister",
        path: "/index/register",
        component: userRegister,
        beforeEnter: (to, from, next) => {
            if (store.getters.userData) {
                next("/user");
            } else {
                next();
            }
        },
    },
    {
        name: "ViewInfo",
        path: "/user/viewInfo/:mid",
        component: viewInfo,
    },
    {
        name: "UserReadManga",
        path: "/user/readmanga/:mid/:vid/:eid/:number",
        component: userReadManga,
    },
    {
        name: "UserBookmark",
        path: "/bookmarks/:uid",
        component: userBookmark,
    },
    {
        name: "SlideView",
        path: "/user/readmanga/slideView/:eid/:mid/:vid/:number",
        component: userSlideView,
    },
    {
        name: "hotmanga",
        path: "/hotmanga",
        component: HotManga,
    },
    {
        name: "paginateHotmanga",
        path: "/hotmanga/pagination/:current/:total",
        component: HotManga,
    },
    {
        name: "newestmanga",
        path: "/newest",
        component: NewestManga,
    },
    {
        name: "paginateNewestmanga",
        path: "/newest/pagination/:current/:total",
        component: NewestManga,
    },
];
export default routes;
