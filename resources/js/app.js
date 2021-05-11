// Plugins
import Vuetify from "vuetify";

// Views
import Navbar from "./components/global/Navbar";
import Login from "./components/auth/Login";
import Register from "./components/auth/Register";
import PasswordReset from "./components/auth/PasswordReset";
import Errors from "./components/partials/Errors";
import PasswordUpdate from "./components/auth/PasswordUpdate";
import Settings from "./components/settings/Settings";
import Links from "./components/links/Links";
import Customization from "./components/customization/Customization";
import LinkPage from "./components/LinkPage";
import Plans from "./components/plans/Plans";
import Analytics from "./components/links/Analytics";
import LandingPage from "./components/LandingPage";

require("./bootstrap");

window.Vue = require("vue").default;

Vue.use(Vuetify, require('vue-moment'));

const app = new Vue({
    el: "#app",
    vuetify: new Vuetify(),
    components: {
        Login,
        Navbar,
        Register,
        PasswordReset,
        PasswordUpdate,
        Errors,
        Settings,
        Links,
        Customization,
        LinkPage,
        Plans,
        Analytics,
        LandingPage
    }
});
