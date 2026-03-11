import { components } from "../../api-types"

type ClassImageModel = components["schemas"]["ClassImage"]

export default function ClassImage(props: ClassImageModel){
    return <i className={props.image + " " + props.color}>{props.text}</i>
}