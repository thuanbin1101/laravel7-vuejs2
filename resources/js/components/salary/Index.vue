<template>
    <div>
        <div class="row">
            <router-link to="/given-salary" class="btn btn-primary"
                >Pay Salary</router-link
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
                            All Salary Details
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Month Name</th>
                                    <th>Details</th>
                                    </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(salary, index) in filterSearch"
                                    :key="index"
                                >
                                    <td>
                                        <a href="#">{{ salary.salary_month }}</a>
                                    </td>
                                    <td>
                                        <router-link
                                            :to="{
                                                name: 'salary.view',
                                                params: {
                                                    id: salary.salary_month,
                                                },
                                            }"
                                            class="btn btn-sm btn-primary"
                                            >View Salary</router-link
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
        this.allSalary();
    },
    data() {
        return {
            salaries: [],
            searchTerm: "",
        };
    },
    computed: {
        filterSearch() {
            console.log(1);
            return this.salaries.filter((salary) => {
                return salary.salary_month.match(this.searchTerm);
            });
        },
    },
    methods: {
        allSalary() {
            axios
                .get("/api/salary/" )
                .then(({ data }) => {
                    this.salaries = data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        deleteEmployee(id) {
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
                        .delete(`/api/salary/${id}`)
                        .then((result) => {
                            this.salaries = this.salaries.filter((salary) => {
                                return salary.id != id;
                            });
                        })
                        .catch((err) => {
                            this.$router.push({ name: "salary.index" });
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
