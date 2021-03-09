import VueRouter from 'vue-router'
// Pages
import Register from './pages/Register'
import Contract from './pages/Contract'
import Login from './pages/Login'
import PasswordResetMail from './pages/Passwordreset'
import PasswordResetForm from './pages/Passwordresetform'
import Newsdetails from "./components/Newsdetails";
import hospitalSearch from "./components/hospitalSearch";
import JobApply from "./components/JobApply";
import customerlist from "./components/customerlist";
import job_details from "./components/job_details";
import news_list from "./components/news_list";
import editPost from "./components/editNewsPost";
import categorylist from "./components/categorylist";
import createcategory from "./components/createcategory";
import FacilitiesListComponent from "./components/FacilitiesListComponent";
import CreateFacilityComponent from "./components/CreateFacilityComponent";
import joboffercreate from "./components/JobOfferCreate";
import Profile from "./components/Profile";
import JobOfferList from "./components/JobOfferList";
import ProfileEdit from "./components/ProfileEdit";
import HospitalHistory from "./components/HospitalHistory";
import favouriteHospital from "./components/favouriteHospital";
import NursingHistory from "./components/NursingHistory";
import subject from "./components/Subject";
import subjectlist from "./components/SubjectList";
import advertisementlist from "./components/advertisementlist";
import editadvertisement from "./components/editadvertisement";
import linkedNews from "./components/LinkedNewslist";
import editlinkedNews from "./components/EditLinkedNews";
import comment from "./components/Comment";
import commentlist from "./components/commentlist";
import featurelist from "./components/FeatureList";
import favouriteNursing from "./components/favouriteNursing";
import specialfeature from "./components/CreateSpecialFeature";
import nursingFavouriteMail from "./components/nursingFavouriteMail";
import nursingMailConfirm from "./components/nursingMailConfirm";
import privacyPolicy from './components/privacyPolicy';
import occupation from './components/occupation';
import occupationlist from './components/occupationlist';
import nursingSearch from './components/nursingSearch';
import jobSearch from './components/jobSearch';
import News from './components/News';
import Unauthorized from './components/419';
import NotFound from './components/404';
import Jobapplicantlist from './components/Jobapplicantlist'
import adminlist from './components/AdminList'
import admincreate from './components/AdminCreate'
import sitepolicy from './components/sitepolicy'
import Accountlist from './components/Accountlist'
import NewsCategory from './components/News_Category'

// import menu from './components/menu/Menu';

function guard(to, from, next){
    next();
    if(localStorage.getItem('loginuser') == 'true') {
        next('/'); // allow to enter route
    } else{
        next(); // go to '/login';
    }
}

// Routes
const routes = [

    {
        path: '/Unauthorized',
        name: 'Unauthorized',
        component: Unauthorized,
    },
    {
        path: '/NotFound',
        name: 'NotFound',
        component: NotFound,
    },


    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            auth: false
        }
    },
    {
        name: 'Contract',
        path: '/contract',
        component: Contract,
      },
    {
        path: '/login',
        name: 'login',
        beforeEnter: guard, 
        component: Login,
        // meta: {
        //     auth: undefined
        // }
    },
    {
        path: '/admin_login',
        name: 'admin_login',
        beforeEnter: guard,
        component: Login,
        // meta: {
        //     auth: undefined
        // }
    },

    {
        path: '/reset',
        name: 'reset',
        component: PasswordResetMail,
        // meta: {
        //     auth: false
        // }
    },
    {
        path: '/resetpassword',
        name: 'resetpassword',
        component: PasswordResetForm,
        // meta: {
        //     auth: false
        // }
    },

    {
        name: 'News',
        path: '/',
        component: News,
        meta: {
            auth: undefined
        }
    },
    {
        name: 'NewsCategory',
        path: '/newscategory/:id',
        component: NewsCategory,
        meta: {
            auth: undefined
        }
    },

    {
        name: 'jobSearch',
        path: '/jobSearch',
        component: jobSearch
    },

    {
        name: 'nursingSearch',
        path: '/nursingSearch',
        component: nursingSearch
    },
    {
        name: "newdetails",
        path: "/newsdetails/:id",
        component: Newsdetails,
        meta: {
            auth: undefined
        }
    },
    {
        name: "hospital_search",
        path: "/hospital_search",
        component: hospitalSearch,
        meta: {
            auth: undefined
        }
    },
    {
        name: "jobapply",
        path: "/jobapply/:job_id",
        component: JobApply,
        meta: {
            auth: false
        }
    },
    {
        name: "nuscustomerlist",
        path: "/nuscustomerlist",
        component: customerlist,
        meta: {
            auth: { roles: 2, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
        }
    },
    {
        name: "hoscustomerlist",
        path: "/hoscustomerlist",
        component: customerlist,
        meta: {
            auth: { roles: 2, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
        }
    },

    {
        name: "job_details",
        path: "/job_details/:id",
        component: job_details,
        meta: {
            auth: undefined
        }
    },
    {
        name: "news_list",
        path: "/news_list",
        component: news_list,
        meta: {
            auth: { roles: 2, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
        }
    },
    {
        name: "create_news",
        path: "/create_news",
        component: editPost,
        meta: {
            auth: { roles: 2, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
        }
    },
    {
        name: "editPost",
        path: "/editPost/:id",
        component: editPost,
        meta: {
            auth: { roles: 2, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
        }
    },
    {
        name: "categorylist",
        path: "/categorylist",
        component: categorylist,
        meta: {
            auth: { roles: 2, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
        }
    },
    {
        name: "createcategory",
        path: "/createcategory",
        component: createcategory,
        meta: {
            auth: { roles: 2, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
        }
    },
    {
        name: "editcategory",
        path: "/editcategory",
        component: createcategory,
        meta: {
            auth: { roles: 2, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
        }
    },
    {
        name: "facilitieslist",
        path: "/facilitieslist",
        component: FacilitiesListComponent,
        meta: {
            auth: { roles: 2, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
        }
    },
    {
        name: "createfacility",
        path: "/createfacility",
        component: CreateFacilityComponent,
        meta: {
            auth: { roles: 2, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
        }
    },

    {
        name: "editfacility",
        path: "/editfacility",
        component: CreateFacilityComponent,
        meta: {
            auth: { roles: 2, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
        }
    },
    {
        name: "profile",
        path: "/profile/:type/:id",
        component: Profile,
        // props: true,
        meta: {
            auth: undefined,
        }
    },
    {
        name: "profiledit",
        path: "/profiledit/:type/:id",
        component: ProfileEdit,
        meta: {
            auth: true,
        }
    },
    {
        name: "accountlist",
        path: "/accountlist/:type/:id",
        component: Accountlist,
        meta: {
            auth: true,
        }
    },
    {
        name: "jobofferlist",
        path: "/jobofferlist",
        component: JobOfferList,
        meta: {
            auth: true
        }
    },
    {
        name: "profilejobofferlist",
        path: "/profilejobofferlist/:type/:id",
        component: JobOfferList,
        meta: {
            auth: true
        }
    },    
    {
        name: "applicantlist",
        path: "/jobapplicantlist/:type/:page/:id",
        component: Jobapplicantlist,
        meta: {
            auth: true
        }
    },
    {
        name: "jobapplicantlist",
        path: "/jobapplicantlist",
        component: Jobapplicantlist,
        meta: {
            auth: true
        }
    },
    {
        name: "joboffercreate",
        path: "/joboffercreate",
        component: joboffercreate,
        meta: {
            // auth: { roles: 1, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
            auth: true
        }
    },
    {
        name: "jobedit",
        path: "/jobedit/:id",
        component: joboffercreate,
        meta: {
            // auth: { roles: 1, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
            auth: true
        }
    },
    {
        name: "profilejoboffercreate",
        path: "/profilejoboffercreate/:type/:id",
        component: joboffercreate,
        meta: {
            // auth: { roles: 1, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
            auth: true
        }
    },

    {
        name: "hospital_history",
        path: "/hospital_history",
        component: HospitalHistory,
        meta: {
            auth: false
        }
    },

    {
        name: "favouriteHospital",
        path: "/favouriteHospital",
        component: favouriteHospital,
        meta: {
            auth: false
        }
    },
    {
        name: "favouriteNursing",
        path: "/favouriteNursing",
        component: favouriteNursing,
        meta: {
            auth: false
        }
    },
    {
        name: "subject",
        path: "/subject",
        component: subject,
        meta: {
            auth: { roles: 2, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
        }
    },
    {
        name: "subjectlist",
        path: "/subjectlist",
        component: subjectlist,
        meta: {
            auth: { roles: 2, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
        }
    },
    {
        name: "ads",
        path: "/ads",
        component: advertisementlist,
        meta: {
            auth: { roles: 2, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
        }
    },
    {
        name: "advertisement",
        path: "/advertisement",
        component: editadvertisement,
        meta: {
            auth: { roles: 2, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
        }
    },

    {
        name: "editadvertisement",
        path: "/editads/:id",
        component: editadvertisement,
        meta: {
            auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/Unauthorized'}
        }
    },
    {
      name: 'nursing_history',
      path: '/nursing_history',
      component: NursingHistory,
      meta: {
        auth: false
      }
    },

  {
    name: 'comment',
    path: '/comment/:type/:id',
    component: comment,
    meta: {
        auth: undefined
    }
  },
  {
    name: 'nuscommentlist',
    path: '/nuscommentlist',
    component: commentlist,
    meta: {
        auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/Unauthorized'}
    }
  },
  {
    name: 'hoscommentlist',
    path: '/hoscommentlist',
    component: commentlist,
    meta: {
        auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/Unauthorized'}
    }
  },
  {
    name: 'specialfeature',
    path: '/specialfeature',
    component: specialfeature,
    meta: {
        auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/Unauthorized'}
    }
  },
  {
    name: 'featurelist',
    path: '/featurelist',
    component: featurelist,
    meta: {
        auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/Unauthorized'}
    }
  },
  {
    name: 'nusfeaturelist',
    path: '/nusfeaturelist',
    component: featurelist,
    meta: {
        auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/Unauthorized'}
    }
  },
  {
    name: 'hosfeaturelist',
    path: '/hosfeaturelist',
    component: featurelist,
    meta: {
        auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/Unauthorized'}
    }
  },
  {
    name: 'nursingFavouriteMail',
    path: '/nursingFavouriteMail',
    component: nursingFavouriteMail,
    meta: {
        auth: false
    }
  },
  {
    name: 'nursingMailConfirm',
    path: '/nursingMailConfirm',
    component: nursingMailConfirm,
    meta: {
        auth: false
    }
  },
  {
    name: 'privacyPolicy',
    path: '/privacyPolicy',
    component: privacyPolicy,
    meta: {
        auth: false
    }
  },
  {
    name: 'sitepolicy',
    path: '/sitepolicy',
    component: sitepolicy,
    meta: {
        auth: false
    }
  },

    {
        name: 'occupation',
        path: '/occupation',
        component: occupation,
        meta: {
            auth: { roles: 2, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
        }
    },

  {
    name: 'occupationlist',
    path: '/occupationlist',
    component: occupationlist,
    meta: {
        // auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/Unauthorized'}
        auth: true
    }
  },

  {
    name:'adminlist',
    path:'/admin/t_is_admin_register',
    component:adminlist,
    meta: {
        auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/Unauthorized'}
    }
  },
  {
    name:'admincreate',
    path:'/admin/create',
    component:admincreate,
    meta: {
        auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/Unauthorized'},
    }
  },
  {
    name:'adminedit',
    path:'/admin/edit/:id',
    component:admincreate,
    meta: {
        auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/Unauthorized'},
    }
  },
  { 
    name: '404', 
    path: "*", 
    component: NotFound 
  },
  {
    name: "linkedNews",
    path: "/linkedNews",
    component: linkedNews,
    meta: {
        auth: { roles: 2, redirect: { name: 'login' }, forbiddenRedirect: '/Unauthorized' }
    }
  },
  {
    name: "editnews",
    path: "/editnews/",
    component: editlinkedNews,
    meta: {
        auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/Unauthorized'}
    }
},
{
    name: "editnews",
    path: "/editnews/:id",
    component: editlinkedNews,
    meta: {
        auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/Unauthorized'}
    }
},
]
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
})
export default router