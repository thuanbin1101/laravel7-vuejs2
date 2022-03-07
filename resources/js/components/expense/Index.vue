<template>
    <div>
        <div class="row">
            <router-link to="/expense/create" class="btn btn-primary"
                >Add Expense</router-link
            >
            <div style="width: 89%">
                <input
                    v-model="searchTerm"
                    class="form-control"
                    type="text"
                    style="width: 300px; float: right"
                    placeholder="Search Here..."
                />
            </div>
            <br />
        </div>
        <br />

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    >
                        <h6 class="m-0 font-weight-bold text-primary">
                            Expense List
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Details</th>
                                    <th>Amount</th>
                                    <th>Expense Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(expense, index) in filterSearch"
                                    :key="index"
                                >
                                    <td>
                                        <a href="#">{{ expense.details }}</a>
                                    </td>
                                    <td>
                                        {{ expense.amount }}
                                    </td>
                                    <td>
                                        {{ expense.expense_date }}
                                    </td>
                                    <td>
                                        <router-link
                                            :to="{
                                                name: 'expense.edit',
                                                params: { id: expense.id },
                                            }"
                                            class="btn btn-sm btn-primary"
                                            >Detail</router-link
                                        >
                                        <a
                                            href="#"
                                            @click="deleteExpense(expense.id)"
                                            class="btn btn-sm btn-danger"
                                            >Delete</a
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
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
        this.allExpense();
    },
    data() {
        return {
            expenses: [],
            searchTerm: "",
        };
    },
    computed: {
        filterSearch() {
            return this.expenses.filter((expense) => {
                return expense.details.match(this.searchTerm);
            });
        },
    },
    methods: {
        allExpense() {
            axios
                .get("/api/expense")
                .then(({ data }) => {
                    this.expenses = data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        deleteExpense(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(`/api/expense/${id}`)
                        .then((result) => {
                            this.expenses = this.expenses.filter((expense) => {
                                return expense.id != id;
                            });
                        })
                        .catch((err) => {
                            this.$router.push({ name: "expense.index" });
                        });

                    Swal.fire(
                        "Deleted!",
                        "Your file has been deleted.",
                        "success"
                    );
                }
            });
        },
    },
};
</script>
