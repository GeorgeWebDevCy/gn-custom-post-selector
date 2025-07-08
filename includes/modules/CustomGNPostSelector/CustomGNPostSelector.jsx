// External Dependencies
import React, { Component } from 'react';
import PropTypes from 'prop-types';

// Internal Dependencies
import './style.css';

class CustomGNPostSelector extends Component {
  static slug = 'gnwebdevcy_custom_gn_post_selector';

  constructor(props) {
    super(props);
    this.state = { logs: [] };
  }

  log(message, data) {
    if (window && window.console) {
      console.debug(message, data);
    }
    const entry = `${message} ${JSON.stringify(data)}`;
    this.setState((state) => ({ logs: [...state.logs, entry] }));
  }

  componentDidMount() {
    this.log('GN Custom Post Selector mounted', this.props);
  }

  componentDidUpdate(prevProps) {
    this.log('GN Custom Post Selector updated', { prevProps, currentProps: this.props });
  }

  render() {
    const { title, posts: selectedPosts } = this.props;
    const { logs } = this.state;

    return (
      <div className="custom-gn-post-selector">
        {title && <h2>{title}</h2>}
        <ul>
          {selectedPosts.split('|').map((postId) => (
            <li key={postId}>{postId}</li> // Update this line to show post titles if available
          ))}
        </ul>
        {logs.length > 0 && (
          <pre className="gncps-debug">
            {logs.join('\n')}
          </pre>
        )}
      </div>
    );
  }
}

CustomGNPostSelector.propTypes = {
  title: PropTypes.string,
  posts: PropTypes.string, // Pipe-separated string of selected post IDs
};

export default CustomGNPostSelector;