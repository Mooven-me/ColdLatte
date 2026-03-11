import { Await, useLoaderData, useNavigate } from "react-router";
import { apiClient } from "../../Utils/Utils";
import { Suspense } from "react";
import { Col, Container, Row } from "reactstrap";
import CardFactory from "../../Components/Card/CardFactory";

export const GameListLoader = () => (
    {
        response: apiClient.GET("/api/v1/games")
    }
)

export default function GameListHome() {
    const { response } = useLoaderData<typeof GameListLoader>()
    const navigate = useNavigate();
    return (
        <Suspense>
            <Await resolve={response}>
                {({ data }) => {
                        if(!data){
                            return <>An error append, please reload the page</>
                        }
                        return (
                            <Row className="gx-0">
                            {
                                data.games.map((game, index) =>
                                    <Col xs={12} lg={6} key={index} className="p-3">
                                        <CardFactory
                                            type={"game"}
                                            {...game}
                                            onClick={() => navigate(game.slug)}
                                        />
                                    </Col>
                                )
                            }
                            </Row>
                            
                        )
                    }
                }
            </Await>
        </Suspense>
    )
}