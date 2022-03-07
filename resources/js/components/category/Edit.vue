<template>
    <div>
        <div class="row">
            <router-link to="/category" class="btn btn-primary"
                >All Category</router-link
            >
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">
                                            Edit Category
                                        </h1>
                                    </div>
                                    <form
                                        class="user"
                                        @submit.prevent="categoryUpdate"
                                        enctype="multipart/form-data"
                                    >
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <label>Name</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="exampleInputLastName"
                                                        placeholder="Enter Full Name"
                                                        v-model="form.name"
                                                    />
                                                    <small
                                                        class="text-danger"
                                                        v-if="errors.name"
                                                        >{{
                                                            errors.name[0]
                                                        }}</small
                                                    >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button
                                                class="btn btn-primary btn-block"
                                            >
                                                Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    created() {
        if (!User.loggedIn()) {
            this.$router.push({ name: "home" });
        }
        let id = this.$route.params.id;
        axios
            .get("/api/category/" + id)
            .then(({ data }) => {
                this.form = data;
            })
            .catch((err) => {
                console.log(err);
            });
    },
    data() {
        return {
            form: {
                name: "",
            },
            errors: {},
        };
    },
    methods: {
    
        categoryUpdate() {
            let id = this.$route.params.id;
            axios
                .patch("/api/category/" + id, this.form)
                .then(() => {
                    this.$router.push({ name: "category.index" });
                    Notification.success();
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
    },
};
</script>
