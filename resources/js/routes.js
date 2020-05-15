import ExampleComponent from "./components/ExampleComponent";
import SecondComponent from "./components/SecondComponent";
import VueRouter from "vue-router";

const routes = [
    {
        path: "/",
        component: ExampleComponent,
        name: "home"
    },
    {
        path: "/second",
        component: SecondComponent,
        name: "second"
    }
];

const router = new VueRouter({
    mode: "history",
    routes //short for 'routes: routes'
});

export default router;
