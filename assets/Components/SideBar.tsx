import { Container, ListGroup, ListGroupItem } from "reactstrap";

export default function SideBar(){
    return (
        <div className="bg-secondary border-end border-primary vh-100">
            <ListGroup className="pt-5" flush>
                <ListGroupItem action tag="button">Dashboard</ListGroupItem>
            </ListGroup>
        </div>
    )
}