import { useLoaderData } from "react-router";
import { sendDataLoader } from "../../Utils/Utils";

const ServersListLoader = sendDataLoader('/v1/servers', 'GET')

export default function ServersListHome(){
    const { data } = useLoaderData<typeof ServersListLoader>()
}