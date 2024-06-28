// External Dependencies
import React, { Component } from 'react';

// Internal Dependencies
import './style.css';


class CustomGNPostSelector extends Component {
  static slug = 'gnwebdevcy_custom_gn_post_selector';

  render() {
    const Content = this.props.content;

    return (
      <h1>
        <Content/>
      </h1>
    );
  }
}

export default CustomGNPostSelector;
