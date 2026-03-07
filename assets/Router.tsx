import { createBrowserRouter, Navigate, RouterProvider } from 'react-router'
import DashboardHome, { dashboardLoader } from "./Pages/Dashboard/DashboardHome"
import Navbar from './Components/NavBar'
import SideBar from './Components/SideBar'
import { Col, Row } from 'reactstrap'
import GameListHome, { GameListLoader } from './Pages/Games/GameListHome'

let router = createBrowserRouter([
    {
        path: "/",
        element: <Navigate to={"/dashboard"}/>
    },
    {
        path: "/dashboard",
        element: <DashboardHome/>,
        loader: dashboardLoader
    },
    {
        path: "/games",
        element: <GameListHome/>,
        loader: GameListLoader
    },
])

export default function Router() {
    return (
        <Row className='text-body vw-100 vh-100 g-0'>
            <Col xs={2}>
                <SideBar />
            </Col>
            <Col xs={10} className='h-100 d-flex flex-column'>
                <Navbar/>
                <div className='flex-grow-1 overflow-y-scroll p-2'>
                    <RouterProvider router={router} />
                </div>
                
            </Col>
        </Row>
    )
}