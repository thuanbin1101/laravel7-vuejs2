<template>
    <div>
        <div class="row">
            <router-link to="/supplier" class="btn btn-primary"
                >All Supplier</router-link
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
                                            Edit Supplier
                                        </h1>
                                    </div>
                                    <form
                                        class="user"
                                        @submit.prevent="supplierUpdate"
                                        enctype="multipart/form-data"
                                    >
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label>Full Name</label>
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
                                                <div class="col-md-6">
                                                    <label>Email</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="exampleInputLastName"
                                                        placeholder="Enter Full Name"
                                                        v-model="form.email"
                                                    />
                                                    <small
                                                        class="text-danger"
                                                        v-if="errors.email"
                                                        >{{
                                                            errors.email[0]
                                                        }}</small
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label>Address</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="exampleInputLastName"
                                                        placeholder="Enter Full Name"
                                                        v-model="form.address"
                                                    />
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Phone</label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id="exampleInputLastName"
                                                        placeholder="Enter Full Name"
                                                        v-model="form.phone"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label>Shop Name</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="exampleInputLastName"
                                                        placeholder="Enter Full Name"
                                                        v-model="form.shopname"
                                                    />
                                                </div>
                                                <div class="col-md-6">
                                                    <label>File</label>
                                                    <div class="custom-file">
                                                        <input
                                                            type="file"
                                                            class="custom-file-input"
                                                            id="customFile"
                                                            @change="
                                                                onFileSelected
                                                            "
                                                        />
                                                        <label
                                                            class="custom-file-label"
                                                            for="customFile"
                                                            >Choose file</label
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6"></div>
                                                <div class="col-md-6">
                                                    <img
                                                        :src="form.photo"
                                                        alt=""
                                                        height="40px"
                                                        width="40px"
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
            .get("/api/supplier/" + id)
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
                email: "",
                phone: "",
                address: "",
                shopname: "",
                photo: "",
                newphoto: "",
            },
            errors: {},
        };
    },
    methods: {
        onFileSelected(event) {
            let file = event.target.files[0];
            if (file.size > 1048770) {
                Notification.image_validation();
            } else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.form.newphoto = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        supplierUpdate() {
            let id = this.$route.params.id;
            axios
                .patch("/api/supplier/" + id, this.form)
                .then(() => {
                    this.$router.push({ name: "supplier.index" });
                    Notification.success();
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
    },
};
</script>
