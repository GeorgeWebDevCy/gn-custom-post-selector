// External Dependencies
import $ from 'jquery';

// Internal Dependencies
import modules from './modules';
import fields from './fields';

$(window).on('et_builder_api_ready', (event, API) => {
  API.registerModules(modules);
  API.registerModalFields(fields);

  const fetchPosts = (postType, search, callback) => {
    $.ajax({
      url: window.ajaxurl,
      method: 'GET',
      data: {
        action: 'gncps_get_posts',
        post_type: postType,
        search: search || ''
      },
      success: (resp) => {
        if (resp.success) {
          callback(resp.data);
        }
      }
    });
  };

  const updatePosts = (modal) => {
    const postType = modal.find('select[name$="post_type"]').val() || 'post';
    const search = modal.find('.gncps-search-input').val() || '';
    fetchPosts(postType, search, (posts) => {
      const container = modal.find('[data-field-key="posts"] .et-pb-option-container');
      if (!container.length) return;
      const selected = {};
      container.find('input:checked').each(function(){ selected[$(this).val()] = true; });
      container.empty();
      posts.forEach((p) => {
        const checked = selected[p.id] ? ' checked="checked"' : '';
        container.append(`<label class="et_pb_checkbox_label"><input type="checkbox" value="${p.id}"${checked}> ${p.title}</label>`);
      });
    });
  };

  $(document).on('et_builder_open_settings', (e, modal) => {
    const $modal = $(modal);
    const postsField = $modal.find('[data-field-key="posts"]');
    if (!postsField.length) return;
    if (!postsField.data('gncps-initialized')) {
      postsField.data('gncps-initialized', true);
      postsField.find('.et-pb-option-container').before('<input type="text" class="gncps-search-input" placeholder="Search posts..." style="margin-bottom:10px;width:100%;" />');
      postsField.on('keyup', '.gncps-search-input', () => updatePosts($modal));
      $modal.find('select[name$="post_type"]').on('change', () => updatePosts($modal));
    }
    updatePosts($modal);
  });
});
