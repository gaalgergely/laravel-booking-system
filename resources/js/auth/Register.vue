<template>
    <div class="w-50 m-auto align-items-center">
        <div class="card card-body">
            <form>
                <div class="form-group">
                    <label for="email">Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        v-model="user.name"
                        placeholder="Enter your name"
                        :class="[{'is-invalid' : errorFor('name')}]"
                    >
                    <validation-errors :errors="errorFor('name')"></validation-errors>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="text"
                        name="email"
                        id="email"
                        class="form-control"
                        v-model="user.email"
                        placeholder="Enter your email"
                        :class="[{'is-invalid' : errorFor('email')}]"
                    >
                    <validation-errors :errors="errorFor('email')"></validation-errors>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        v-model="user.password"
                        placeholder="Enter your password"
                        :class="[{'is-invalid' : errorFor('password')}]"
                    >
                    <validation-errors :errors="errorFor('password')"></validation-errors>
                </div>

                <div class="form-group">
                    <label for="password">Re-type Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="form-control"
                        v-model="user.password_confirmation"
                        placeholder="Confirm your password"
                        :class="[{'is-invalid' : errorFor('password_confirmation')}]"
                    >
                    <validation-errors :errors="errorFor('password_confirmation')"></validation-errors>
                </div>

                <button
                    type="submit"
                    class="btn btn-primary btn-lg btn-block"
                    :disabled="loading"
                    @click.prevent="register"
                >Register</button>

                <hr>

                <div>
                    Already have an account?
                    <router-link :to="{ name: 'login' }" class="font-weight-bold">Login</router-link>
                </div>

                <div>
                    Forgotten password?
                    <router-link :to="{ name: 'home' }" class="font-weight-bold">Reset password</router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import validationErrors from "../shared/mixins/validationErrors";
import {logIn} from "../shared/utils/auth";

export default {
    name: "Register",

    mixins: [validationErrors],

    data() {
        return {
            user: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null
            },
            loading: false
        }
    },

    methods: {
        async register() {

            this.loading = true;
            this.errors = null;

            try {

                const response = await axios.post('/register', this.user);

                if (204 === response.status) {

                    logIn();
                    this.$store.dispatch('loadUser');
                    this.$router.push({ name: 'home' });
                }

            } catch (error) {

                this.errors = error.response && error.response.data.errors;
            }

            this.loading = false;
        }
    }
}
</script>

<style scoped>

</style>
