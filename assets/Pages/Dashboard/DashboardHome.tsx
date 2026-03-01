import React, { Suspense } from "react";
import { Await, useLoaderData } from "react-router";
import { Card, CardBody, CardHeader, Container } from "reactstrap";
import { sendData, sendDataLoader } from "../../Utils/Utils";

export const dashboardLoader = sendDataLoader("/dashboard", "GET");

export default function DashboardHome(): React.JSX.Element {
    
    const { data } = useLoaderData<typeof dashboardLoader>();

    return (
        <Container>
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
        </Container>
    );
}