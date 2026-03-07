import { Card } from "reactstrap"

type ImageCardProps=  {
    title: string,
    imageUrl: string,
    onClick?: React.MouseEventHandler<HTMLElement>
    coverUrl?: string | null
}

export default function ImageCard(props: ImageCardProps
){
    return (
        <Card outline color={"primary"} className={"shadow overflow-hidden " + (props.onClick && "hover-zoom ")} style={{cursor:(props.onClick? "pointer" : ""), maxHeight:"128px"}} onClick={props.onClick}>
            {props.coverUrl && 
                <img 
            src={props.coverUrl}
            style={{
                maskImage: "linear-gradient(to bottom, black 20%, transparent 100%)",
                minHeight: "64px",
                aspectRatio: "1920/282",
                objectFit: "cover",
                objectPosition: "center"
            }} 
        />
            }
            <img src={props.imageUrl} style={{height:"64px", width:"64px", filter: "drop-shadow(5px 5px 5px #464646)"}} className="m-1 rounded position-absolute"/>
            <b className="m-2">{props.title}</b>
        </Card>
    )
}