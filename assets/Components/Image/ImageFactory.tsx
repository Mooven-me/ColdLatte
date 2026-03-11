import React from "react";
import ClassImage from "./ClassImage";

type ImageFactoryProps = 
  | ({ type: "class" } & React.ComponentProps<typeof ClassImage>);

export default function ImageFactory(props: ImageFactoryProps) {
  const { type, ...cardProps } = props;

  const Components = {
    class: ClassImage,
  };

  const Component = Components[type] as React.ElementType;

  return (
    <Component {...cardProps} />
  );
}