import { Await, LoaderFunctionArgs, useLoaderData, useNavigate, useParams } from "react-router";
import { apiClient, formatNumber } from "../../Utils/Utils";
import { Suspense } from "react";
import { Button, Card, Col, Container, Row } from "reactstrap";
import ImageFactory from "../../Components/Image/ImageFactory";

export const ServerHomeLoader = ({ params }: LoaderFunctionArgs) => (
    {
        response: apiClient.GET("/api/v1/servers/{apiSlug}/{serverId}", {
            params: {
                path: {
                    apiSlug: params.apiSlug as string, 
                    serverId: params.serverId as string 
                }
            }
        })
    }
)

export const CreateServer = ({ params }: LoaderFunctionArgs) => (
    {
        response: apiClient.POST("/api/v1/servers/{apiSlug}/{serverId}", {
            params: {
                path: {
                    apiSlug: params.apiSlug as string, 
                    serverId: params.serverId as string 
                }
            }
        })
    }
)
 
export default function ServerHome(){
    const { response } = useLoaderData<typeof ServerHomeLoader>()
    const navigate = useNavigate();
    const params = useParams();
    return (
        <Suspense>
            <Await resolve={response}>
                {({ data }) => {
                        if(!data?.server){
                            return <>An error append, please reload the page</>
                        }
                        let server = data.server
                        return (
                            <Container>
                                <Row className="g-3">
                                    <Col xs={12}>
                                        <Card outline color={"primary"} className={"shadow overflow-hidden d-flex flex-row"}>
                                            <img src={server.imageUrl} style={{height:"200px", width:"200px", filter: "drop-shadow(5px 5px 5px #464646)"}} className="m-1 rounded"/>
                                            <div className="mx-2 d-flex flex-column justify-content-between align-content-center gap-1">
                                                <div className="d-flex flex-row align-items-center justify-content-between flex-wrap">
                                                    <h4 className="font-weight-bold mb-0">
                                                        <strong>{server.title}</strong>
                                                    </h4>
                                                    <div className="fst-italic">
                                                        by {server.author}
                                                    </div>
                                                </div>
                                                <div className="">
                                                    {server.summary}
                                                </div>
                                                <div className="d-flex flex-row mb-2 flex-wrap column-gap-4">
                                                    <ImageFactory {...server.apiLogo} />
                                                    <div className="d-flex flex-row gap-2"><ImageFactory image={"bi bi-download"} type={"class"} color={null} /><strong>{formatNumber(server.downloadCount)}</strong></div>
                                                    {server.date && <div className="d-flex flex-row gap-2"><ImageFactory image="bi bi-calendar-plus" type="class" color={null}/>{server.date}</div>}
                                                    {server.version && <div className="d-flex flex-row gap-2"><ImageFactory image="bi bi-controller" type="class" color={null}/>{server.version}</div>}
                                                    {server.additionalData && <div>{server.additionalData}</div>}
                                                </div>
                                                {server.categories && 
                                                    <div className="d-flex flex-row flex-wrap column-gap-2">
                                                        {server.categories.map((category, index) => {
                                                            return <>
                                                                {index!==0 && <div className="vr" />}
                                                                <div key={index}>{category}</div>
                                                            </>
                                                        }
                                                        )}
                                                    </div>
                                                }
                                            </div>
                                        </Card>
                                    </Col>
                                    <Col xs={12} sm={6}>
                                        <Card color="primary" outline className="d-flex flex-row align-items-center gap-2 p-2 justify-content-between">
                                            <div>
                                                Requirement (//TODO) tkt 8Go de ram 
                                            </div>
                                            <div className="justify-content-center w-auto>">
                                                <Button color="primary" onClick={() => CreateServer({params} as LoaderFunctionArgs)}>Start the server</Button>
                                            </div>
                                        </Card>
                                    </Col>
                                    <Col xs={12} sm={6}>
                                    </Col>
                                </Row>
                            </Container>
                        )
                    }
                }
            </Await>
        </Suspense>
    )
}