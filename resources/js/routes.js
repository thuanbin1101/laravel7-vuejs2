import Login from "./components/auth/Login.vue";
import Register from "./components/auth/Register.vue";
import Logout from "./components/auth/Logout.vue";

// End authentication

import Home from "./components/Home.vue";
// Employee
import CreateEmployee from "./components/employee/Create.vue";
import IndexEmployee from "./components/employee/Index.vue";
import EditEmployee from "./components/employee/Edit.vue";

// Supplier
import CreateSupplier from "./components/supplier/Create.vue";
import IndexSupplier from "./components/supplier/Index.vue";
import EditSupplier from "./components/supplier/Edit.vue";

// Category
import CreateCategory from "./components/category/Create.vue";
import IndexCategory from "./components/category/Index.vue";
import EditCategory from "./components/category/Edit.vue";

// Product
import CreateProduct from "./components/product/Create.vue";
import IndexProduct from "./components/product/Index.vue";
import EditProduct from "./components/product/Edit.vue";

// Expense
import CreateExpense from "./components/expense/Create.vue";
import IndexExpense from "./components/expense/Index.vue";
import EditExpense from "./components/expense/Edit.vue";

// Salary
import PaySalary from "./components/salary/Create.vue";
import Salary from "./components/salary/all_employee.vue";
import AllSalary from "./components/salary/Index.vue";
import ViewSalary from "./components/salary/View.vue";
import EditSalary from "./components/salary/Edit.vue";

// Stock
import Stock from "./components/product/Stock.vue";
import EditStock from "./components/product/EditStock.vue";

// Customer
import CreateCustomer from "./components/customer/Create.vue";
import IndexCustomer from "./components/customer/Index.vue";
import EditCustomer from "./components/customer/Edit.vue";

// POS
import Pos from "./components/pos/pointofsale.vue";

// Order
import Order from "./components/order/order.vue";
import OrderAll from "./components/order/orderall.vue";
import ViewOrder from "./components/order/vieworder.vue";
import SearchOrder from "./components/order/search.vue";


export const routes = [
    {
        path: "/",
        component: Login,
        name: "login",
    },
    {
        path: "/register",
        component: Register,
        name: "register",
    },
    {
        path: "/home",
        component: Home,
        name: "home",
    },
    {
        path: "/logout",
        component: Logout,
        name: "logout",
    },
    // Employee
    {
        path: "/employee/create",
        component: CreateEmployee,
        name: "employee.create",
    },
    {
        path: "/employee/edit/:id",
        component: EditEmployee,
        name: "employee.edit",
    },
    {
        path: "/employee",
        component: IndexEmployee,
        name: "employee.index",
    },
    // Supplier
    {
        path: "/supplier/create",
        component: CreateSupplier,
        name: "supplier.create",
    },
    {
        path: "/supplier/edit/:id",
        component: EditSupplier,
        name: "supplier.edit",
    },
    {
        path: "/supplier",
        component: IndexSupplier,
        name: "supplier.index",
    },

    // Category
    {
        path: "/category/create",
        component: CreateCategory,
        name: "category.create",
    },
    {
        path: "/category/edit/:id",
        component: EditCategory,
        name: "category.edit",
    },
    {
        path: "/category",
        component: IndexCategory,
        name: "category.index",
    },

    // Product
    {
        path: "/product/create",
        component: CreateProduct,
        name: "product.create",
    },
    {
        path: "/product/edit/:id",
        component: EditProduct,
        name: "product.edit",
    },
    {
        path: "/product",
        component: IndexProduct,
        name: "product.index",
    },

    // Expense
    {
        path: "/expense/create",
        component: CreateExpense,
        name: "expense.create",
    },
    {
        path: "/expense/edit/:id",
        component: EditExpense,
        name: "expense.edit",
    },
    {
        path: "/expense",
        component: IndexExpense,
        name: "expense.index",
    },

    // Salary
    {
        path: "/given-salary",
        component: Salary,
        name: "salary.given",
    },
    {
        path: "/pay-salary/:id",
        component: PaySalary,
        name: "salary.pay",
    },
    {
        path: "/salary",
        component: AllSalary,
        name: "salary.index",
    },
    {
        path: "/view-salary/:id",
        component: ViewSalary,
        name: "salary.view",
    },
    {
        path: "/edit-salary/:id",
        component: EditSalary,
        name: "salary.edit",
    },

    // Stock
    {
        path: "/stock",
        component: Stock,
        name: "stock.index",
    },
    {
        path: "/edit-stock/:id",
        component: EditStock,
        name: "stock.edit",
    },

    // Customer
    {
        path: "/customer/create",
        component: CreateCustomer,
        name: "customer.create",
    },
    {
        path: "/customer/edit/:id",
        component: EditCustomer,
        name: "customer.edit",
    },
    {
        path: "/customer",
        component: IndexCustomer,
        name: "customer.index",
    },
    // POS
    {
        path: "/pos",
        component: Pos,
        name: "pos",
    },

    // Order
    {
        path: "/order",
        component: Order,
        name: "order",
    },
    {
        path: "/order/all",
        component: OrderAll,
        name: "order.all",
    },
    {
        path: "/view-order/:id",
        component: ViewOrder,
        name: "order.view",
    },
    {
        path: "/search/order",
        component: SearchOrder,
        name: "order.search",
    },

];
