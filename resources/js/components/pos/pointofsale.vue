<template>
    <div>
        <div class="container-fluid" id="container-wrapper">
            <div
                class="d-sm-flex align-items-center justify-content-between mb-4"
            >
                <h1 class="h3 mb-0 text-gray-800">POS Dashboard</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        POS
                    </li>
                </ol>
            </div>

            <div class="row mb-3">
                <!-- Area Chart -->
                <div class="col-xl-6 col-lg-6">
                    <div class="card mb-4">
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                        >
                            <h6 class="m-0 font-weight-bold text-primary">
                                Expense Insert
                            </h6>
                            <a class="btn btn-sm btn-info"
                                ><font color="#ffffff">Add Customer</font></a
                            >
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Qty</th>
                                        <th>Unit</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(cart, index) in carts"
                                        :key="index"
                                    >
                                        <td>
                                            {{ cart.pro_name }}
                                        </td>
                                        <td class="qty_pro">
                                            <button
                                                @click.prevent="
                                                    increment(cart.id)
                                                "
                                                class="btn btn-sm btn-success"
                                            >
                                                +
                                            </button>
                                            <div class="qty_number">
                                                <input
                                                    type="text"
                                                    readonly
                                                    style="width: 20px"
                                                    :value="cart.pro_quantity"
                                                />
                                            </div>

                                            <button
                                                v-if="cart.pro_quantity > 1"
                                                @click.prevent="
                                                    decrement(cart.id)
                                                "
                                                class="btn btn-sm btn-danger"
                                            >
                                                -
                                            </button>
                                        </td>
                                        <td>{{ cart.product_price }}</td>
                                        <td>{{ cart.sub_total }}</td>
                                        <td>
                                            <a
                                                @click="removeItem(cart.id)"
                                                href="#"
                                                class="btn btn-sm btn-primary"
                                                >X</a
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <ul class="list-group">
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center"
                                >
                                    Total Quantity:
                                    <strong>{{ qty }}</strong>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center"
                                >
                                    Sub Total
                                    <strong>{{ subtotal }} $</strong>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center"
                                >
                                    Vat:
                                    <strong>{{ vats.vat }}%</strong>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center"
                                >
                                    Total
                                    <strong
                                        >{{
                                            (subtotal * vats.vat) / 100 +
                                            subtotal
                                        }}
                                        $</strong
                                    >
                                </li>
                            </ul>
                            <br /><br />

                            <form action="" @submit.prevent="orderDone">
                                <label for="">Customer Name</label>
                                <select
                                    name=""
                                    v-model="customer_id"
                                    class="form-control"
                                    id=""
                                >
                                    <option
                                        v-for="(customer, index) in customers"
                                        :key="index"
                                        :value="customer.id"
                                    >
                                        {{ customer.name }}
                                    </option>
                                </select>
                                <label for="">Pay</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="pay"
                                />
                                <label for="">Due</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="due"
                                />
                                <label for="">Pay By</label>
                                <select
                                    name=""
                                    id=""
                                    class="form-control"
                                    v-model="payby"
                                >
                                    <option value="HandCash">Hand Cash</option>
                                    <option value="Cheaque">Cheaque</option>
                                    <option value="GiftCard">
                                        Gift Card
                                    </option></select
                                ><br />
                                <button class="btn btn-success">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Pie Chart -->

                <div class="col-xl-6 col-lg-6">
                    <div class="card mb-4">
                        <div
                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                        >
                            <h6 class="m-0 font-weight-bold text-primary">
                                Products Sold
                            </h6>
                        </div>

                        <!--  Category Wise Product -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a
                                    class="nav-link active"
                                    id="home-tab"
                                    data-toggle="tab"
                                    href="#home"
                                    role="tab"
                                    aria-controls="home"
                                    aria-selected="true"
                                    >All Product
                                </a>
                            </li>

                            <li
                                class="nav-item"
                                v-for="category in categories"
                                :key="category.id"
                            >
                                <a
                                    class="nav-link"
                                    id="profile-tab"
                                    data-toggle="tab"
                                    href="#profile"
                                    role="tab"
                                    aria-controls="profile"
                                    aria-selected="false"
                                    @click="subproduct(category.id)"
                                    >{{ category.name }}</a
                                >
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div
                                class="tab-pane fade show active"
                                id="home"
                                role="tabpanel"
                                aria-labelledby="home-tab"
                            >
                                <div class="card-body">
                                    <input
                                        type="text"
                                        v-model="searchTerm"
                                        class="form-control"
                                        style="width: 560px"
                                        placeholder="Search Product"
                                    />

                                    <div class="row">
                                        <div
                                            class="col-lg-4 col-md-4 col-sm-6 col-6"
                                            v-for="product in filtersearch"
                                            :key="product.id"
                                        >
                                            <button
                                                class="btn btn-sm"
                                                @click.prevent="
                                                    addToCart(product.id)
                                                "
                                            >
                                                <div
                                                    class="card"
                                                    style="
                                                        width: 8.5rem;
                                                        height: 18rem;
                                                        margin-bottom: 5px;
                                                    "
                                                >
                                                    <img
                                                        :src="product.image"
                                                        id="em_photo"
                                                        class="card-img-top"
                                                    />
                                                    <div class="card-body">
                                                        <h6 class="card-title">
                                                            {{
                                                                product.product_name
                                                            }}
                                                        </h6>
                                                        <span
                                                            class="badge badge-success"
                                                            v-if="
                                                                product.product_quantity >=
                                                                1
                                                            "
                                                            >Available
                                                            {{
                                                                product.product_quantity
                                                            }}
                                                        </span>
                                                        <span
                                                            class="badge badge-danger"
                                                            v-else
                                                            >Stock Out
                                                        </span>
                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  End TBAS HOME -->

                            <div
                                class="tab-pane fade"
                                id="profile"
                                role="tabpanel"
                                aria-labelledby="profile-tab"
                            >
                                <input
                                    type="text"
                                    v-model="getsearchTerm"
                                    class="form-control"
                                    style="width: 560px"
                                    placeholder="Search Product"
                                />

                                <div class="row">
                                    <div
                                        class="col-lg-3 col-md-3 col-sm-6 col-6"
                                        v-for="getproduct in getfiltersearch"
                                        :key="getproduct.id"
                                    >
                                        <button
                                            class="btn btn-sm"
                                            @click.prevent="
                                                addToCart(getproduct.id)
                                            "
                                        >
                                            <div
                                                class="card"
                                                style="
                                                    width: 8.5rem;
                                                    height: 18rem;
                                                    margin-bottom: 5px;
                                                "
                                            >
                                                <img
                                                    :src="getproduct.image"
                                                    id="em_photo"
                                                    class="card-img-top"
                                                />
                                                <div class="card-body">
                                                    <h6 class="card-title">
                                                        {{
                                                            getproduct.product_name
                                                        }}
                                                    </h6>
                                                    <span
                                                        class="badge badge-success"
                                                        v-if="
                                                            getproduct.product_quantity >=
                                                            1
                                                        "
                                                        >Available
                                                        {{
                                                            getproduct.product_quantity
                                                        }}
                                                    </span>
                                                    <span
                                                        class="badge badge-danger"
                                                        v-else
                                                        >Stock Out
                                                    </span>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Category Wise Product -->
                    </div>
                </div>
            </div>
        </div>
        <!--Row-->
    </div>
</template>

<script type="text/javascript">
export default {
    created() {
        if (!User.loggedIn()) {
            this.$router.push({ name: "/" });
        }
        this.allProduct();
        this.allCategory();
        this.allCustomer();
        this.cartProduct();
        this.vat();
        Reload.$on("afterAdd", () => {
            this.cartProduct();
        });
    },

    data() {
        return {
            customer_id: "",
            pay: "",
            due: "",
            payby: "",
            products: [],
            categories: "",
            getproducts: [],
            searchTerm: "",
            getsearchTerm: "",
            customers: "",
            errors: "",
            carts: [],
            vats: "",
        };
    },
    computed: {
        filtersearch() {
            return this.products.filter((product) => {
                return product.product_name.match(this.searchTerm);
            });
        },
        getfiltersearch() {
            return this.getproducts.filter((getproduct) => {
                return getproduct.product_name.match(this.getsearchTerm);
            });
        },
        qty() {
            let sum = 0;
            for (let i = 0; i < this.carts.length; i++) {
                sum += parseFloat(this.carts[i].pro_quantity);
            }
            return sum;
        },
        subtotal() {
            let sum = 0;
            for (let i = 0; i < this.carts.length; i++) {
                sum +=
                    parseFloat(this.carts[i].pro_quantity) *
                    parseFloat(this.carts[i].product_price);
            }
            return sum;
        },
    },

    methods: {
        // Cart Methods Here
        addToCart(id) {
            axios
                .get(`/api/addToCart/${id}`)
                .then(() => {
                    Reload.$emit("afterAdd");
                    Notification.cartSuccess();
                })
                .catch();
        },
        cartProduct() {
            axios
                .get("/api/cart/product/")
                .then(({ data }) => (this.carts = data))
                .catch();
        },
        removeItem(id) {
            axios
                .get("/api/remove/cart/" + id)
                .then(() => {
                    Reload.$emit("afterAdd");
                    Notification.cartDelete();
                })
                .catch();
        },
        increment(id) {
            axios
                .get("/api/increment/" + id)
                .then(() => {
                    Reload.$emit("afterAdd");
                    Notification.success();
                })
                .catch();
        },
        decrement(id) {
            axios
                .get("/api/decrement/" + id)
                .then(() => {
                    Reload.$emit("afterAdd");
                    Notification.success();
                })
                .catch();
        },
        vat() {
            axios
                .get("/api/vats/")
                .then(({ data }) => (this.vats = data))
                .catch();
        },
        orderDone() {
            let total = (this.subtotal * this.vats.vat) / 100 + this.subtotal;
            var data = {
                qty: this.qty,
                due: this.due,
                payby: this.payby,
                pay: this.pay,
                vat: this.vats.vat,
                total: total,
                subtotal: this.subtotal,
                customer_id: this.customer_id,
            };
            axios
                .post("/api/orderdone/", data)
                .then(() => {
                    Notification.success();
                    this.$router.push({ name: "home" });
                })
                .catch();
        },
        // End Cart Methods
        allProduct() {
            axios
                .get("/api/product/")
                .then(({ data }) => (this.products = data))
                .catch();
        },
        allCategory() {
            axios
                .get("/api/category/")
                .then(({ data }) => (this.categories = data))
                .catch();
        },
        allCustomer() {
            axios
                .get("/api/customer/")
                .then(({ data }) => (this.customers = data))
                .catch();
        },

        subproduct(id) {
            axios
                .get("/api/getting/product/" + id)
                .then(({ data }) => (this.getproducts = data))
                .catch();
        },
    },
};
</script>

<style type="text/css" scoped>
#em_photo {
    height: 100px;
    width: 135px;
}
.qty_number {
    margin: 0px 3px;
}
.qty_pro {
    display: flex;
}
</style>
