import { createRouter, createWebHistory } from 'vue-router'

import AppLayout from '../components/layouts/AppLayout.vue'
import Home from '../components/Home.vue'
import UsersIndex from '../components/users/UsersIndex.vue'
import UserCreate from '../components/users/UserCreate.vue'
import IncomeCreate from '../components/finance/IncomeCreate.vue'
import IncomeList from '../components/finance/IncomeList.vue'
import IncomeCategoryCreate from '../components/finance/IncomeCategoryCreate.vue'
import IncomeCategoryList from '../components/finance/IncomeCategoryList.vue'
import ExpenseCategoryCreate from '../components/finance/ExpenseCategoryCreate.vue'
import ExpenseCategoryList from '../components/finance/ExpenseCategoryList.vue'
import ExpenseCreate from '../components/finance/ExpenseCreate.vue'
import ExpenseList   from '../components/finance/ExpenseList.vue'

const routes = [
    {
        path: '/',
        component: AppLayout,
        children: [
            { path: '', name: 'home', component: Home },
            { path: 'users', name: 'users.index', component: UsersIndex },
            { path: 'users/create', name: 'users.create', component: UserCreate },
            { path: 'incomes', name: 'incomes.index', component: IncomeList },
            { path: 'incomes/create', name: 'incomes.create', component: IncomeCreate },
            { path: 'income-categories/create', name: 'income-categories.create', component: IncomeCategoryCreate },
            { path: 'income-categories', name: 'incomeCategories.index', component: IncomeCategoryList },
            { path: 'expense-categories', name: 'expenseCategories.index', component: ExpenseCategoryList },
            { path: 'expense-categories/create', name: 'expenseCategories.create', component: ExpenseCategoryCreate },
            { path: 'expenses',          name:'expenses.index', component: ExpenseList   },
            { path: 'expenses/create',    name: 'expenses.create', component: ExpenseCreate },
        ]
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
