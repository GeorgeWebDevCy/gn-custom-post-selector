// External Dependencies
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import $ from 'jquery';

// Internal Dependencies
import './style.css';

class CustomGNPostSelector extends Component {
  static slug = 'gnwebdevcy_custom_gn_post_selector';

  state = {
    posts: [],
  };

  componentDidMount() {
    this.fetchPosts(this.props.post_type);
  }

  componentDidUpdate(prevProps) {
    if (prevProps.post_type !== this.props.post_type) {
      this.fetchPosts(this.props.post_type);
    }
  }

  fetchPosts = (postType) => {
    if (postType) {
      $.ajax({
        url: gnwebdevcy_data.ajax_url,
        method: 'POST',
        data: {
          action: 'gnwebdevcy_get_posts_by_type',
          nonce: gnwebdevcy_data.nonce,
          post_type: postType,
        },
        success: (response) => {
          if (response.success) {
            this.setState({ posts: response.data });
          }
        },
        error: (error) => {
          console.error('Error fetching posts:', error);
        },
      });
    }
  };

  handlePostSelection = (event) => {
    const { value, checked } = event.target;
    let selectedPosts = this.props.posts.split('|');
    if (checked) {
      selectedPosts.push(value);
    } else {
      selectedPosts = selectedPosts.filter((id) => id !== value);
    }
    this.props.onChange({ posts: selectedPosts.join('|') });
  };

  render() {
    const { title, posts: selectedPosts } = this.props;
    const { posts } = this.state;

    return (
      <div className="custom-gn-post-selector">
        {title && <h2>{title}</h2>}
        <ul>
          {posts.map((post) => (
            <li key={post.id}>
              <input
                type="checkbox"
                value={post.id}
                checked={selectedPosts.split('|').includes(String(post.id))}
                onChange={this.handlePostSelection}
              />
              {post}
            </li>
          ))}
        </ul>
      </div>
    );
  }
}

CustomGNPostSelector.propTypes = {
  title: PropTypes.string,
  post_type: PropTypes.string,
  posts: PropTypes.string, // Pipe-separated string of selected post IDs
  onChange: PropTypes.func.isRequired,
};

export default CustomGNPostSelector;