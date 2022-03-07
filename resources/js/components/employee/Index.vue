<template>
    <div>
        <div class="row">
            <router-link to="/employee/create" class="btn btn-primary"
                >Add Employee</router-link
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
                            Employee List
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Photo</th>
                                    <th>Phone</th>
                                    <th>Salary</th>
                                    <th>Joining Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(employee, index) in filterSearch"
                                    :key="index"
                                >
                                    <td>
                                        <a href="#">{{ employee.name }}</a>
                                    </td>
                                    <td>
                                        <img
                                            :src="employee.photo"
                                            width="40px"
                                            height="40px"
                                            alt=""
                                        />
                                    </td>
                                    <td>{{ employee.phone }}</td>
                                    <td>{{ employee.salary }}</td>
                                    <td>{{ employee.joiningdate }}</td>

                                    <td>
                                        <router-link
                                            :to="{
                                                name: 'employee.edit',
                                                params: { id: employee.id },
                                            }"
                                            class="btn btn-sm btn-primary"
                                            >Detail</router-link
                                        >
                                        <a
                                            href="#"
                                            @click="deleteEmployee(employee.id)"
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
        this.allEmployee();
    },
    data() {
        return {
            employees: [],
            searchTerm: "",
        };
    },
    computed: {
        filterSearch() {
            console.log(1);
            return this.employees.filter((employee) => {
                return employee.phone.match(this.searchTerm);
            });
        },
    },
    methods: {
        allEmployee() {
            axios
                .get("/api/employee")
                .then(({ data }) => {
                    this.employees = data;
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
                        .delete(`/api/employee/${id}`)
                        .then((result) => {
                            this.employees = this.employees.filter(
                                (employee) => {
                                    return employee.id != id;
                                }
                            );
                        })
                        .catch((err) => {
                            this.$router.push({ name: "employee.index" });
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
