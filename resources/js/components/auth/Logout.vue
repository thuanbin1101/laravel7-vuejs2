<template>
    <div></div>
</template>
<script>
export default {
    created() {
        localStorage.removeItem("token");
        localStorage.removeItem("user");
        Toast.fire({
            icon: "success",
            title: "Signed in successfully",
        });
        this.$router.push({ name: "home" }); 
    },
};
</script>
<style></style>
