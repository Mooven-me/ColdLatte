import React, { Suspense } from "react";
import { Await, useLoaderData } from "react-router";
import { Card, CardBody, CardHeader, Container } from "reactstrap";

// Import the generated components from our new file
import { components } from "../../api-types";

// Dig into the generated types to find the response for the Dashboard route.
// It will perfectly match what you wrote in the PHP controller!
type DashboardResponse = components["schemas"]["DashboardApiResponse"] 

export interface DashboardLoaderResult {
    dashboardPromise: Promise<DashboardResponse>;
}

export async function loadData(): Promise<DashboardLoaderResult> {
    const dashboardPromise = fetch('/api/dashboard').then((res) => {
        if (!res.ok) throw new Error("Failed");
        // Cast it to our generated type
        return res.json() as Promise<DashboardResponse>;
    });
    
    return { dashboardPromise };
}

export default function DashboardHome(): React.JSX.Element {
    
    const { dashboardPromise } = useLoaderData();

    return (
        <Container>
            <Card color="primary">
                <CardHeader>
                    Dashboard
                </CardHeader>
                <CardBody>
                    <Suspense fallback={<div>Loading ...</div>}>
                        <Await resolve={dashboardPromise}>
                            {(value: DashboardApiResponse) => (
                                <div>
                                    <h3>{value.title}</h3>
                                    <p>Total Users: {value.metrics.totalUsers}</p>
                                    <p>Total Revenue: ${value.metrics.revenue}</p>
                                    
                                    <hr />
                                    <small className="text-muted">Raw Data:</small>
                                    <pre>{JSON.stringify(value, null, 2)}</pre>
                                </div>
                            )}
                            
                        </Await>
                    </Suspense>
                </CardBody>
            </Card>
        </Container>
    );
}