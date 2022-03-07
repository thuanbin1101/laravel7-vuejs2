<template>
    <div>
        <div class="row">
            <router-link to="/order/create" class="btn btn-primary"
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
                                    <th>Name</th>
                                    <th>Total Amount</th>
                                    <th>Pay</th>
                                    <th>Due</th>
                                    <th>PayBy</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(order, index) in filterSearch"
                                    :key="index"
                                >
                                    <td>
                                        <a href="#">{{ order.name }}</a>
                                    </td>
                                    <td>
                                        {{ order.total }}
                                    </td>
                                    <td>
                                        {{ order.pay }}
                                    </td>
                                    <td>
                                        {{ order.due }}
                                    </td>
                                    <td>
                                        {{ order.payby }}
                                    </td>
                                    <td>
                                        <router-link
                                            :to="{
                                                name: 'order.view',
                                                params: { id: order.id },
                                            }"
                                            class="btn btn-sm btn-primary"
                                            >View</router-link
                                        >
                                        <a
                                            href="#"
                                            @click="deleteExpense(order.id)"
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
        this.allOrder();
    },
    data() {
        return {
            orders: [],
            searchTerm: "",
        };
    },
    computed: {
        filterSearch() {
            return this.orders.filter((order) => {
                return order.name.match(this.searchTerm);
            });
        },
    },
    methods: {
        allOrder() {
            axios
                .get("/api/orders/all")
                .then(({ data }) => {
                    this.orders = data;
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
                        .delete(`/api/order/${id}`)
                        .then((result) => {
                            this.orders = this.orders.filter((order) => {
                                return order.id != id;
                            });
                        })
                        .catch((err) => {
                            this.$router.push({ name: "order.index" });
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
