import React from "react";
import PropTypes from "prop-types";
import { ListGroupItem } from "reactstrap";

class ListItem extends React.Component {
  static propTypes = {
    children: PropTypes.node
  };

  render() {
    return (
        <ListGroupItem key={this.props.key}>
            {this.props.children}
        </ListGroupItem>
    );
  }
}

export default ListItem;
