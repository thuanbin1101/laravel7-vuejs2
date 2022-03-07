<template>
    <div>
        <div class="row">
            <router-link to="/order" class="btn btn-primary"
                >Today Order</router-link
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
                                            Search Order
                                        </h1>
                                    </div>
                                    <form
                                        class="user"
                                        @submit.prevent="searchDate"
                                    >
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <label
                                                        >Search by date</label
                                                    >
                                                    <input
                                                        type="date"
                                                        class="form-control"
                                                        id="exampleInputLastName"
                                                        placeholder="Enter Full Name"
                                                        v-model="date"
                                                    />
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
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                    <th>SubTotal</th>
                                    <th>Vat</th>
                                    <th>Total</th>
                                    <th>Pay</th>
                                    <th>Due</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="order in orders"
                                    :key="order.id"
                                ></tr>
                                <tr v-for="order in orders" :key="order.id">
                                    <td>{{ order.name }}</td>
                                    <td>{{ order.qty }}</td>
                                    <td>{{ order.sub_total }}</td>
                                    <td>{{ order.vat }}</td>
                                    <td>{{ order.total }}</td>
                                    <td>{{ order.pay }}</td>
                                    <td>{{ order.due }}</td>
                                </tr>
                            </tbody>
                        </table>
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
    },
    data() {
        return {
            date: "",
            orders: {},
        };
    },
    methods: {
        searchDate() {
            var data = { date: this.date };
            axios
                .post("/api/orders/search", data)
                .then(({ data }) => {
                    this.orders = data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
};
</script>
