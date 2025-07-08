// External Dependencies
import React, { Component } from 'react';
import PropTypes from 'prop-types';

// Internal Dependencies
import './style.css';

class CustomGNPostSelector extends Component {
  static slug = 'gnwebdevcy_custom_gn_post_selector';

  componentDidMount() {
    if (window && window.console) {
      console.debug('GN Custom Post Selector mounted', this.props);
    }
  }

  componentDidUpdate(prevProps) {
    if (window && window.console) {
      console.debug('GN Custom Post Selector updated', { prevProps, currentProps: this.props });
    }
  }

  render() {
    const {title, posts: selectedPosts } = this.props;

    return (
      <div className="custom-gn-post-selector">
        {title && <h2>{title}</h2>}
        <ul>
          {selectedPosts.split('|').map(postId => (
            <li key={postId}>{postId}</li> // Update this line to show post titles if available
          ))}
        </ul>
      </div>
    );
  }
}

CustomGNPostSelector.propTypes = {
  title: PropTypes.string,
  posts: PropTypes.string, // Pipe-separated string of selected post IDs
};

export default CustomGNPostSelector;