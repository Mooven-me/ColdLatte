import React from "react";
import GameCard from "./GameCard";
import ServerCard from "./ServerCard";

type GameProps = React.ComponentProps<typeof GameCard>;
type ServerProps = React.ComponentProps<typeof ServerCard>;

type CardFactoryProps = 
    ({ type: "game" } & GameProps)
  | ({ type: "server" } & ServerProps);

export default function CardFactory(props: CardFactoryProps) {
  const { type, ...cardProps } = props;

  const Components = {
    game: GameCard,
    server: ServerCard,
  };

  const Component = Components[type] as React.ElementType;

  return (
    <Component {...cardProps} />
  );
}