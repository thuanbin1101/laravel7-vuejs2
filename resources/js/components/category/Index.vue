<template>
    <div>
        <div class="row">
            <router-link to="/category/create" class="btn btn-primary"
                >Add Category</router-link
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
                            Category List
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(category, index) in filterSearch"
                                    :key="index"
                                >
                                    <td>
                                        <a href="#">{{ category.name }}</a>
                                    </td>
                                    <td>
                                        <router-link
                                            :to="{
                                                name: 'category.edit',
                                                params: { id: category.id },
                                            }"
                                            class="btn btn-sm btn-primary"
                                            >Detail</router-link
                                        >
                                        <a
                                            href="#"
                                            @click="deleteCategory(category.id)"
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
        this.allCategory();
    },
    data() {
        return {
            categories: [],
            searchTerm: "",
        };
    },
    computed: {
        filterSearch() {
            return this.categories.filter((category) => {
                return category.name.match(this.searchTerm);
            });
        },
    },
    methods: {
        allCategory() {
            axios
                .get("/api/category")
                .then(({ data }) => {
                    this.categories = data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        deleteCategory(id) {
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
                        .delete(`/api/category/${id}`)
                        .then((result) => {
                            this.categories = this.categories.filter(
                                (category) => {
                                    return category.id != id;
                                }
                            );
                        })
                        .catch((err) => {
                            this.$router.push({ name: "category.index" });
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
