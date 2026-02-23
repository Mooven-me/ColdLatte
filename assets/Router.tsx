import React from "react"
import { Button } from 'reactstrap'
import { createBrowserRouter, RouterProvider } from 'react-router'
import DashboardHome, { loadData } from "./Pages/Dashboard/DashboardHome"

let router = createBrowserRouter([
    {
        path: "/dashboard",
        element: <DashboardHome/>,
        loader: loadData
    }
])

export default function Router() {
    return (
        <RouterProvider router={router} />
    )
}