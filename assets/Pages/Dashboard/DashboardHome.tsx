import React, { Suspense } from "react";
import { Await, useLoaderData, useNavigate } from "react-router";
import { Button, Card, CardBody, CardHeader, Container } from "reactstrap";
import { sendDataLoader } from "../../Utils/Utils";

export const dashboardLoader = sendDataLoader("/dashboard", "GET");

export default function DashboardHome(): React.JSX.Element {
    
    const { data } = useLoaderData<typeof dashboardLoader>();
    const navigate = useNavigate();

    return (
        <Container className="position-relative">
            <Card color="primary" outline>
                <CardHeader>
                    Dashboard
                </CardHeader>
                <CardBody>
                    <Suspense fallback={<div>Loading ...</div>}>
                        <Await resolve={data}>
                            {(value) => (
                                <div>
                                    {JSON.stringify(value)}
                                </div>
                            )}
                            
                        </Await>
                    </Suspense>
                </CardBody>
            </Card>
            <Button className={"position-absolute top-0 end-0 m-2"} onClick={() => navigate('/games')} color="primary" >
                <i className={"bi bi-plus-lg"}></i> Create a new server
            </Button>
        </Container>
    );
}