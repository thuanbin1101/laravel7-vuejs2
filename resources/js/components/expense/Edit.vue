<template>
    <div>
        <div class="row">
            <router-link to="/expense" class="btn btn-primary"
                >All Expense</router-link
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
                                            Edit Expense
                                        </h1>
                                    </div>
                                    <form
                                        class="user"
                                        @submit.prevent="expenseUpdate"
                                        enctype="multipart/form-data"
                                    >
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <label
                                                        >Expense Details</label
                                                    >
                                                    <textarea
                                                        class="form-control"
                                                        id="exampleFormControlTextarea1"
                                                        v-model="form.details"
                                                        rows="3"
                                                    ></textarea>
                                                    <small
                                                        class="text-danger"
                                                        v-if="errors.details"
                                                        >{{
                                                            errors.details[0]
                                                        }}</small
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <label
                                                        >Expense Amount</label
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="exampleInputEmail1"
                                                        v-model="form.amount"
                                                        aria-describedby="emailHelp"
                                                        placeholder="Enter email"
                                                    />
                                                    <small
                                                        class="text-danger"
                                                        v-if="errors.amount"
                                                        >{{
                                                            errors.amount[0]
                                                        }}</small
                                                    >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button
                                                class="btn btn-primary btn-block"
                                            >
                                                Update
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
            .get("/api/expense/" + id)
            .then(({ data }) => {
                this.form = data;
            })
            .catch((err) => {});
    },
    data() {
        return {
            form: {
                details: "",
                amount: "",
            },
            errors: {},
        };
    },
    methods: {
        expenseUpdate() {
            let id = this.$route.params.id;
            axios
                .patch("/api/expense/" + id, this.form)
                .then(() => {
                    this.$router.push({ name: "expense.index" });
                    Notification.success();
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
    },
};
</script>
