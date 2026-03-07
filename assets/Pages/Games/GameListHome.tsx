import { Await, useLoaderData, useNavigate } from "react-router";
import { sendDataLoader } from "../../Utils/Utils";
import { Suspense } from "react";
import ImageCard from "../../Components/ImageCard";
import { Col, Row } from "reactstrap";

export const GameListLoader = sendDataLoader("/v1/games", "GET");

export default function GameListHome() {
    const { data } = useLoaderData<typeof GameListLoader>()
    const navigate = useNavigate();
    return (
        <Suspense>
            <Await resolve={data}>
                {(result) => {
                        if('error' in result){
                            return <>An error append : {result.error_message}</>
                        }
                        return (
                            <Row>
                                {
                                    result.games.map((game, index) =>
                                        <Col xs={12} lg={6} xxl={4} key={index} className="p-3">
                                            <ImageCard
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