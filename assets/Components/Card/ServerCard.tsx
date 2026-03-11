import { Card } from "reactstrap"
import { components } from "../../api-types"
import ImageFactory from "../Image/ImageFactory"
import { formatNumber, truncate } from "../../Utils/Utils"

type ServerModel = components["schemas"]["Server"]

type ImageCardProps = ServerModel & {
    onClick?: React.MouseEventHandler<HTMLElement>
}

export default function ServerCard(props: ImageCardProps
){
    return (
        <Card outline color={"primary"} className={"shadow overflow-hidden d-flex flex-row " + (props.onClick && "hover-zoom ")} style={{cursor:(props.onClick? "pointer" : "")}} onClick={props.onClick}>
            <img src={props.imageUrl} style={{height:"128px", width:"128px", filter: "drop-shadow(5px 5px 5px #464646)"}} className="m-1 rounded"/>
            <div className="mx-2 d-flex flex-column justify-content-between align-content-center gap-1">
                <div className="d-flex flex-row align-items-center justify-content-between flex-wrap">
                    <h4 className="font-weight-bold mb-0">
                        <strong>{props.title}</strong>
                    </h4>
                    <div className="fst-italic">
                        by {props.author}
                    </div>
                </div>
                <div className="">
                    {truncate(props.summary, 80)}
                </div>
                <div className="d-flex flex-row mb-2 flex-wrap column-gap-4">
                    <ImageFactory {...props.apiLogo} />
                    <div className="d-flex flex-row gap-2"><ImageFactory image={"bi bi-download"} type={"class"} color={null} /><strong>{formatNumber(props.downloadCount)}</strong></div>
                    {props.date && <div className="d-flex flex-row gap-2"><ImageFactory image="bi bi-calendar-plus" type="class" color={null}/>{props.date}</div>}
                    {props.version && <div className="d-flex flex-row gap-2"><ImageFactory image="bi bi-controller" type="class" color={null}/>{props.version}</div>}
                    {props.additionalData && <div>{props.additionalData}</div>}
                </div>
                {props.categories && 
                    <div className="d-flex flex-row flex-wrap column-gap-2">
                        {props.categories.map((category, index) => {
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
    )
}