import VueRouter from 'vue-router'
// Pages
//admin
const news_list = () => System.import(/* webpackChunkName: "admin" */'./components/news_list')
const editPost = () => System.import(/* webpackChunkName: "admin" */'./components/editNewsPost')
const categorylist = () => System.import(/* webpackChunkName: "admin" */'./components/categorylist')
const advertisementlist = () => System.import(/* webpackChunkName: "admin" */'./components/advertisementlist')
const editadvertisement = () => System.import(/* webpackChunkName: "admin" */'./components/editadvertisement')
const linkedNews = () => System.import(/* webpackChunkName: "admin" */'./components/LinkedNewslist')
const editlinkedNews = () => System.import(/* webpackChunkName: "admin" */'./components/EditLinkedNews')
const customerlist = () => System.import(/* webpackChunkName: "admin" */'./components/customerlist')
const commentlist = () => System.import(/* webpackChunkName: "admin" */'./components/commentlist')
const FacilitiesListComponent = () => System.import(/* webpackChunkName: "admin" */'./components/FacilitiesListComponent')
const CreateFacilityComponent = () => System.import(/* webpackChunkName: "admin" */'./components/CreateFacilityComponent')
const featurelist = () => System.import(/* webpackChunkName: "admin" */'./components/FeatureList')
const subjectlist = () => System.import(/* webpackChunkName: "admin" */'./components/SubjectList')
const occupationlist = () => System.import(/* webpackChunkName: "admin" */'./components/occupationlist')
const JobOfferList = () => System.import(/* webpackChunkName: "admin" */'./components/JobOfferList')
const Jobapplicantlist = () => System.import(/* webpackChunkName: "admin" */'./components/Jobapplicantlist')
const createcategory = () => System.import(/* webpackChunkName: "admin" */'./components/createcategory')
const joboffercreate = () => System.import(/* webpackChunkName: "admin" */'./components/joboffercreate')
const ProfileEdit = () => System.import(/* webpackChunkName: "admin" */'./components/ProfileEdit')
const adminlist = () => System.import(/* webpackChunkName: "admin" */'./components/AdminList')
const admincreate = () => System.import(/* webpackChunkName: "admin" */'./components/AdminCreate')
const occupation = () => System.import(/* webpackChunkName: "admin" */'./components/occupation')
const subject = () => System.import(/* webpackChunkName: "admin" */'./components/Subject')
const specialfeature = () => System.import(/* webpackChunkName: "admin" */'./components/CreateSpecialFeature')
const Accountlist = () => System.import(/* webpackChunkName: "admin" */'./components/Accountlist')

// search
const hospitalSearch = () => System.import(/* webpackChunkName: "search" */'./components/hospitalSearch')
const nursingSearch = () => System.import(/* webpackChunkName: "search" */'./components/nursingSearch')
const jobSearch = () => System.import(/* webpackChunkName: "search" */'./components/jobSearch')
const JobApply = () => System.import(/* webpackChunkName: "search" */'./components/JobApply')
const Profile = () => System.import(/* webpackChunkName: "search" */'./components/Profile')

import NotFound from './components/404';
import Unauthorized from './components/419';
import sitepolicy from './components/sitepolicy'
import startpage from './components/startpage'
import aboutus from './components/aboutus'
import privacyPolicy from './components/privacyPolicy';
import Contract from './pages/Contract'
import Register from './pages/Register'
import Login from './pages/Login'
import PasswordResetMail from './pages/Passwordreset'
import PasswordResetForm from './pages/Passwordresetform'
import Newsdetails from "./components/Newsdetails";
import job_details from "./components/job_details";
import comment from "./components/Comment";
import nursingMailConfirm from "./components/nursingMailConfirm";
import News from './components/News';


const HospitalHistory = () => System.import(/* webpackChunkName: "favouritehistory" */'./components/HospitalHistory')
const favouriteHospital = () => System.import(/* webpackChunkName: "favouritehistory" */'./components/favouriteHospital')
const NursingHistory = () => System.import(/* webpackChunkName: "favouritehistory" */'./components/NursingHistory')
const favouriteNursing = () => System.import(/* webpackChunkName: "favouritehistory" */'./components/favouriteNursing')
const nursingFavouriteMail = () => System.import(/* webpackChunkName: "favouritehistory" */'./components/nursingFavouriteMail')

const NewsCategory = () => System.import(/* webpackChunkName: "NewsCategory" */'./components/News_Category')

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
  },
  {
    name: 'sitepolicy',
    path: '/sitepolicy',
    component: sitepolicy,
  },

  {
    name: 'startpage',
    path: '/startpage',
    component: startpage,
  },

  {
    name: 'aboutus',
    path: '/aboutus',
    component: aboutus,
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