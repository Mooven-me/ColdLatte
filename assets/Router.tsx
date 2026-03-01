import { createBrowserRouter, Navigate, RouterProvider } from 'react-router'
import DashboardHome, { dashboardLoader } from "./Pages/Dashboard/DashboardHome"
import Navbar from './Components/NavBar'
import SideBar from './Components/SideBar'
import { Col, Row } from 'reactstrap'

let router = createBrowserRouter([
    {
        path: "/",
        element: <Navigate to={"/dashboard"}/>
    },
    {
        path: "/dashboard",
        element: <DashboardHome/>,
        loader: dashboardLoader
    }
])

export default function Router() {
    return (
        <Row className='text-body vw-100 g-0'>
            <Col xs={2}>
                <SideBar />
            </Col>
            <Col>
                <Navbar/>
                <RouterProvider router={router} />
            </Col>
        </Row>
    )
}