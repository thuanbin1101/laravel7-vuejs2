<template>
    <div>
        <div class="row">
            <router-link to="/supplier/create" class="btn btn-primary"
                >Add Supplier</router-link
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
                            Supplier List
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Photo</th>
                                    <th>Phone</th>
                                    <th>Shopname</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(supplier, index) in filterSearch"
                                    :key="index"
                                >
                                    <td>
                                        <a href="#">{{ supplier.name }}</a>
                                    </td>
                                    <td>
                                        <img
                                            :src="supplier.photo"
                                            width="40px"
                                            height="40px"
                                            alt=""
                                        />
                                    </td>
                                    <td>{{ supplier.phone }}</td>
                                    <td>{{ supplier.shopname }}</td>

                                    <td>
                                        <router-link
                                            :to="{
                                                name: 'supplier.edit',
                                                params: { id: supplier.id },
                                            }"
                                            class="btn btn-sm btn-primary"
                                            >Detail</router-link
                                        >
                                        <a
                                            href="#"
                                            @click="deleteSupplier(supplier.id)"
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
        this.allSupplier();
    },
    data() {
        return {
            suppliers: [],
            searchTerm: "",
        };
    },
    computed: {
        filterSearch() {
            console.log(1);
            return this.suppliers.filter((supplier) => {
                return supplier.phone.match(this.searchTerm);
            });
        },
    },
    methods: {
        allSupplier() {
            axios
                .get("/api/supplier")
                .then(({ data }) => {
                    this.suppliers = data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        deleteSupplier(id) {
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
                        .delete(`/api/supplier/${id}`)
                        .then((result) => {
                            this.suppliers = this.suppliers.filter(
                                (supplier) => {
                                    return supplier.id != id;
                                }
                            );
                        })
                        .catch((err) => {
                            this.$router.push({ name: "supplier.index" });
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
