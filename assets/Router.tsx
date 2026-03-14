import { createBrowserRouter, Navigate, RouterProvider } from 'react-router'
import DashboardHome, { dashboardLoader } from "./Pages/Dashboard/DashboardHome"
import Navbar from './Components/NavBar'
import SideBar from './Components/SideBar'
import { Col, Row } from 'reactstrap'
import GameListHome, { GameListLoader } from './Pages/Games/GameListHome'
import ServersListHome, { ServersListLoader } from './Pages/Servers/ServersListHome'
import ServerHome, { ServerHomeLoader } from './Pages/Servers/ServerHome'

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
    {
        path: "/games/:gameSlug",
        element: <ServersListHome />,
        loader: ServersListLoader
    },
    {
        path: "/games/:gameSlug/:apiSlug/:serverId",
        element: <ServerHome />,
        loader: ServerHomeLoader
    }
])

export default function Router() {
    return (
        <Row className='text-body vw-100 vh-100 g-0'>
            <Col xs={2} className={'d-none d-sm-block'} >
                <SideBar />
            </Col>
            <Col xs={12} sm={10} className='h-100 d-flex flex-column'>
                <Navbar/>
                <div className='flex-grow-1 overflow-y-scroll p-2'>
                    <RouterProvider router={router} />
                </div>
                
            </Col>
        </Row>
    )
}