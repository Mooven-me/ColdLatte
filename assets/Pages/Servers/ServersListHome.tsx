import { Await, LoaderFunctionArgs, useLoaderData, useNavigate, useParams } from "react-router";
import { apiClient } from "../../Utils/Utils";
import { Suspense } from "react";
import { Col, Row } from "reactstrap";
import CardFactory from "../../Components/Card/CardFactory";

export const ServersListLoader = ({ params }: LoaderFunctionArgs) => (
    {
        response: apiClient.GET("/api/v1/servers/{gameSlug}", {
            params: {
                path: {
                    gameSlug: params.gameSlug as string 
                }
            }
        })
    }
)
export default function ServersListHome(){
    const { response } = useLoaderData<typeof ServersListLoader>()
    const navigate = useNavigate();
    return (
        <Suspense>
            <Await resolve={response}>
                {({ data }) => {
                        if(!data){
                            return <>An error append, please reload the page</>
                        }
                        return (
                            <Row>
                                {
                                    data.servers.map((server, index) =>
                                        <Col xs={12} lg={6}  key={index} className="p-3">
                                            <CardFactory
                                                type={"server"}
                                                {...server}
                                                onClick={() => navigate(server.api+'/'+server.id)}
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